<?php
/**
 * Singleton class for handling the theme's customizer integration.
 */
final class EasyBuy_Customize {

	/**
	 * Returns the instance.
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
		add_action( 'customize_register', array( $this, 'sections' ),999 );
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
					'title'    => esc_html__( 'EasyBuy Pro', 'easybuy' ),
                    'pro_text' => esc_html__( 'Upgrade to Pro','easybuy' ),
                    'pro_url'  => esc_url('https://wpfable.com/themes/easybuy-premium/'),
					'pro_demo_text' => esc_html__( 'Pro Demo','easybuy' ),
                    'pro_demo_url'  => esc_url('https://demos.wpfable.com/premium/easybuy/'),
					'help_text' => esc_html__( 'Ask Help ?','easybuy' ),
                    'help_url'  => esc_url('https://wpfable.com/support/'),
                    'priority' => 0
                )
			)
		);
	}
}
// Doing this customizer thang!
EasyBuy_Customize::get_instance();