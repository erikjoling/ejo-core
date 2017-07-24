<?php 

if ( current_theme_supports( 'custom-scripts' ) || current_theme_supports( 'site-scripts' ) ) {

	/* Allow admin to add scripts to entire site */
	require_once( __DIR__ . '/add-site-scripts.php' );

}

if ( current_theme_supports( 'custom-scripts' ) || current_theme_supports( 'post-scripts' ) ) {

	/* Allow admin to add scripts to specific posts */
	require_once( __DIR__ . '/add-post-scripts.php' );
}
