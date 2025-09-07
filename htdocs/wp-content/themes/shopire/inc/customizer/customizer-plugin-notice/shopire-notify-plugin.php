<?php
/*
 *  Customizer Notifications
 */
require get_template_directory() . '/inc/customizer/customizer-plugin-notice/shopire-customizer-notify.php';
$shopire_config_customizer = array(
    'recommended_plugins' => array( 
		'woocommerce' => array(
            'recommended' => true,
            'description' => sprintf( 
                /* translators: %s: plugin name */
                esc_html__( 'If you want to show all the features and sections of the Theme. please install and activate %s plugin', 'shopire' ), '<strong>WooCommerce</strong>' 
            ),
        ),
        'fable-extra' => array(
            'recommended' => true,
            'description' => sprintf( 
                /* translators: %s: plugin name */
                esc_html__( 'If you want to show all the features and sections of the Theme. please install and activate %s plugin', 'shopire' ), '<strong>Fable Extra</strong>' 
            ),
        )
    ),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'shopire' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'shopire' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'shopire' ),
	'activate_button_label'     => esc_html__( 'Activate', 'shopire' ),
	'shopire_deactivate_button_label'   => esc_html__( 'Deactivate', 'shopire' ),
);
Shopire_Customizer_Notify::init( apply_filters( 'shopire_customizer_notify_array', $shopire_config_customizer ) );