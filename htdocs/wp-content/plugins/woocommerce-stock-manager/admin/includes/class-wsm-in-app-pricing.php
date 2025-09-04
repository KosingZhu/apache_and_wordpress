<?php
/**
 * Class for in app pricing page.
 *
 * @package   woocommerce-stock-manager/admin/includes/
 * @version   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class for pricing page.
 */
class WSM_In_App_Pricing {
	/**
	 * Instance of this class.
	 *
	 * @var      object
	 */
	protected static $instance = null;
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
	 * Initialize the class.
	 */
	private function __construct() {
        if ( ( empty( $_GET['page'] ) ) || ( 'stock-manager-pricing' !== sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) ) {// phpcs:ignore
			return;
		}
		wp_enqueue_style( 'wsm-in-app-pricing-style', WSM_PLUGIN_URL . 'admin/assets/css/in-app-pricing.css', array(), WSM_PLUGIN_VERSION );
		$this->display_pricing_page();
	}

	/**
	 * Display pricing page HTML.
	 */
	public function display_pricing_page() { ?>
		<div id="wsm_in_app_pricing">
			<section class="mt-12 sm:mt-12 lg:mt-12">
				<div class="mt-8 max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
					<div class="mt-12 lg:text-center">
						<p class="text-base font-semibold leading-6 tracking-wide text-indigo-600 uppercase">
							<?php echo esc_html( _x( 'Stock Manager’s Future is Uncertain – Switch to Smart Manager Pro', 'Heading: upgrade notice', 'woocommerce-stock-manager' ) ); ?>
						</p>
						<h2 class="mt-2 text-3xl font-extrabold leading-8 tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
							<?php echo esc_html( _x( 'All Stock Manager features + Bulk Edits, Delete, Duplicate...', 'Subheading: feature list', 'woocommerce-stock-manager' ) ); ?>
						</h2>
						<p class="max-w-2xl mt-4 text-xl leading-7 text-gray-500 lg:mx-auto">
							<?php
							/* Translators: Message about upgrading to Smart Manager Pro */
							echo wp_kses_post(
								_x(
									'With growing demand for bulk editing and complete store management, we’re considering shutting down the Stock Manager plugin. <strong>Upgrade to Smart Manager Pro plugin</strong> now for all-in-one store control, boost productivity and save your time.',
									'Paragraph: upgrade explanation with strong tag',
									'woocommerce-stock-manager'
								)
							);
							?>
						</p>
					</div>
				</div>
			</section>
			<div class="mt-2 max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
				<!-- Table Section -->
				<div class="text-center pt-4 mx-auto lg:pt-8 max-w-4xl">
					<div class="py-2 align-center sm:px-6 lg:px-8">
						<div class="overflow-hidden border border-gray-200 rounded">
							<table class="bg-gray-50 md:min-w-full divide-y divide-gray-200">
								<!-- Table Header -->
								<thead>
									<tr>
									<th class="px-3 py-3 xl:px-4 text-center"><?php echo esc_html( _x( 'FEATURES', 'table header', 'woocommerce-stock-manager' ) ); ?></th>
									<th class="px-3 py-3 xl:px-4 text-center"><?php echo esc_html( _x( 'STOCK MANAGER', 'table header', 'woocommerce-stock-manager' ) ); ?></th>
									<th class="px-3 py-3 xl:px-4 text-center"><?php echo esc_html( _x( 'SMART MANAGER PRO', 'table header', 'woocommerce-stock-manager' ) ); ?></th>
									</tr>
								</thead>
								<!-- Table Body -->
								<tbody class="bg-gray-50 leading-5 text-gray-700 divide-y divide-gray-200">
									<tr>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'Supported Post Types', 'feature row', 'woocommerce-stock-manager' ) ); ?></td>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'Products (Stock)', 'feature value', 'woocommerce-stock-manager' ) ); ?></td>
										<td class="px-3 py-4 xl:px-6"><?php echo wp_kses_post( _x( 'Products (Stock), Orders, Coupons, Pages, Media, Users, SEO plugins, WooCommerce Subscriptions, Bookings, Memberships, Product Add-ons, Brands... <strong>all WordPress custom post types and their custom fields</strong>.', 'feature value', 'woocommerce-stock-manager' ) ); ?></td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'Interface', 'feature row', 'woocommerce-stock-manager' ) ); ?></td>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'Table', 'feature value', 'woocommerce-stock-manager' ) ); ?></td>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'Excel-like spreadsheet', 'feature value', 'woocommerce-stock-manager' ) ); ?></td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'Import & Export Products', 'feature row', 'woocommerce-stock-manager' ) ); ?></td>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'Only stock specific columns', 'feature value', 'woocommerce-stock-manager' ) ); ?></td>
										<td class="px-3 py-4 xl:px-6"><?php echo esc_html( _x( 'All product related columns - including custom fields', 'feature value', 'woocommerce-stock-manager' ) ); ?></td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Inline (Direct) Editing', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Show/Hide Admin Columns', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Product Stock Log (Product History)', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Simple Search', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Bulk Edit/Batch Update', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Undo Inline and Bulk Edits', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Schedule Bulk Edits', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Advanced Search Filters', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Saved Searches and Saved Bulk Edits', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Delete', 'feature row', 'woocommerce-stock-manager' ) ); ?> </strong><?php echo esc_html( _x( 'Products, Orders, Coupons and Other Post Types', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Export', 'feature row', 'woocommerce-stock-manager' ) ); ?> </strong><?php echo esc_html( _x( 'Products, Orders, Coupons and Other Post Types', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Scheduled CSV Exports for WooCommerce Orders', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Duplicate', 'feature row', 'woocommerce-stock-manager' ) ); ?> </strong><?php echo esc_html( _x( 'Products, Orders, Coupons and Other Post Types', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Create Column Sets/Custom Views', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Print PDF Invoices', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Print Packing Slips for Orders In Bulk', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Log for Any Post Type', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'User-Role/User-Based Dashboard Restrictions', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'View Customer Lifetime Value (LTV)', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<strong><?php echo esc_html( _x( 'Manage Custom Taxonomies', 'feature row', 'woocommerce-stock-manager' ) ); ?></strong>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">  
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Rename Admin Column Headers', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">—</td>
										<td class="px-3 py-4 xl:px-6 text-green-500">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-6 w-6 m-auto">
												<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
											</svg>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Support', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'WordPress Forum', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
										<td class="px-3 py-4 xl:px-6">
											<?php echo esc_html( _x( 'Email, Phone, Video Calls', 'feature row', 'woocommerce-stock-manager' ) ); ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- Pricing Section -->
			<div class="mt-12 max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
				<!-- Heading Section -->
				<div class="lg:text-center">
					<p class="text-base font-semibold leading-6 tracking-wide text-indigo-600 uppercase">
						<?php echo esc_html( _x( 'Limited Period Offer - Choose Your Plan', 'pricing subheading', 'woocommerce-stock-manager' ) ); ?>
					</p>
					<h2 id="pricing" class="mt-2 text-3xl font-extrabold leading-8 tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
						<?php echo esc_html( _x( 'Get up to 60% off on Smart Manager Pro', 'pricing heading', 'woocommerce-stock-manager' ) ); ?>
					</h2>
					<p class="max-w-3xl mt-4 text-xl leading-7 text-gray-500 lg:mx-auto">
						<?php echo wp_kses_post( _x( 'Stop opening each product to edit price, stock, category, order status, and other data. <strong>Switch to Smart Manager Pro and spend your time wisely.</strong> Say goodbye to frustration, stress, and calculation errors that keep piling up.', 'pricing description', 'woocommerce-stock-manager' ) ); ?>
					</p>
				</div>
				<div id="sm_price_column_container" class="pb-8 mt-8 sm:mt-8 sm:pb-8 lg:mt-8 lg:pb-8 lg:pt-2 px-40">
					<div class="max-w-md mx-auto lg:max-w-5xl lg:grid lg:grid-cols-3 lg:gap-16">
						<?php
						$plans = array(
							array(
								'label'      => _x( 'Popular', 'pricing badge', 'woocommerce-stock-manager' ),
								'sites'      => _x( '1 site (1 year)', 'pricing plan 1', 'woocommerce-stock-manager' ),
								'old_price'  => '$199',
								'new_price'  => '$149',
								'link'       => 'https://www.storeapps.org/?buy-now=18694&qty=1&coupon=sm-25off-wsm&page=722&with-cart=1&utm_source=wsm&utm_medium=in_app_pricing&utm_campaign=sm-upsell-from-wsm',
								'bg_color'   => 'bg-gray-50',
								'text_color' => 'text-indigo-600',
							),
							array(
								'label'         => _x( 'Best Seller', 'pricing badge', 'woocommerce-stock-manager' ),
								'sites'         => _x( '5 sites (1 year)', 'pricing plan 2', 'woocommerce-stock-manager' ),
								'old_price'     => '$249',
								'new_price'     => '$187',
								'link'          => 'https://www.storeapps.org/?buy-now=18693&qty=1&coupon=sm-25off-wsm&page=722&with-cart=1&utm_source=wsm&utm_medium=in_app_pricing&utm_campaign=sm-upsell-from-wsm',
								'bg_color'      => 'bg-indigo-100',
								'text_color'    => 'text-gray-50',
								'text_bg_color' => 'bg-indigo-600',
							),
							array(
								'label'      => _x( 'Trending', 'pricing badge', 'woocommerce-stock-manager' ),
								'sites'      => _x( '1 site (3 years)', 'pricing plan 3', 'woocommerce-stock-manager' ),
								'old_price'  => '$599',
								'new_price'  => '$249',
								'link'       => 'https://www.storeapps.org/?buy-now=194042&qty=1&coupon=&page=722&with-cart=1&utm_source=wsm&utm_medium=in_app_pricing&utm_campaign=sm-upsell-from-wsm',
								'bg_color'   => 'bg-gray-50',
								'text_color' => 'text-indigo-600',
							),
						);
						foreach ( $plans as $plan ) :
							?>
							<div class="mt-4 overflow-hidden rounded-lg shadow-lg">
								<div class="px-6 py-8 <?php echo esc_attr( $plan['bg_color'] ); ?> sm:p-10 sm:pb-6">
									<div>
										<span class="<?php echo ( ! empty( $plan['text_bg_color'] ) ) ? esc_attr( $plan['text_bg_color'] ) : ''; ?> inline-flex px-4 py-1 text-sm font-semibold leading-5 tracking-wide <?php echo esc_attr( $plan['text_color'] ); ?> uppercase bg-indigo-100 rounded-full">
											<?php echo esc_html( $plan['label'] ); ?>
										</span>
									</div>
									<p class="mt-5 text-xl leading-7 text-gray-500"><?php echo esc_html( $plan['sites'] ); ?></p>
									<div class="flex items-baseline mt-4 text-3xl text-gray-500 leading-none">
										<s><?php echo esc_html( $plan['old_price'] ); ?></s>
										<span class="px-3 flex items-baseline mt-2 text-4xl leading-none"><?php echo esc_html( $plan['new_price'] ); ?></span>
									</div>
									<div class="mt-6 rounded-md shadow">
										<a href="<?php echo esc_url( $plan['link'] ); ?>"
											class="flex items-center justify-center px-5 py-3 text-base font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-500">
											<?php echo esc_html( _x( 'Buy Now →', 'pricing button', 'woocommerce-stock-manager' ) ); ?>
										</a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<!-- Reviews -->
			<section class="mt-8 max-w-3xl pt-12 pb-16 mx-auto sm:pt-16 sm:pb-20 lg:pt-12 lg:pb-12 lg:mt-8 bg-indigo-50">
				<div class="max-w-2xl px-4 mx-auto sm:px-6 lg:px-8">
					<p class="text-2xl font-semibold text-gray-800">
						<?php echo esc_html( _x( 'I would happily pay five times for this product!', 'review headline', 'woocommerce-stock-manager' ) ); ?>
					</p>
					<img src="<?php echo esc_url( 'https://www.storeapps.org/wp-content/uploads/2020/04/premium-product-top-rated@2x.png' ); ?>"
						alt="<?php echo esc_attr( _x( 'Premium Top Rated WooCommerce Plugin', 'image alt', 'woocommerce-stock-manager' ) ); ?>"
						class="w-48 m-3 sm:float-right">

					<p class="mt-2 text-base text-gray-600">
						<?php echo esc_html( _x( 'What really sold me on Smart Manager Pro was Bulk Edit. My assistant does not have to do any complex math now (earlier, I always feared she would make mistakes)! With Smart Manager, she has more free time at hand, so I asked her to set up auto-responder emails. The response was phenomenal. Repeat sales were up by 19.5%.', 'review content', 'woocommerce-stock-manager' ) ); ?>
					</p>

					<div class="flex items-center mt-2 text-base text-gray-800">
						<img src="<?php echo esc_url( 'https://www.storeapps.org/wp-content/uploads/2019/04/jeff-smith.png' ); ?>"
							alt="<?php echo esc_attr( _x( 'Jeff', 'review author alt', 'woocommerce-stock-manager' ) ); ?>"
							class="w-15 h-15 mr-3 rounded-full">
						<span><?php echo esc_html( _x( 'Jeff Smith', 'review author name', 'woocommerce-stock-manager' ) ); ?></span>
					</div>
				</div>
			</section>

			<!-- Call to Action Section -->
			<div class="mt-12 max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
				<!-- Heading Section -->
				<div class="lg:text-center">
					<p class="text-base font-semibold leading-6 tracking-wide text-indigo-600 uppercase">
						<?php echo esc_html( _x( 'Trusted by thousands for a better future', 'cta subheading', 'woocommerce-stock-manager' ) ); ?>
					</p>
					<h2 class="mt-2 text-3xl font-extrabold leading-8 tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
						<?php echo esc_html( _x( 'Join 18000+ happy customers', 'cta heading', 'woocommerce-stock-manager' ) ); ?>
					</h2>
				</div>
				<p class="mt-4 max-w-xl mx-auto text-lg text-gray-600">
					<strong><?php echo esc_html( _x( 'Save time in editing orders, coupons, blog posts, users, WordPress post types, WordPress taxonomies, and more.', 'cta message part 1', 'woocommerce-stock-manager' ) ); ?></strong>
					<?php echo esc_html( _x( 'Experience a 10x productivity boost and massive time-savings with Smart Manager Pro!', 'cta message part 2', 'woocommerce-stock-manager' ) ); ?>
				</p>
				<p class="mt-4 max-w-xl mx-auto text-lg text-gray-600">
					<strong><?php echo esc_html( _x( 'Reclaim precious time', 'cta message part 3 strong', 'woocommerce-stock-manager' ) ); ?></strong>
					<?php echo esc_html( _x( 'to nurture your business and cherish moments with loved ones. If you\'re ready for a life with', 'cta message part 3', 'woocommerce-stock-manager' ) ); ?>
					<strong><?php echo esc_html( _x( 'more freedom and fulfillment', 'cta message part 3 strong 2', 'woocommerce-stock-manager' ) ); ?></strong>,
					<?php echo esc_html( _x( 'Smart Manager is your solution.', 'cta message part 4', 'woocommerce-stock-manager' ) ); ?>
					<a href="#pricing" class="mt-4 flex items-center justify-center px-5 py-3 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
						<?php echo esc_html( _x( 'Select a Plan Now →', 'cta button', 'woocommerce-stock-manager' ) ); ?>
					</a>
				</p>
			</div>
			<div class="max-w-screen-xl px-4 pt-12 pb-16 mx-auto sm:pt-16 sm:pb-20 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
				<!-- Heading -->
				<h2 class="text-center text-3xl font-extrabold leading-9 text-gray-900">
					<?php echo esc_html( _x( 'Still hesitant? Buy with confidence – you’re in good hands', 'confidence heading', 'woocommerce-stock-manager' ) ); ?>
				</h2>
				<!-- Content Section -->
				<div class="pt-10 mt-6 border-t-2 border-gray-100">
					<dl class="md:grid md:grid-cols-2 md:gap-8">
						<!-- StoreApps Reputation -->
						<div>
							<dt class="text-lg font-medium leading-6 text-gray-900">
								<?php echo esc_html( _x( 'You’re buying from the best!', 'subheading reputation', 'woocommerce-stock-manager' ) ); ?>
							</dt>
							<dd class="mt-2 text-base leading-6 text-gray-500">
								<p>
									<?php echo esc_html( _x( 'Rest assured that you will be well taken care of when you buy from StoreApps.', 'reputation message', 'woocommerce-stock-manager' ) ); ?>
								</p>
								<ul class="mt-2 list-disc">
									<li><?php echo esc_html( _x( 'Top selling plugins for marketing and store management', 'reputation bullet', 'woocommerce-stock-manager' ) ); ?></li>
									<li><strong><?php echo esc_html( _x( 'Official WooCommerce', 'reputation bullet bold part', 'woocommerce-stock-manager' ) ); ?></strong> <?php echo esc_html( _x( 'and GoDaddy partner', 'reputation bullet', 'woocommerce-stock-manager' ) ); ?></li>
									<li><?php echo esc_html( _x( 'Founded in 2011, one of the early Woo third-party developers', 'reputation bullet', 'woocommerce-stock-manager' ) ); ?></li>
									<li><strong><?php echo esc_html( _x( '40k+ customers,', 'reputation bullet bold part', 'woocommerce-stock-manager' ) ); ?></strong> <?php echo esc_html( _x( '300k+ users, millions of downloads', 'reputation bullet', 'woocommerce-stock-manager' ) ); ?></li>
									<li><?php echo esc_html( _x( 'Consistent 5-star review ratings', 'reputation bullet', 'woocommerce-stock-manager' ) ); ?></li>
									<li><?php echo esc_html( _x( 'WordPress', 'reputation bullet bold part', 'woocommerce-stock-manager' ) ); ?> <strong><?php echo esc_html( _x( 'community contributor', 'reputation bullet bold part', 'woocommerce-stock-manager' ) ); ?></strong>, <?php echo esc_html( _x( 'sponsor, speaker.', 'reputation bullet', 'woocommerce-stock-manager' ) ); ?></li>
								</ul>
								<p>
									<img src="<?php echo esc_url( 'https://www.storeapps.org/wp-content/uploads/2018/11/trust-badge-guaranteed-safe-checkout-300-grey.png' ); ?>"
										alt="<?php echo esc_attr( _x( 'Guaranteed Safe Checkout', 'image alt', 'woocommerce-stock-manager' ) ); ?>"
										width="300" height="96" class="mt-6">
								</p>
							</dd>
						</div>
						<!-- Support Team Section -->
						<div class="relative mt-12 md:mt-0">
							<dt class="text-lg font-medium leading-6 text-gray-900">
								<?php echo esc_html( _x( 'Friendly support from top-quality developers', 'support heading', 'woocommerce-stock-manager' ) ); ?>
							</dt>
							<dd class="mt-2 text-base leading-6 text-gray-500">
								<p>
									<?php echo esc_html( _x( 'Our plugins are easy to use. We also have ample documentation. But whenever you need further assistance, you will get support from the same people who develop these plugins! We make sure you succeed!', 'support description', 'woocommerce-stock-manager' ) ); ?>
								</p>
								<p>
									<img src="<?php echo esc_url( 'https://www.storeapps.org/wp-content/uploads/2018/01/storeapps-team-support-options-chat-helpful-1024x402.png' ); ?>"
										alt="<?php echo esc_attr( _x( 'StoreApps team is on your side', 'image alt', 'woocommerce-stock-manager' ) ); ?>"
										width="980" height="385"
										srcset="<?php echo esc_attr( 'https://www.storeapps.org/wp-content/uploads/2018/01/storeapps-team-support-options-chat-helpful-1024x402.png 1024w, https://www.storeapps.org/wp-content/uploads/2018/01/storeapps-team-support-options-chat-helpful-450x177.png 450w, https://www.storeapps.org/wp-content/uploads/2018/01/storeapps-team-support-options-chat-helpful-300x118.png 300w, https://www.storeapps.org/wp-content/uploads/2018/01/storeapps-team-support-options-chat-helpful-768x301.png 768w, https://www.storeapps.org/wp-content/uploads/2018/01/storeapps-team-support-options-chat-helpful.png 1491w' ); ?>"
										sizes="(max-width: 980px) 100vw, 980px"
										class="mt-6 lg:absolute lg:bottom-0">
								</p>
							</dd>
						</div>
					</dl>
				</div>
			</div>
		</div>
		<?php
	}
}
WSM_In_App_Pricing::get_instance();

