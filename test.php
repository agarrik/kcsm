

<?php
$html = '<img src="url" class="with-shadow-1 image">';

$dom = new DOMDocument;
$dom->loadHTML($html); // load the string from cURL into the DOMDocument object

// using an ID
$el = $dom->getElementById('image');

// using a class
$xpath = new DOMXPath($dom);
$els = $xpath->query("//img[contains(concat(' ', normalize-space(@class), ' '), ' with-shadow-1 ')]");
$el = $els->item(0);

$src = $el->getAttribute('src');
//echo $src;

var_dump($el);
?>