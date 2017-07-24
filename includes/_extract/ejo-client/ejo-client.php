<?php

/* Better integration of Yoast Wordpress SEO */
add_action( 'after_setup_theme', 'ejo_base_client_access', 99 );

/* Improve Yoast Wordpress SEO support */
function ejo_base_client_access()
{
    /**
     * Redirection Plugin
     */

    //* Let ejo-client access redirections
    add_filter( 'redirection_role', 'get_ejo_client_capability' );

    /**
     * Yoast WordPress SEO Plugin
     */
    
    //* Edit main SEO capability
    add_filter( 'wpseo_manage_options_capability',                          'get_ejo_client_capability' );

    //* Change capability necessary to save options
    add_filter( 'option_page_capability_yoast_wpseo_titles_options',        'get_ejo_client_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_internallinks_options', 'get_ejo_client_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_permalinks_options',    'get_ejo_client_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_rss_options',           'get_ejo_client_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_xml_sitemap_options',   'get_ejo_client_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_social_options',        'get_ejo_client_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_options',               'get_ejo_client_capability' );

    //* Remove Go Premium and Search Console from menu
    add_filter( 'wpseo_submenu_pages', function($submenu_pages) {

        foreach ($submenu_pages as $index => $submenu_page) {

            //* Remove Search Console and Go Premium 
            if ($submenu_page[4] == 'wpseo_search_console' || $submenu_page[4] == 'wpseo_licenses')
                unset($submenu_pages[$index]);
        }

        return $submenu_pages;
    });
}

/* Wordpress SEO capability */
function get_ejo_client_capability( $capability )
{
    //* Downgrade capability from manage_options to edit_theme_options to support ejo-client
    $capability = 'edit_theme_options';        

    return $capability;
}