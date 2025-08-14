</div></div>
<footer id="wf_footer" class="wf_footer wf_footer--one clearfix">
	<div class="footer-shape">
		<img src="<?php echo esc_url(get_template_directory_uri());?>/assets/images/footer-shape.png" alt="" class="wow fadeInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
	</div>
	<?php 
		// Footer Top
		do_action('shopire_footer_top'); 
		
		// Footer Widget
		do_action('shopire_footer_widget');

		// Footer Copyright
		do_action('shopire_footer_bottom'); 	
	?>
</footer>
<?php 
	// Top Scroller
	do_action('shopire_top_scroller');
	do_action('shopire_footer_mobile_menu');
?>
<?php 
wp_footer(); ?>
</body>
</html>
