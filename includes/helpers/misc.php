<?php 

/**
 * Helper function for getting the script/style `.min` suffix for minified files. 
 *
 * Shamelessly copied from Hybrid Core (Justin Tadlock)
 */
function ejo_get_min_suffix() {
    return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
}