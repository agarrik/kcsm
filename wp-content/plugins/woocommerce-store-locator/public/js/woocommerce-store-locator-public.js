(function( $ ) {
	'use strict';

	// Create the defaults once
	var pluginName = "storeLocator",
		defaults = {
			propertyName: "value",
			store_modal: "#store_modal",
			store_modal_button: "#store_modal_button",
			store_modal_close: "#store_modal_close",
			map_container: "#store_locator_map",
			map_min_height: 300,
			store_locator_sidebar: '#store_locator_sidebar',
			result_list: "#store_locator_result_list",
			store_locator_address_field: '#store_locator_address_field',
			store_locator_find_stores_button: '#store_locator_find_stores_button',
			store_locator_loading: '#store_locator_loading',
			store_locator_filter_radius: '#store_locator_filter_radius',
			store_locator_filter_categories: '#store_locator_filter_categories',
			store_locator_filter: '#store_locator_filter',
			store_locator_filter_active_filter: '#store_locator_filter_active_filter',
			store_locator_filter_open_close: '#store_locator_filter_open_close',
			store_locator_filter_content: '#store_locator_filter_content',
			store_locator_filter_checkbox: '.store_locator_filter_checkbox',
			store_locator_get_my_position: '#store_locator_get_my_position',
			earthRadi: {
				mi: 3963.1676,
				km: 6378.1,
				ft: 20925524.9,
				mt: 6378100,
				"in": 251106299,
				yd: 6975174.98,
				fa: 3487587.49,
				na: 3443.89849,
				ch: 317053.408,
				rd: 1268213.63,
				fr: 31705.3408
			},
		};

	// The actual plugin constructor
	function Plugin ( element, options ) {
		this.element = element;
		this.settings = $.extend( {}, defaults, options );
		this._defaults = defaults;

		this._name = pluginName;
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend( Plugin.prototype, {
		init: function() {
			var that = this;
			this.window = $(window);
			this.documentHeight = $( document ).height();
			this.windowHeight = this.window.height();
			this.settings.mapDefaultZoom = parseInt(that.settings.mapDefaultZoom);
			this.templateCache = {};
			this.markers = [];
			this.ownMarker = {};
			this.radiusCircle = {};
			this.categories = {};
			this.filter = {};

			this.setResultListMaxHeight();

			// Check if we have a Modal Button (Product Page)
			if(!this.isEmpty($(this.settings.store_modal_button))){
				this.initModal(function(){
					that.initStoreLocator();
				});
			} else {
				$(this.settings.store_modal_close).hide();
				that.initStoreLocator();
			}
		},
		setResultListMaxHeight: function() {
			var resultList = $(this.settings.result_list);
			var store_locator_sidebar = $(this.settings.store_locator_sidebar);
			var height = store_locator_sidebar.height() - 200;

			resultList.css('max-height', height);
		},
		initModal: function(callback) {
			var store_modal = $(this.settings.store_modal);
			var store_modal_button = $(this.settings.store_modal_button);
			var store_modal_close = $(this.settings.store_modal_close);
			var that = this;

		    store_modal_button.on('click', function()
		    {
		    	store_modal.show();
			    store_modal.modal('show');
			    callback();
		    });

		    store_modal_close.on('click', function()
		    {
		    	store_modal.hide();
		    	$('.modal-backdrop').remove();
			    store_modal.modal('hide');
		    });
		},
		initStoreLocator: function() {
			var that = this;

			// Do not load Map again when Modal gets reopened
			if(that.isEmpty(that.map)){
				that.initMap(function(){
					if(that.settings.searchBoxAutocomplete === "1") {
						that.initAutocomplete();
					}
				    that.initStoreLocatorButton();
				    that.initGetCurrentPositionLink();
				    that.autoHeightMap();
				    that.geocoder = new google.maps.Geocoder();

				    that.initFilter();
					if(that.settings.searchBoxAutolocate === "1") {
						if(that.settings.searchBoxSaveAutolocate === "1") {
							that.getCurrentPosition();
						} else {
							that.getCurrentPosition(false);
						}					 
					}
				 //    that.window.resize(function() {
					// 	that.watchResize();
					// });
				    
				});
			}
		},
		initMap: function(callback) {
			var mapContainer = $(this.settings.map_container);
		    var mapDefaultZoom = this.settings.mapDefaultZoom;
		    var mapDefaultType = this.settings.mapDefaultType;
		    var mapDefaultLat = Number(this.settings.mapDefaultLat);
		    var mapDefaultLng = Number(this.settings.mapDefaultLng);

		    // Construct Map
		   	this.map = new google.maps.Map(mapContainer[0], {
				zoom: mapDefaultZoom,
				center: new google.maps.LatLng(mapDefaultLat, mapDefaultLng),
				mapTypeId: google.maps.MapTypeId[mapDefaultType],
				scrollwheel: false,
		    });

		    callback();
		},
		getCurrentPosition: function(useCookie) {
			var that = this;
			var cookieLat = that.getCookie('store_locator_lat');
			var cookieLng = that.getCookie('store_locator_lng');
			var currentPosition;
			if (typeof(useCookie)==='undefined') useCookie = true;

			if(cookieLat !== "" && cookieLng !== "" && useCookie === true){
				currentPosition = new google.maps.LatLng(cookieLat, cookieLng);
			}

			if(typeof(currentPosition) == "undefined") {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
						var geolocation = {
							lat: position.coords.latitude,
							lng: position.coords.longitude
						};
						
						var currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude); 
						document.cookie="store_locator_lat="+position.coords.latitude;
						document.cookie="store_locator_lng="+position.coords.longitude;
						that.setCurrentPosition(currentPosition);
					});
				} else {
					console.log('Browser Geolocation not supported!');
				}
			} else {
				that.setCurrentPosition(currentPosition);
			}
		},
		setCurrentPosition: function(latlng) {
			var store_locator_address_field = $(this.settings.store_locator_address_field);

			this.currentPosition = latlng;
			this.lat = latlng.lat();
			this.lng = latlng.lng();

			if(store_locator_address_field.val() === "") {

				this.geocodeLatLng(function(address){
					store_locator_address_field.val(address);
				});
			}

			// Delete old marker
			if(!this.isEmpty(this.ownMarker)) {
				this.ownMarker.setMap(null);
			}
			
			this.ownMarker = new google.maps.Marker({
				position: latlng,
				map: this.map,
				title: 'Your Position!',
				icon: this.settings.mapDefaultUserIcon
			});

			this.drawRadiusCircle();
			this.map.setCenter(this.currentPosition);
			this.getStores();

		},
		drawRadiusCircle: function() {
			var mapRadius;
			var distanceUnit = this.settings.mapDistanceUnit;
			var earthRadius = this.settings.earthRadi[distanceUnit];
			var selectedRadius = $(this.settings.store_locator_filter_radius).find(":selected").val();
			if(selectedRadius !== ""){
				this.radius = parseFloat(selectedRadius);
			} else {
				this.radius = parseFloat(this.settings.mapRadius);
			}

			if(!this.isEmpty(this.radiusCircle)) {
				this.radiusCircle.setMap(null);
			}

			if(this.settings.mapDrawRadiusCircle === "0"){
				return false;
			}

			mapRadius = (this.radius / earthRadius) * this.settings.earthRadi.mt;
			this.radiusCircle = new google.maps.Circle({
				center: this.currentPosition,
				clickable: true,
				draggable: false,
				editable: false,
				fillColor: '#004de8',
				fillOpacity: 0.27,
				map: this.map,
				radius: mapRadius,
				strokeColor: '#004de8',
				strokeOpacity: 0.62,
				strokeWeight: 1
			});
		},
		initAutocomplete: function() {
			var that = this;
			var addressField = $(this.settings.store_locator_address_field);
			var map = this.map;

			if ( !addressField) { return; }

			var autocomplete = new google.maps.places.Autocomplete(addressField[0], {types: ['geocode']});
			autocomplete.bindTo('bounds', map);

			autocomplete.addListener('place_changed', function(e){
				var place = autocomplete.getPlace();
				that.geocodeAddress(place.formatted_address);
			});
		},
		initStoreLocatorButton: function() {
			var that = this;
			var button = $(this.settings.store_locator_find_stores_button);
			var addressField = $(this.settings.store_locator_address_field);
			var currentAddress;

			button.on('click', function(e) {
				e.preventDefault();
				currentAddress = addressField.val();
				that.geocodeAddress(currentAddress);
			});
		},
		initGetCurrentPositionLink: function() {
			var that = this;
			var store_locator_get_my_position = $(this.settings.store_locator_get_my_position);
			
			store_locator_get_my_position.on('click', function(e){
				e.preventDefault();
				that.getCurrentPosition(false);
			});
		},
		maybeShowLoading: function() {
			var store_locator_loading = $(this.settings.store_locator_loading);

			if(store_locator_loading.hasClass('hidden'))
			{
				store_locator_loading.removeClass('hidden');
			} else {
				store_locator_loading.addClass('hidden');
			}
		},
		geocodeAddress: function (address) {
			var that = this;

			if ( address ) {
				this.geocoder.geocode( { 'address': address }, function ( results, status ) {
					if ( status === google.maps.GeocoderStatus.OK ) {
						that.setCurrentPosition(results[0].geometry.location);
					}
				} );
			} else {
				alert('no address!');
			}
		},
		geocodeLatLng: function (callback) {
			var that = this;
			var latlng = {lat: this.lat, lng: this.lng};

			this.geocoder.geocode({'location': latlng}, function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					if (results[1]) {
						callback(results[1].formatted_address);
					} else {
						window.alert('No results found');
					}
				} else {
					window.alert('Geocoder failed due to: ' + status);
				}
			});
		},
		autoHeightMap: function() {

			var mapContainer = $(this.settings.map_container);
			var store_locator_sidebar = $(this.settings.store_locator_sidebar);
		    var mapHeight = $(store_locator_sidebar).height();

		    if(mapHeight < this.settings.map_min_height) {
		    	mapHeight = this.settings.map_min_height;
		    }

		    mapContainer.css('height', mapHeight);
		    google.maps.event.trigger(this.map, "resize");

		},
		getStores: function() {
			var that = this;
			that.maybeShowLoading();

			jQuery.ajax({
				url: that.settings.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data: {
					action: 'get_stores',
					lat: that.lat,
					lng: that.lng,
					radius: that.radius,
					categories: that.categories,
					filter: that.filter,
				},
				success : function( response ) {
					that.createMarker(response);
					that.createResultList(response);
					that.maybeShowLoading();
				},
				error: function(jqXHR, textStatus, errorThrown) {
				    that.maybeShowLoading();
				    alert('An Error Occured: ' + jqXHR.status + ' ' + errorThrown + '! Please contact System Administrator!');
				}
			});
		},
		createMarker: function(stores) {
		   	var storesLength = Object.keys(stores).length;
		   	var store;
		   	var i = 0;
		   	var marker;
		   	var map = this.map;
		    var infowindow =  new google.maps.InfoWindow({
		        content: ""
		    });

		    // Clean markers
			while(this.markers.length){
			    this.markers.pop().setMap(null);
			}
			// Create Markers
			if(storesLength > 0) {
				for (i; i < storesLength; i++) {  

					store = stores[i];
					store.map = this.map;
					this.store = store;
					store.position = new google.maps.LatLng(store.lat, store.lng);
					store.icon = store.ic;
					// Label?
					// store.label = i.toString();
				    marker = new google.maps.Marker(store);
				    this.markers.push(marker);
				    if(this.settings.infowindowEnabled === "1") {
				    	this.createInfowindow(marker, map, infowindow, store);
				    }
				}
			}
		},
		createInfowindow: function(marker, map, infowindow, store) {
			var that = this;
		   	var template = '<div class="store_locator_infowindow">' +
								'<div class="col-sm-' + that.settings.infowindowDetailsColumns + ' store_locator_details">' +
									'<h3 class="store_locator_name">%s</h3>' +
									'<p class="store_locator_address">' +
										'<span class="store_locator_street">%s<br/></span>' +
										'<span class="store_locator_city">%s<br/></span>' +
										'<span class="store_locator_country">%s<br/></span>' +
									'</p>' +
									'<p class="store_locator_contact">' +
										'<span class="store_locator_tel">' + that.settings.showTelephoneText + ': <a href="tel:%s">%s</a><br/></span>' +
										'<span class="store_locator_email">' + that.settings.showEmailText + ': <a href="mailto:%s">%s</a><br/></span>' +
										'<span class="store_locator_mobile">' + that.settings.showMobileText + ': <a href="tel:%s">%s</a></span></span>' +
										'<span class="store_locator_fax">' + that.settings.showFaxText + ': %s</span></span>' +
										'<span class="store_locator_website">' + that.settings.showWebsiteText + ': <a href="%s" target="_blank">%s</a></span></span>' +
									'</p>' +
									'<p class="store_locator_actions">' +
										'<a href="http://maps.google.com/maps?saddr=%s,%s&daddr=%s,%s" class="btn button btn-primary btn-lg store_locator_get_direction" target="_blank"><i class="fa fa-compass"></i> '+that.settings.showGetDirectionText+'</a>' +
										'<a href="tel:%s" class="btn button btn-primary btn-lg store_locator_call_now"><i class="fa fa-phone"></i> '+that.settings.showCallNowText+'</a>' +
										'<a href="%s" class="btn button btn-primary btn-lg store_locator_visit_website" target="_blank"><i class="fa fa-globe"></i> '+that.settings.showVisitWebsiteText+'</a>' +
										'<a href="mailto:%s" class="btn button btn-primary btn-lg store_locator_write_email"><i class="fa fa-envelope-o"></i> '+that.settings.showWriteEmailText+'</a>' +
									'</p>' +
								'</div>' +
								'<div class="col-sm-' + that.settings.infowindowImageColumns + ' store_locator_image">' +
									'<img src="%s" class="img-responsive" width="'+that.settings.imageDimensions.width+'" height="'+that.settings.imageDimensions.height+'" />' +
								'</div>' + 
								'<div class="col-sm-' + that.settings.infowindowOpeningHoursColumns + ' store_locator_opening_hours">' +
									'%s' +
								'</div>' + 
							'</div>';
		    marker.addListener('click', function() {

				var openingHours = "";
				if(!that.isEmpty(store.op)) {
					openingHours = that.createOpeningHoursTable(store.op);
				}

		        infowindow.setContent(that.sprintf(template, 
						store.na, 
						store.st, 
						store.ct, 
						store.co, 
						store.te, store.te, 
						store.em, store.em, 
						store.mo, store.mo,
						store.fa,
						store.we, store.we,
						store.lat, store.lng,
						that.lat, that.lng,
						store.te,
						store.we,
						store.em,
						store.im,
						openingHours
				));
		        infowindow.open(map, this);

		     	google.maps.event.addListener(map, 'click', function() {
					infowindow.close();
			    });
		    });
		    marker.addListener('mouseover', function() {
		        this.setIcon(that.settings.mapDefaultIconHover);
		        google.maps.event.trigger(this, 'click');
		    });
		    marker.addListener('mouseout', function() {
		        this.setIcon(that.settings.mapDefaultIcon);
		    });
		},
		createResultList: function(stores)
		{
			var that = this;
		   	var storesLength = Object.keys(stores).length;
		   	var resultList = $(this.settings.result_list);
		   	var resultListIconEnabled = this.settings.resultListIconEnabled;
		   	var resultListIcon = this.settings.resultListIcon;
		   	var resultListIconSize = this.settings.resultListIconSize;
		   	var resultListIconColor = this.settings.resultListIconColor;

		   	var resultListPremiumIconEnabled = this.settings.resultListPremiumIconEnabled;
		   	var resultListPremiumIcon = this.settings.resultListPremiumIcon;
		   	var resultListPremiumIconSize = this.settings.resultListPremiumIconSize;
		   	var resultListPremiumIconColor = this.settings.resultListPremiumIconColor;
		   	
		   	var store;
		   	var template = '<div class="store_locator_result_list_item">' +
								'<div class="row">';
				if(resultListIconEnabled === "1") {
					template	+=	'<div class="col-sm-2 store_locator_icon hidden-sm hidden-xs">' +
										'<i style="color: '+ resultListIconColor +';" class="fa '+ resultListIcon +' ' + resultListIconSize +'"></i>' +
									'</div>' +
									'<div class="col-sm-10 store_locator_details">';
				} else {
					template	+=	'<div class="col-sm-12 store_locator_details">';
				}
					template	+=		'<h3 class="store_locator_name">%s</h3>' +
										'<span className="store_locator_badges">' +
											'%s' +
										'</span>' +
										'<p class="store_locator_address">' +
											'<span class="store_locator_street">%s<br/></span>' +
											'<span class="store_locator_city">%s<br/></span>' +
											'<span class="store_locator_country">%s<br/></span>' +
										'</p>' +
										'<p class="store_locator_contact">' +
											'<span class="store_locator_tel">Tel: <a href="tel:%s">%s</a><br/></span>' +
											'<span class="store_locator_email">Email: <a href="mailto:%s">%s</a><br/></span>' +
											'<span class="store_locator_mobile">Mobile: <a href="tel:%s">%s</a><br/></span>' +
											'<span class="store_locator_fax">Fax: %s<br/></span>' +
											'<span class="store_locator_website">Website: <a href="%s" target="_blank">%s</a><br/></span>' +
										'</p>' +
										'<p class="store_locator_actions">' +
											'<a href="http://maps.google.com/maps?saddr=%s,%s&daddr=%s,%s" class="btn button btn-primary btn-lg store_locator_get_direction" target="_blank"><i class="fa fa-compass"></i> '+that.settings.showGetDirectionText+'</a>' +
											'<a href="tel:%s" class="btn button btn-primary btn-lg store_locator_call_now"><i class="fa fa-phone"></i> '+that.settings.showCallNowText+'</a>' +
											'<a href="%s" class="btn button btn-primary btn-lg store_locator_visit_website" target="_blank"><i class="fa fa-globe"></i> '+that.settings.showVisitWebsiteText+'</a>' +
											'<a href="mailto:%s" class="btn button btn-primary btn-lg store_locator_write_email"><i class="fa fa-envelope-o"></i> '+that.settings.showWriteEmailText+'</a>' +
										'</p>' +
									'</div>';
				if(resultListPremiumIconEnabled === "1") {
					template	+=	'<i style="color: '+ resultListPremiumIconColor +'; position: absolute; top: 5px; z-index: 999999; right: 10px;" class="fa '+ resultListPremiumIcon +' ' + resultListPremiumIconSize +'"></i>';
				}
				template	+=	'</div>' +
							'</div>';
		   	var i = 0;

		   	resultList.html('');
		   	if(storesLength > 0) {
				for (i; i < storesLength; i++) {
					store = stores[i];

					var filterBadges = "";
					if(!that.isEmpty(store.fi)) {
						$.each(store.fi, function(i, item){
							filterBadges += that.createBadge(item);
						});
					}

					if(!that.isEmpty(store.ca)) {
						$.each(store.ca, function(i, item){
							filterBadges += that.createBadge(item);
						});
					}

					resultList.append(this.sprintf(template, 
						store.na,
						filterBadges, 
						store.st, 
						store.ct, 
						store.co, 
						store.te, store.te, 
						store.em, store.em, 
						store.mo, store.mo,
						store.fa,
						store.we, store.we,
						store.lat, store.lng,
						this.lat, this.lng,
						store.te,
						store.we,
						store.em
					));
				}
			} else {
				this.noResults();
			}
			this.autoHeightMap();
			this.window.trigger('resize');
			this.resultItemHover();
		},
		createOpeningHoursTable: function(openingHours) {
			var that = this;

			var table = "";
			$.each(openingHours, function(i, item) {
				if(item === null) {
					return true;
				}

				if(i % 2 === 0) {
					table += '<div class="row">';
					table += '<div class="col-sm-12">';
				}
				
				if(i % 2 === 0) {
					if(i === "0") { table += that.settings.showOpeningHoursMonday; }
					if(i === "2") { table += that.settings.showOpeningHoursTuesday; }
					if(i === "4") { table += that.settings.showOpeningHoursWednesday; }
					if(i === "6") { table += that.settings.showOpeningHoursThursday; }
					if(i === "8") { table += that.settings.showOpeningHoursFriday; }
					if(i === "10") { table += that.settings.showOpeningHoursSaturday; }
					if(i === "11") { table += that.settings.showOpeningHoursSunday; }

					table += ': ' + item;
				} else {
					table += " - " + item + ' ' + that.settings.showOpeningHoursClock;
				}

				if(i % 2 !== 0) {
					table += '</div>';
					table += '</div>';
				}
				
			});
			if(table !== "") {
				var title = '<h3 class="store_locator_opening_hours_title">' + that.settings.showOpeningHoursText + '</h3>';
				table = title + table;
			}

			return table;
		},
		createBadge: function(value) {
			var that = this;
			var template = '<span class="label label-success">%s</span> ';

			return that.sprintf(template, value);
		},
		noResults: function() {
		   	var resultList = $(this.settings.result_list);

		   	resultList.html('');
		   	resultList.append('<h4 class="store_locator_no_stores">' + this.settings.resultListNoResultsText + '</h4>');
			this.autoHeightMap();
		},
		resultItemHover: function() {
			var that = this;
			var resultList = $(this.settings.result_list);

			$('.store_locator_result_list_item').each(function(i, item){
				$(item).on('hover', function(){
					// that.map.panTo(that.markers[i].getPosition());
					that.markers[i].setIcon(that.settings.mapDefaultIconHover);
					google.maps.event.trigger(that.markers[i], 'click');
				});
				$(item).on('mouseleave', function(){
					that.markers[i].setIcon(that.settings.mapDefaultIcon);
				});
			});
		},
		initFilter: function() {
			var that = this;
			var store_locator_filter_open_close = $(this.settings.store_locator_filter_open_close);
			var store_locator_filter_icon = store_locator_filter_open_close.find('i');

			store_locator_filter_open_close.on('click', function(){
				that.maybeShowFilter();
			});
			
		    that.watchRadiusSelection();
		    that.watchCategoriesSelection();
		    that.watchCheckboxFilter();
		    that.updateActiveFilter();
		},
		maybeShowFilter: function() {
			var store_locator_filter_content = $(this.settings.store_locator_filter_content);
			var store_locator_filter_open_close = $(this.settings.store_locator_filter_open_close);
			var store_locator_filter_icon = store_locator_filter_open_close.find('i');

			if(store_locator_filter_content.hasClass('hidden'))
			{
				store_locator_filter_icon.removeClass('fa-chevron-down');
				store_locator_filter_icon.addClass('fa-chevron-up');
				store_locator_filter_content.removeClass('hidden');
			} else {
				store_locator_filter_icon.addClass('fa-chevron-down');
				store_locator_filter_icon.removeClass('fa-chevron-up');
				store_locator_filter_content.addClass('hidden');
			}
		},
		watchRadiusSelection: function() {
			var that = this;
			var selectedRadius = $(this.settings.store_locator_filter_radius);
			selectedRadius.on('change', function(){
				that.drawRadiusCircle();

				that.updateActiveFilter();
				that.getStores();
			});
		},
		watchCategoriesSelection: function() {
			var that = this;
			var selectedCategories = $(this.settings.store_locator_filter_categories);
			var selected = selectedCategories.find(':selected').val();

			that.categories = {0: selected };	

			selectedCategories.on('change', function(){
				selected = selectedCategories.find(':selected').val();
				that.categories = {0: selected };
				that.updateActiveFilter();
				that.getStores();
			});
		},
		watchCheckboxFilter: function() {
			var that = this;
			var filterCheckboxes = $(this.settings.store_locator_filter_checkbox);


		    filterCheckboxes.each(function(i, item) {
		    	var checkbox = $(item);
			    var isChecked = checkbox.is(":checked");

			    if(isChecked) {
			    	var filter = checkbox.attr("name");
			    	that.filter[filter] = filter;
			    }
		    });

			$(filterCheckboxes).on('change', function () {
				that.filter = {};
			    filterCheckboxes.each(function(i, item) {
			    	var checkbox = $(item);
				    var isChecked = checkbox.is(":checked");

				    if(isChecked) {
				    	var filter = checkbox.attr("name");
				    	that.filter[filter] = filter;
				    }
			    });
				that.updateActiveFilter();
				that.getStores();
			});
		},
		updateActiveFilter: function()
		{
			var that = this;
			var store_locator_filter = $(this.settings.store_locator_filter);
			var store_locator_filter_active_filter = $(this.settings.store_locator_filter_active_filter);
			var selectedCategories = store_locator_filter.find('select');
			var selectedFilters = store_locator_filter.find('input:checked');
			var template = '<span class="store_locator_filter_active label label-success">%s</span> ';
			var append = "";

			store_locator_filter_active_filter.html('');
			selectedCategories.each(function(i, item){
				var val = $(item).find(':selected').val();
				if(val !== "") {
					var text = $(item).find(':selected').text();
					append = append + that.sprintf(template, text);
				}				
			});

			selectedFilters.each(function(i, item) {
				var text = $(item).val();
				append = append + that.sprintf(template, text);
			});


			store_locator_filter_active_filter.html(append);

		},
		watchResize: function() {
			var store_locator_sidebar = $(this.settings.store_locator_sidebar);
			var store_modal_close = $(this.settings.store_modal_close);
			var windowWidth = this.window.width();

			var top;
			// if(windowWidth < 769) {
			// 	top = store_locator_sidebar.height() * -1;
			// 	store_modal_close.css('top', top);
			// } else {
			// 	top = 20;
			// 	store_modal_close.css('top', top);
			// }
		},
		//////////////////////
		///Helper Functions///
		//////////////////////
		isEmpty: function(obj) {

		    if (obj == null)		return true;
		    if (obj.length > 0)		return false;
		    if (obj.length === 0)	return true;

		    for (var key in obj) {
		        if (hasOwnProperty.call(obj, key)) return false;
		    }

		    return true;
		},
		sprintf: function parse(str) {
		    var args = [].slice.call(arguments, 1),
		        i = 0;

		    return str.replace(/%s/g, function() {
		        return args[i++];
		    });
		},
		getCookie: function(cname) {
		    var name = cname + "=";
		    var ca = document.cookie.split(';');
		    for(var i=0; i<ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1);
		        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
		    }
		    return "";
		},
	} );

	// Constructor wrapper
	$.fn[ pluginName ] = function( options ) {
		return this.each( function() {
			if ( !$.data( this, "plugin_" + pluginName ) ) {
				$.data( this, "plugin_" +
					pluginName, new Plugin( this, options ) );
			}
		} );
	};

	$(document).ready(function() {

		$( "#store_locator" ).storeLocator( 
			store_locator_options
		);

	} );

})( jQuery );