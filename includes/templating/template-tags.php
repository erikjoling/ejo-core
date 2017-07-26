<?php 

/**
 * Function for figuring out if we're viewing a "plural" page.  In WP, these pages are archives,
 * search results, and the home/blog posts index.  Note that this is similar to, but not quite
 * the same as `!is_singular()`, which wouldn't account for the 404 page.
 *
 * @since  3.0.0
 * @access public
 * @return bool
 */
function ejo_is_plural() {
    return ( is_home() || is_archive() || is_search() );
}

