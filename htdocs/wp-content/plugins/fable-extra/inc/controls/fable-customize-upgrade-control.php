<?php
/** 
 * Customize Upgrade control class.
 *
 * @package Fable Extra
 * 
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Fable_Extra_Customize_Upgrade_Control
 */
 
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

class Fable_Extra_Customize_Upgrade_Control extends WP_Customize_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'fable-extra-upgrade';

	/**
	 * Renders the Underscore template for this control.
	 *
	 * @see    WP_Customize_Control::print_template()
	 * @access protected
	 * @return void
	 */
	protected function content_template() {
		
	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {
		$fable_activated_theme = wp_get_theme(); // gets the current theme
		if('MiniCart' == $fable_activated_theme->name):
			$upgrade_to_pro_link = 'https://wpfable.com/themes/minicart-premium/';
		elseif('EazyShop' == $fable_activated_theme->name):	
			$upgrade_to_pro_link = 'https://wpfable.com/themes/eazyshop-premium/';	
		elseif('EasyBuy' == $fable_activated_theme->name):	
			$upgrade_to_pro_link = 'https://wpfable.com/themes/easybuy-premium/';
		elseif('eKart' == $fable_activated_theme->name):	
			$upgrade_to_pro_link = 'https://wpfable.com/themes/ekart-premium/';	
		else:	
			$upgrade_to_pro_link = 'https://wpfable.com/themes/shopire-premium/';
		endif;	
		?>

		<div class="fable-extra-upgrade-message" style="display:none";>
			<?php if(!empty($this->label)): ?>
				<h4 class="customize-control-title"><?php echo wp_kses_post( 'Upgrade to <a href="'.esc_url($upgrade_to_pro_link).'" target="_blank" > '.esc_html($fable_activated_theme). ' Pro </a> to be add More ', 'fable-extra') . esc_html($this->label); ?></h4>
			<?php endif; ?>
		</div>

		<?php
	}

}