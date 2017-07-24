<?php

if ( ! current_theme_supports( 'xmlrpc' ) && ! current_theme_supports( 'pingback' )  ) {
	/** 
	 * Disable XML-RPC
	 * XML-RPC wordt voor meer gebruikt dan Pingback en trackback, zoals voor  Remote login
	 *
	 * Test: 
	 * - When I browse to your xmlrpc URL, it returns "XML-RPC server accepts POST requests only" - 
	 *   which is what it should do regardless of if the plugin is enabled or not.
	 *
	 * - When I test your site with the XML-RPC tester at http://xmlrpc.eritreo.it/, it returns that 
	 *   it cannot access the XML-RPC service, which is what is expected when the plugin is enabled.
	 */
	add_filter( 'xmlrpc_enabled', '__return_false' );	

	/* Really Simple Discovery link is the discover mechanism used by XML-RPC clients. */
	remove_action( 'wp_head', 'rsd_link' );
}

if ( ! current_theme_supports( 'pingback' ) ) {

	/**
	 * PINGBACK
	 */

	//* Prevent pingback being sent to XMLRPC server
	//* (Probably not necessary if XML-RPC disabled)
	add_filter( 'xmlrpc_methods', 'ejo_prevent_pingback_xmlrpc' );

	//* Remove unnecesary HTTP Header response item
	add_filter( 'wp_headers', 'ejo_remove_x_pingback_header' );

	//* Remove Hybrid pingback link
	remove_action( 'wp_head', 'hybrid_link_pingback',  3 );


	//* Prevent pingback being sent to XMLRPC server
	function ejo_prevent_pingback_xmlrpc( $methods ) 
	{
		unset( $methods['pingback.ping'] );
		unset( $methods['pingback.extensions.getPingbacks'] );

		return $methods;
	}

	//* Remove from HTTP Header response
	function ejo_remove_x_pingback_header( $headers ) 
	{
		unset( $headers['X-Pingback'] );
	}
}
