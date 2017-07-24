<?php


if ( current_theme_supports( 'social-media' ) || current_theme_supports( 'social-media-links' ) ) {

	/* Social Media Links */
	require_once( __DIR__ . '/links/social-media-links.php' ); 
}

if ( current_theme_supports( 'social-media' ) || current_theme_supports( 'social-media-shares' )  ) {

	/* Add Social sharing in the future */
}