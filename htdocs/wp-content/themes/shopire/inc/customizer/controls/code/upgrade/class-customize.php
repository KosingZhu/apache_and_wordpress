<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Shopire_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
        require_once get_template_directory() . '/inc/customizer/controls/code/upgrade/section-pro.php';

        // Register custom section types.
		$manager->register_section_type( 'Shopire_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Shopire_Customize_Section_Pro(
				$manager,
				'Shopire',
				array(
					'title'    => esc_html__( 'Shopire Pro', 'shopire' ),
                    'pro_text' => esc_html__( 'Upgrade to Pro','shopire' ),
                    'pro_url'  => esc_url('https://wpfable.com/themes/shopire-premium/'),
					'pro_demo_text' => esc_html__( 'Pro Demo','shopire' ),
                    'pro_demo_url'  => esc_url('https://demos.wpfable.com/premium/shopire/'),
					'help_text' => esc_html__( 'Ask Help ?','shopire' ),
                    'help_url'  => esc_url('https://wpfable.com/support/'),
                    'priority' => 0
                )
			)
		);
	}
}
// Doing this customizer thang!
Shopire_Customize::get_instance();