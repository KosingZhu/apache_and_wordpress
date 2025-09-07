<?php
/**
 * The sidebar containing the main widget area
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shopire
 */
if ( ! is_active_sidebar( 'shopire-sidebar-primary' ) ) {	return; } ?>
<div id="wf-sidebar" class="wf-col-lg-4 wf-col-md-12 wf-col-12">
	<div class="wf_widget-area">
		<?php dynamic_sidebar('shopire-sidebar-primary'); ?>
	</div>
</div>