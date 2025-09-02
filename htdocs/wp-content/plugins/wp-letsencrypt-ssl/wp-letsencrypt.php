<?php

/**
 *
 * One Click SSL & Force HTTPS
 *
 * Plugin Name:       WP Encryption - One Click SSL & Force HTTPS
 * Plugin URI:        https://wpencryption.com
 * Description:       Secure your WordPress site with free SSL certificate and force HTTPS. Enable HTTPS padlock. Just activating this plugin won't help! - Please run the SSL install form of WP Encryption found on left panel.
 * Version:           7.8.2
 * Author:            WP Encryption SSL HTTPS
 * Author URI:        https://wpencryption.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wp-letsencrypt-ssl
 * Domain Path:       /languages
 *
 * @author      WP Encryption SSL
 * @category    Plugin
 * @package     WP Encryption
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 * 
 * @copyright   Copyright (C) 2019-2024, WP Encryption (support@wpencryption.com)
 *
 * 
 */
/**
 * Die on direct access
 */
if ( !defined( 'ABSPATH' ) ) {
    die( 'Access Denied' );
}
/**
 * Definitions
 */
if ( !defined( 'WPLE_PLUGIN_VER' ) ) {
    define( 'WPLE_PLUGIN_VER', '7.8.2' );
}
if ( !defined( 'WPLE_BASE' ) ) {
    define( 'WPLE_BASE', plugin_basename( __FILE__ ) );
}
if ( !defined( 'WPLE_DIR' ) ) {
    define( 'WPLE_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPLE_URL' ) ) {
    define( 'WPLE_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WPLE_NAME' ) ) {
    define( 'WPLE_NAME', 'WP Encryption' );
}
if ( !defined( 'WPLE_SLUG' ) ) {
    define( 'WPLE_SLUG', 'wp_encryption' );
}
$wple_updir = wp_upload_dir();
$uploadpath = $wple_updir['basedir'] . '/';
if ( !file_exists( $uploadpath ) ) {
    $uploadpath = ABSPATH . 'wp-content/uploads/wp_encryption/';
}
if ( !defined( 'WPLE_UPLOADS' ) ) {
    define( 'WPLE_UPLOADS', $uploadpath );
}
if ( !defined( 'WPLE_DEBUGGER' ) ) {
    define( 'WPLE_DEBUGGER', WPLE_UPLOADS . 'wp_encryption/' );
}
/**
 * Freemius
 */
if ( function_exists( 'wple_fs' ) ) {
    wple_fs()->set_basename( false, __FILE__ );
} else {
    if ( !function_exists( 'wple_fs' ) ) {
        // Activate multisite network integration.
        if ( !defined( 'WP_FS__PRODUCT_5090_MULTISITE' ) ) {
            define( 'WP_FS__PRODUCT_5090_MULTISITE', true );
        }
        // Create a helper function for easy SDK access.
        function wple_fs() {
            global $wple_fs;
            ///$showpricing = (FALSE !== get_option('wple_no_pricing')) ? false : true;
            $showpricing = true;
            if ( !isset( $wple_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wple_fs = fs_dynamic_init( array(
                    'id'               => '5090',
                    'slug'             => 'wp-letsencrypt-ssl',
                    'premium_slug'     => 'wp-letsencrypt-ssl-pro',
                    'type'             => 'plugin',
                    'public_key'       => 'pk_f6a07c106bf4ef064d9ac4b989e02',
                    'is_premium'       => false,
                    'has_addons'       => true,
                    'has_paid_plans'   => true,
                    'is_org_compliant' => true,
                    'menu'             => array(
                        'slug'    => 'wp_encryption',
                        'support' => false,
                        'contact' => false,
                        'pricing' => $showpricing,
                    ),
                    'is_live'          => true,
                ) );
            }
            return $wple_fs;
        }

        // Init Freemius.
        wple_fs();
        // Signal that SDK was initiated.
        do_action( 'wple_fs_loaded' );
    }
}
wple_fs()->add_filter( 'templates/pricing.php', 'wple_pricing_reactstyle' );
if ( !function_exists( 'wple_pricing_reactstyle' ) ) {
    function wple_pricing_reactstyle(  $template  ) {
        $style = "\r\n            <style>\r\n            header.fs-app-header .fs-page-title {\r\n                display: none !important;\r\n            }\r\n\r\n            section.fs-plugin-title-and-logo {\r\n                margin: 0 !important;\r\n            }\r\n\r\n            section.fs-plugin-title-and-logo h1 {\r\n                font-size: 2em !important;\r\n            }\r\n            img.fs-limited-offer {\r\n                max-width: 600px;\r\n            }\r\n            li.fs-selected-billing-cycle {\r\n                background: linear-gradient(180deg, black, #555) !important;!i;!;\r\n                color:#fff !important;\r\n            }\r\n\r\n            .fs-billing-cycles li {\r\n                padding: 7px 35px !important;\r\n            }\r\n            button.fs-button.fs-button--size-large {\r\n                background: linear-gradient(180deg, #6cc703, #139104) !important;\r\n                border: none !important;\r\n                color: #fff !important;\r\n                padding-top: 12px !important;\r\n                padding-bottom: 12px !important;\r\n                font-weight: 400 !important;\r\n            }\r\n            h2.fs-plan-title {\r\n                padding-top: 15px !important;\r\n                padding-bottom: 15px !important;\r\n            }\r\n\r\n            span.fs-feature-title strong {\r\n                padding-right: 3px;\r\n            }\r\n\r\n            ul.fs-plan-features-with-value li {\r\n                padding: 5px 0;\r\n                background: #f6f6f6;\r\n            }\r\n\r\n            ul.fs-plan-features-with-value li:nth-of-type(even) {\r\n                background: none;\r\n            }\r\n\r\n            .fs-plan-support strong {\r\n                font-weight: 500 !important;!i;!;\r\n                color: #666;\r\n            }\r\n\r\n            section.fs-section.fs-section--plans-and-pricing:before {\r\n                content: '';\r\n                display: block;\r\n                background: url(https://gowebsmarty.com/limited-offer.png) no-repeat top center;\r\n                height:120px;\r\n                background-size: 600px auto;\r\n            }\r\n            #fs_pricing_app .fs-package .fs-plan-features{\r\n                margin:20px 25px 0 !important;\r\n            }\r\n            button.fs-button.fs-button--size-large:hover {\r\n                background: linear-gradient(180deg, #6cc703, #148706) !important;\r\n            }\r\n            </style>";
        return $style . $template;
    }

}
require_once WPLE_DIR . 'classes/le-trait.php';
/**
 * Plugin Activator hook
 */
register_activation_hook( __FILE__, 'wple_activate' );
if ( !function_exists( 'wple_activate' ) ) {
    function wple_activate(  $networkwide  ) {
        require_once WPLE_DIR . 'classes/le-activator.php';
        WPLE_Activator::activate( $networkwide );
    }

}
/**
 * Plugin Deactivator hook
 */
register_deactivation_hook( __FILE__, 'wple_deactivate' );
if ( !function_exists( 'wple_deactivate' ) ) {
    function wple_deactivate() {
        require_once WPLE_DIR . 'classes/le-deactivator.php';
        WPLE_Deactivator::deactivate();
    }

}
/**
 * Class to handle all aspects of plugin page
 */
require_once WPLE_DIR . 'admin/le_admin.php';
new WPLE_Admin();
/**
 * Admin Pages
 * @since 5.0.0
 */
require_once WPLE_DIR . 'admin/le_admin_pages.php';
new WPLE_SubAdmin();
/**
 * Force SSL on frontend
 */
require_once WPLE_DIR . 'classes/le-forcessl.php';
new WPLE_ForceSSL();
/**
 * Scannr
 * 
 * @since 5.1.8
 */
require_once WPLE_DIR . 'classes/le-scanner.php';
new WPLE_Scanner();
if ( function_exists( 'wple_fs' ) && !function_exists( 'wple_fs_custom_connect_message' ) ) {
    function wple_fs_custom_connect_message(  $message  ) {
        $current_user = wp_get_current_user();
        return 'Howdy ' . ucfirst( $current_user->user_nicename ) . ', <br>' . __( 'Due to security nature of this plugin, We <b>HIGHLY</b> recommend you opt-in to our security & feature updates notifications, and <a href="https://freemius.com/wordpress/usage-tracking/5090/wp-letsencrypt-ssl/" target="_blank">non-sensitive diagnostic tracking</a> to get BEST support. If you skip this, that\'s okay! <b>WP Encryption</b> will still work just fine.', 'wp-letsencrypt-ssl' );
    }

    wple_fs()->add_filter( 'connect_message', 'wple_fs_custom_connect_message' );
}
/**
 * Support forum URL for Premium
 * 
 * @since 5.3.2
 */
if ( wple_fs()->is_premium() && !function_exists( 'wple_premium_forum' ) ) {
    function wple_premium_forum(  $wp_org_support_forum_url  ) {
        return 'https://support.wpencryption.com/';
    }

    wple_fs()->add_filter( 'support_forum_url', 'wple_premium_forum' );
}
/**
 * Dont show cancel subscription popup
 * 
 * @since 5.3.2
 */
wple_fs()->add_filter( 'show_deactivation_subscription_cancellation', '__return_false' );
/**
 * Security Init
 * 
 * @since 7.0.0
 */
require_once plugin_dir_path( __FILE__ ) . 'classes/le-security.php';
new WPLE_Security();