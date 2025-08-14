<?php
class FABLE_EXTRA_WC_Compare_Wishlist {

	/**
	 * The single instance of the class.
	 *
	 * @var FABLE_EXTRA_Woocommerce
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Trigger checks is woocoomerce active or not
	 *
	 * @since 1.0.0
	 * @var   bool
	 */
	public $has_woocommerce = null;

	/**
	 * Holder for plugin folder path
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public $plugin_dir = null;

	/**
	 * Holder for plugin loader
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public $loader;

	/**
	 * Holder for plugin scripts suffix
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public $suffix;

	/**
	 * Main FABLE_EXTRA_WC_Compare_Wishlist Instance.
	 *
	 * Ensures only one instance of FABLE_EXTRA_Woocommerce is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see fable_extra_wc_compare_wishlist()
	 * @return FABLE_EXTRA_WC_Compare_Wishlist - Main instance.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Sets up needed actions/filters for the theme to initialize.
	 *
	 * @since 1.0.0
	*/
	public function __construct() {

		$page_found = 83;
		 define( 'FABLE_EXTRA_WC_COMPARE_WISHLIST_VERISON', '1.1.1' );

		// Load public assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 10 );


		// add_action( 'init', array( $this, 'init' ), 0 );

		// register_activation_hook( __FILE__, array( $this, 'fable_extra_wc_compare_wishlist_install' ) );
		
		add_action( 'after_setup_theme', array( $this, 'init' ), 0 );

		add_action( 'after_setup_theme', array( $this, 'fable_extra_wc_compare_wishlist_install' ), 0 );


		//$this->set_suffix();
	}

	public function set_suffix() {

		if ( is_null( $this->suffix ) ) {

			$this->suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		}
	}


	public function init() {

		include_once 'includes/templater.php';
		include_once 'includes/compare/compare.php';
		include_once 'includes/wishlist/wishlist.php';
	}

	/**
	 * Check if WooCommerce is active
	 *
	 * @since  1.0.0
	 * @return bool
	 */
	public function has_woocommerce() {

		if ( null == $this->has_woocommerce ) {

			$this->has_woocommerce = in_array(
				'woocommerce/woocommerce.php',
				apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
			);
		}
		return $this->has_woocommerce;
	}

	/**
	 * Enqueue assets.
	 *
	 * @since 1.0.0
	 * @return void
	*/
	public function register_assets() {

		//  WooCompare
		wp_register_style( 'fable-extra-woocompare', WPFE_URL . '/inc/woo-features/assets/css/fable-extra-woocompare.css', array( 'dashicons' ) );
		wp_register_script( 'fable-extra-woocompare', WPFE_URL . '/inc/woo-features/assets/js/fable-extra-woocompare' . $this->suffix . '.js', array( 'jquery' ), FABLE_EXTRA_WC_COMPARE_WISHLIST_VERISON, true );

		wp_register_style( 'tablesaw', WPFE_URL . '/inc/woo-features/assets/css/tablesaw.css', array() );
		wp_register_script( 'tablesaw', WPFE_URL . '/inc/woo-features/assets/js/tablesaw' . $this->suffix . '.js', array( 'jquery' ), FABLE_EXTRA_WC_COMPARE_WISHLIST_VERISON, true );

		wp_register_script( 'tablesaw-init', WPFE_URL . '/inc/woo-features/assets/js/tablesaw-init' . $this->suffix . '.js', array( 'tablesaw' ), FABLE_EXTRA_WC_COMPARE_WISHLIST_VERISON, true );

		wp_localize_script( 'fable-extra-woocompare', 'fableExtraWoocompare', array(
			'ajaxurl'     => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
			'compareText' => get_option( 'fable_extra_woocompare_compare_text', __( 'Add to Compare', 'fable-extra' ) ),
			'removeText'  => __( '<i class="fable-extra-wcwl-icon fa fa-refresh"></i>', 'fable-extra' ),
			'countFormat' => apply_filters( 'fable_extra_compare_count_format', '<span class="compare-count">(%count%)</span>' )
		) );

		// TM WooWishlist
		wp_register_style( 'fable-extra-woowishlist', WPFE_URL . '/inc/woo-features/assets/css/fable-extra-woowishlist.css', array( 'dashicons' ) );
		wp_register_script( 'fable-extra-woowishlist', WPFE_URL . '/inc/woo-features/assets/js/fable-extra-woowishlist' . $this->suffix . '.js', array( 'jquery' ), FABLE_EXTRA_WC_COMPARE_WISHLIST_VERISON, true );

		wp_localize_script( 'fable-extra-woowishlist', 'fableExtraWoowishlist', array(
			'ajaxurl'   => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
			'addText'   => get_option( 'fable_extra_woowishlist_wishlist_text', __( 'Add to Wishlist', 'fable-extra' ) ),
			'addedText' => __( '<div class="fable-extra-wcwl-add-button"><a href="#" class="add_to_wishlist single_add_to_wishlist" data-product-type="simple" data-title="Add to wishlist" rel="nofollow">                                                    <i class="fable-extra-wcwl-icon fa fa-heart"></i><span>Add to wishlist</span></a></div>', 'fable-extra' ) 
		) );
		
		wp_enqueue_script( 'fable-extra-ajax-script', WPFE_URL . '/inc/woo-features/assets/js/fable-extra-quick-view.js', array('jquery'), false, true );
	
		 wp_localize_script( 'fable-extra-ajax-script', 'MyAjax', array(
			// URL to wp-admin/admin-ajax.php to process the request
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			// generate a nonce with a unique ID "myajax-post-comment-nonce"
			// so that you can check it later when an AJAX request is sent
			'security' => wp_create_nonce( 'my-special-string' )
		  ));
	}

	public function plugin_url() {

		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_dir( $path = null ) {

		if ( ! $this->plugin_dir ) {

			$this->plugin_dir = trailingslashit( plugin_dir_path( __FILE__ ) );
		}
		return $this->plugin_dir . $path;
	}

	public function fable_extra_wc_compare_wishlist_install() {

		require_once 'includes/install.php';

		FABLE_EXTRA_WC_Compare_Wishlist_Install()->init();
	}

	public function get_loader() {

		if ( is_null( $this->loader ) ) {

			$loader = '<svg width="60px" height="60px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-ring-alt"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><circle cx="50" cy="50" r="40" stroke="#afafb7" fill="none" stroke-width="10" stroke-linecap="round"></circle><circle cx="50" cy="50" r="40" stroke="#5cffd6" fill="none" stroke-width="6" stroke-linecap="round"><animate attributeName="stroke-dashoffset" dur="2s" repeatCount="indefinite" from="0" to="502"></animate><animate attributeName="stroke-dasharray" dur="2s" repeatCount="indefinite" values="150.6 100.4;1 250;150.6 100.4"></animate></circle></svg>';

			$this->loader = '<div class="fable-extra-wc-compare-wishlist-loader">' . apply_filters( 'fable_extra_wc_compare_wishlist_loader', $loader ) . '</div>';
		}
		return $this->loader;
	}

	public function build_html_dataattributes( $atts ) {

		$data_atts = '';

		if ( is_array( $atts ) && ! empty( $atts ) ) {

			foreach ( $atts as $key => $attribute ) {

				// Allow only data-* attributes (and prevent malformed keys)
				$attribute_key = 'data-' . sanitize_key( $key );
				$attribute_val = esc_attr( $attribute );

				$data_atts .= ' ' . $attribute_key . '="' . $attribute_val . '"';
			}
		}

		return $data_atts;
	}

	public function get_original_product_id( $id ) {

		global $sitepress;

		if( isset( $sitepress ) ) {

			$id = icl_object_id($id, 'product', true, $sitepress->get_default_language());
		}
		return $id;
	}
}

function fable_extra_wc_compare_wishlist() {

	return FABLE_EXTRA_WC_Compare_Wishlist::instance();
}

fable_extra_wc_compare_wishlist();
