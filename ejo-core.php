<?php
/**
 * EJO Core: A theme drop-in framework by EJOweb
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJO Core
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2017, Erik Joling
 * @link      https://github.com/erikjoling/ejo-core
 */

/**
 * Singleton
 */
final class EJO_Core 
{
    /* Holds the instance of this Singleton class. */
    private static $_instance = null;

    /* Version number */
    public static $version = '0.1.2';

    /* Store the slug */
    public static $slug = 'ejo-core';

    /**
     * Singleton implementation
     */
    public static function load() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* No cloning
    private function __clone() {}

    /* Plugin setup. */
    private function __construct() 
    {
        /* Setup plugin */
        add_action( 'after_setup_theme', array( 'EJO_Core', 'setup' ), -95 );

        /* Make helpers immediatly available */
        add_action( 'after_setup_theme', array( 'EJO_Core', 'helpers' ), 0 );

        /* Templating */
        add_action( 'after_setup_theme', array( 'EJO_Core', 'templating' ), 5 );

        /* Molding WordPress. Loaded after theme setup so themes can manipulate it */        
        add_action( 'after_setup_theme', array( 'EJO_Core', 'mold' ), 10 );

        /* EJOpack. Should be extracted a plugin */        
        add_action( 'after_setup_theme', array( 'EJO_Core', 'ejopack' ), 10 );
    }

    
    /* Defines the directory path and URI. */
    public static function setup() 
    {
        $relative_framework_path = trailingslashit( apply_filters( 'ejocore_relative_framework_path', 'includes/vendor/' ) );

        // Sets the path to the core framework directory.
        if ( ! defined( 'EJO_CORE_DIR' ) )
            define( 'EJO_CORE_DIR', trailingslashit( THEME_DIR . $relative_framework_path . basename( dirname( __FILE__ ) ) ) );

        // Sets the path to the core framework directory URI.
        if ( ! defined( 'EJO_CORE_URI' ) ) {
            define( 'EJO_CORE_URI', trailingslashit( THEME_URI . $relative_framework_path . basename( dirname( __FILE__ ) ) ) );
        }
    }

    /* Add helper functions */
    public static function helpers() 
    {
        /* Write Log */
        require_once( EJO_CORE_DIR . 'includes/_helpers/write-log.php' );

        /* Theme helpers */
        require_once( EJO_CORE_DIR . 'includes/_helpers/misc.php' );
    }

    /* Templating Logic */
    public static function templating() 
    {
        /* Template functions */
        require_once( EJO_CORE_DIR . 'includes/templating/template-functions.php' );

        /* Template Structure */
        require_once( EJO_CORE_DIR . 'includes/templating/template-structure.php' );

        /* Template Tags */
        require_once( EJO_CORE_DIR . 'includes/templating/template-tags.php' );

        /* Template misc */
        require_once( EJO_CORE_DIR . 'includes/templating/template-misc.php' );

        /* Widget Template Loader Class */
        require_once( EJO_CORE_DIR . 'includes/templating/widget-template-loader/widget-template-loader.php' );
    }
    
    /* Molding WordPress */
    public static function mold() 
    {
        //* Remove/disable/hide unnecessary functionality

        /* Hide Blogging functionality */
        require_if_theme_supports( 'hide-blogging', EJO_CORE_DIR . 'includes/hide-blogging.php' );

        /* Cleanup unnecessary HTML Header elements */
        require_if_theme_supports( 'cleanup-header', EJO_CORE_DIR . 'includes/cleanup-html-header.php' );

        /* Disable unnecessary XML-RPC and Pingback functionality */
        require_if_theme_supports( 'disable-xmlrpc', EJO_CORE_DIR . 'includes/disable-xmlrpc.php' );

        /* Cleanup unnecessary widgets */
        require_if_theme_supports( 'cleanup-widgets', EJO_CORE_DIR . 'includes/cleanup-widgets.php' );

        /* Disable emoji support */
        require_if_theme_supports( 'disable-emojis', EJO_CORE_DIR . 'includes/disable-emojis.php' );

        //* Tweak WordPress Admin

        /* Mold the admin menu to my liking */
        require_if_theme_supports( 'ejo-admin-menu', EJO_CORE_DIR . 'includes/ejo-admin-menu.php' );

        /* Mold the admin dashboard to my liking */
        require_if_theme_supports( 'ejo-admin-dashboard', EJO_CORE_DIR . 'includes/ejo-admin-dashboard.php');

        /* Mold the text editor to my liking */
        require_if_theme_supports( 'ejo-text-editor', EJO_CORE_DIR . 'includes/ejo-text-editor.php' ); 
    }

    /* Functionality to extract to a plugin */
    public static function ejopack() 
    {
        /* Allow admin to add scripts to entire site */
        require_if_theme_supports( 'site-scripts', EJO_CORE_DIR . '_ejopack/custom-scripts/add-site-scripts.php' );

        /* Allow admin to add scripts to specific posts */
        require_if_theme_supports( 'post-scripts', EJO_CORE_DIR . '_ejopack/custom-scripts/add-post-scripts.php' );

        /* Social Media */
        require_if_theme_supports( 'social-media-links', EJO_CORE_DIR . '_ejopack/social-media/links/social-media-links.php');

        /* Shortcodes */
        require_if_theme_supports( 'ejo-shortcodes', EJO_CORE_DIR . '_ejopack/shortcodes/shortcodes.php' );
    }
}
