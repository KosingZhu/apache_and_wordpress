<?php
/**
 * Stock Manager
 *
 * @package  woocommerce-stock-manager/public/
 * @version  3.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class for Stock Manager.
 */
class Stock_Manager {

	/**
	 * Plugin slug
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'stock-manager';

	/**
	 * Instance of this class.
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting activation, table, stock updates and loading public scripts and styles.
	 */
	private function __construct() {

		// Activate plugin when new blog is added.
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action( 'init', array( $this, 'output_buffer' ) );

		add_action( 'init', array( $this, 'create_table' ) );

		add_action( 'woocommerce_product_set_stock', array( $this, 'save_stock' ) );
		add_action( 'woocommerce_variation_set_stock', array( $this, 'save_stock' ) );

		// Action to declare WooCommerce HPOS compatibility.
		add_action( 'before_woocommerce_init', array( $this, 'declare_hpos_compatibility' ) );
		// to filter products based on stock status.
		add_filter( 'woocommerce_rest_product_object_query', array( $this, 'modify_stock_status_filter' ), 99, 2 );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses
	 *                                    "Network Activate" action, false if
	 *                                    WPMU is disabled or plugin is
	 *                                    activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids.
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses
	 *                                    "Network Deactivate" action, false if
	 *                                    WPMU is disabled or plugin is
	 *                                    deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids.
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @param    int $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids.
		$result = $wpdb->get_col( // phpcs:ignore
			$wpdb->prepare( // phpcs:ignore
				"SELECT blog_id
									FROM $wpdb->blogs
									WHERE archived = %d AND spam = %d AND deleted = %d",
				0,
				0,
				0
			)
		);

		return $result;

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 */
	private static function single_activate() {

	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 */
	private static function single_deactivate() {

	}

	/**
	 * Headers allready sent fix
	 */
	public function output_buffer() {
		ob_start();
	}

	/**
	 * Create table if not exists
	 */
	public function create_table() {

		global $wpdb;

		$wpdb->hide_errors();

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table = "
            CREATE TABLE {$wpdb->prefix}stock_log (
                ID bigint(255) NOT NULL AUTO_INCREMENT,
                date_created datetime NOT NULL,
                product_id bigint(255) NOT NULL,
                qty int(10) NOT NULL,
                PRIMARY KEY  (`ID`)
            ) $collate;
        ";
		dbDelta( $table );

	}

	/**
	 * Save stock change
	 *
	 * @param WC_Product $product Product Object.
	 */
	public function save_stock( $product ) {

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		global $wpdb;

		$data                 = array();
		$data['date_created'] = gmdate( 'Y-m-d H:i:s', time() );
		$data['product_id']   = $product->get_id();
		$data['qty']          = $product->get_stock_quantity();
		$data['qty']          = ( empty( $data['qty'] ) ) ? 0 : intval( $data['qty'] );

		$wpdb->query( // phpcs:ignore
			$wpdb->prepare( // phpcs:ignore
				"INSERT INTO {$wpdb->prefix}stock_log ( date_created, product_id, qty ) VALUES ( %s, %d, %d ) ",
				$data
			)
		);

	}

	/**
	 * Function to declare WooCommerce HPOS compatibility
	 */
	public function declare_hpos_compatibility() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', 'woocommerce-stock-manager/woocommerce-stock-manager.php', true );
		}
	}
		/**
		 * Modify the WooCommerce REST API product query to filter products based on stock status.
		 *
		 * @param array           $args The query arguments.
		 * @param WP_REST_Request $request The REST API request object.
		 * @return array Modified query arguments.
		 */
	public function modify_stock_status_filter( $args = array(), $request = null ) {
		// Retrieve query parameters from the REST request.
		$params = is_callable( array( $request, 'get_query_params' ) ) ? $request->get_query_params() : array();
		// Check if the necessary parameters are present and not empty.
		if ( ( empty( $params ) ) || ( ! is_array( $params ) ) || ( empty( $params['wsm_filter'] ) ) || ( empty( $params['stock_status'] ) ) || ( 'true' !== $params['wsm_filter'] ) ) {
			return $args;
		}
		$product_ids = array();
		// Handle stock statuses.
		switch ( $params['stock_status'] ) {
			case 'outofstock':
				// Remove stock_status value to avoid setting it in the meta query.
				$request['stock_status'] = '';
				$product_ids             = $this->filter_out_of_stock_products();
				break;
			default:
				$product_ids = array();
				break;
		}
		// Update the query arguments if we have any matching IDs.
		if ( ( ! empty( $product_ids ) ) && ( is_array( $product_ids ) ) ) {
			$args['post__in'] = array_unique( array_merge( ! empty( $args['post__in'] ) ? $args['post__in'] : array(), $product_ids ) );
		}
		return $args;
	}

	/**
	 * Get products and variations based on 'outofstock' status.
	 *
	 * @return array Modified query arguments.
	 */
	public function filter_out_of_stock_products() {
		global $wpdb;
		// Get product IDs and parent product IDs of variations that are out of stock.
		$combined_ids = $wpdb->get_col(// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->prepare(
				"
			SELECT DISTINCT 
				CASE 
					WHEN p.post_type = 'product' THEN p.ID
					WHEN p.post_type = 'product_variation' THEN p.post_parent
				END AS product_id
			FROM {$wpdb->posts} AS p
			INNER JOIN {$wpdb->postmeta} AS pm 
			ON p.ID = pm.post_id
			AND pm.meta_key = '_stock_status'
			AND pm.meta_value = %s
			WHERE p.post_type IN ('product', 'product_variation')
		",
				'outofstock'
			)
		);
		// Update the query arguments if we have any matching IDs.
		return ! empty( $combined_ids ) ? $combined_ids : array();
	}

}//end class
