<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Shopire
 */

get_header();
?>
<section class="not-found wf-py-default">
		<div class="image-404">
			<div class="text-clipping"><?php esc_html_e('404','shopire'); ?></div>
		</div>
		<h4><?php esc_html_e('Page not found!','shopire'); ?></h4>
		<p><?php esc_html_e('Unfortunately, something went wrong and this page does not exist. Try using click the button and return to the Home page.','shopire'); ?></p>
	
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wf-btn wf-btn-primary"><i class="fas fa-arrow-left"></i> <?php esc_html_e('Return To Home','shopire'); ?></a>
</section>
<?php get_footer(); ?>
