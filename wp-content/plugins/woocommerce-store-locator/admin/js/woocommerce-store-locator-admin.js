(function( $ ) {
	'use strict';

	var findAddressButton = $('.rwmb-map-goto-address-button');
	$('#woocommerce_store_locator_address1, #woocommerce_store_locator_address2, #woocommerce_store_locator_zip, #woocommerce_store_locator_city, #woocommerce_store_locator_region, #woocommerce_store_locator_country').on('focusout', function(e)
	{
		findAddressButton.trigger('click');
	});

})( jQuery );
