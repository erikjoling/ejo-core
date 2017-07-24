<?php
/**
 * Plugin Name:         Ejo Base
 * Plugin URI:          http://github.com/erikjoling/ejo-base
 * Description:         A solid WordPress framework to take some of the heavy lifting out of the theme area
 * Version:             1.9
 * Author:              Erik Joling
 * Author URI:          https://www.ejoweb.nl/
 * Text Domain:         ejo-base
 * Domain Path:         /languages
 *
 * GitHub Plugin URI:   https://github.com/erikjoling/ejo-base
 * GitHub Branch:       2.0
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJO Base
 * @version   0.1.0
 * @since     0.1.0
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2015, Erik Joling
 * @link      http://github.com/erikjoling
 */

/**
 *
 */
final class EJO_Base 
{
    /* Holds the instance of this class. */
    private static $_instance = null;

    /* Version number of this plugin */
    public static $version = '1.9';

    /* Store the slug of this plugin */
    public static $slug = 'ejo-base';

    /* Stores the directory path for this plugin. */
    public static $dir;

    /* Stores the directory URI for this plugin. */
    public static $uri;

    /* Only instantiate once */
    public static function init() 
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
        self::setup();

        /* Make helpers immediatly available */
        self::helpers();

        /* Manage dependancies */
        add_action( 'plugins_loaded', array( 'EJO_Base', 'manage_dependancies' ), 5 );

        /* Base. Loaded after theme setup so themes can manipulate it */        
        add_action( 'after_setup_theme', array( 'EJO_Base', 'base' ), 999 );

        //* Load Plugin Integrations
        add_action( 'plugins_loaded', array( 'EJO_Base', 'plugin_integrations' ), 6 );
    }

    
    /* Defines the directory path and URI for the plugin. */
    public static function setup() 
    {
        self::$dir = plugin_dir_path( __FILE__ );
        self::$uri = plugin_dir_url( __FILE__ );

        /* Load the translation for the plugin */
        load_plugin_textdomain( 'ejo-base', false, 'ejo-base/languages' );
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

    /* Manage dependancies */
    public static function manage_dependancies() 
    {
        /**
         * Create API for dependancies 
         * 
         * Every dependancy failure should result in a warning
         */
    }
    
    /* The Base */
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

    /* Plugin Integrations */
    public static function plugin_integrations() 
    {
         
    }

    /* Uninstall */
    private static function uninstall()
    {
        /**
         * Stored data in options table
         * - ejo_header_scripts
         * - ejo_footer_scripts
         * - medium_crop
         * - large_crop
         * - _ejo_social_media
         */
    }
}

/* Call EJO Base */
EJO_Base::init();
