<?php

/**
 * Magnific Popup
 */    
function ejo_add_magnific_popup() {
    wp_enqueue_style(  'magnific-popup', EJO_CORE_URI . "assets/magnific-popup/magnific-popup.css",    array(),           '1.1.0');
    wp_enqueue_script( 'magnific-popup', EJO_CORE_URI . "assets/magnific-popup/magnific-popup.min.js", array( 'jquery' ), '1.1.0', true );
}

/**
 * Flickity
 */    
function ejo_add_flickity() {
    wp_enqueue_style(  'flickity', EJO_CORE_URI . "assets/flickity/flickity.css",    array(),           '2.0.10');
    wp_enqueue_script( 'flickity', EJO_CORE_URI . "assets/flickity/flickity.min.js", array( 'jquery' ), '2.0.10', true );    
}