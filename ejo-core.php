<?php
/**
 * EJO Core: A theme drop-in framework by EJOweb
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJO Core
 * @version   0.1.0
 * @since     0.1.0
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2017, Erik Joling
 * @link      http://github.com/erikjoling
 */

/**
 * Singleton
 */
final class EJO_Core 
{
    /* Holds the instance of this Singleton class. */
    private static $_instance = null;

    /* Version number of this plugin */
    public static $version = '0.1';

    /* Store the slug of this plugin */
    public static $slug = 'ejo-core';

    /* Stores the directory path for this plugin. */
    public static $dir;

    /* Stores the directory URI for this plugin. */
    public static $uri;

    /**
     * Singleton implementation (Only instantiate once)
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
        add_action( 'after_setup_theme', array( 'EJO_Core', 'setup' ), -99 );

        /* Make helpers immediatly available */
        add_action( 'after_setup_theme', array( 'EJO_Core', 'helpers' ), 0 );

        /* Core. Loaded after theme setup so themes can manipulate it */        
        add_action( 'after_setup_theme', array( 'EJO_Core', 'base' ), 10 );
    }

    
    /* Defines the directory path and URI. */
    public static function setup() 
    {
        self::$dir = plugin_dir_path( __FILE__ );
        self::$uri = plugin_dir_url( __FILE__ );
    }

    /* Add helper functions */
    public static function helpers() 
    {
        /* Write Log */
        require_once( self::$dir . 'includes/_helpers/write-log.php' );

        /* Useful array functions */
        require_once( self::$dir . 'includes/_helpers/array-functions.php' );

        /* Widget Template Loader Class */
        require_once( self::$dir . 'includes/_helpers/widget-template-loader/widget-template-loader.php' );
    }
    
    /* The Core */
    public static function base() 
    {
        /**
         * Remove unnecessary functionality
         */

        /* Remove Posts functionality */
        require_once( self::$dir . 'includes/remove-posts-functionality.php' );

        /* Remove unnecessary HTML Header elements */
        require_once( self::$dir . 'includes/remove-html-header-elements.php' );

        /* Remove unnecessary XML-RPC and Pingback functionality */
        require_once( self::$dir . 'includes/remove-xmlrpc-and-pingback.php' );

        /* Remove unnecessary widgets */
        require_once( self::$dir . 'includes/remove-widgets.php');

        /**
         * Add custom functionality
         */

        /* Custom Scripts (Site and individual Posts) */
        require_once( self::$dir . 'includes/custom-scripts/add-custom-scripts.php' );

        /* Social Media */
        require_once( self::$dir . 'includes/social-media/add-social-media.php');

        /* Shortcodes */
        require_once( self::$dir . 'includes/shortcodes/shortcodes.php' );

        /**
         * Tweak WordPress Admin
         */

        /* Mold the admin menu to my liking */
        require_once( self::$dir . 'includes/ejo-admin-menu.php' );

        /* Mold the admin dashboard to my liking */
        require_once( self::$dir . 'includes/ejo-admin-dashboard.php');

        /* Mold the text editor to my liking */
        require_once( self::$dir . 'includes/ejo-text-editor.php' ); 
    }
}
