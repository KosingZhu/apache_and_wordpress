( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['plugin-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );


function shopirefrontpagesectionsscroll( shopire_section_id ){
    var navigation_id = "wf_slider";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( shopire_section_id ) {
        case 'accordion-section-product_cat_options':
        navigation_id = "wf_product_category";
        break;
		
		case 'accordion-section-popular_product_options':
        navigation_id = "wf_popular_product";
        break;
		
		case 'accordion-section-cta_options':
        navigation_id = "wf_hurry_section";
        break;
		
		case 'accordion-section-blog_options':
        navigation_id = "wf_posts";
        break;
    }

    if( $contents.find('#'+navigation_id).length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + navigation_id ).offset().top
        }, 1000);
    }
}



 jQuery('body').on('click', '#sub-accordion-panel-shopire_frontpage_options .control-subsection .accordion-section-title', function(event) {
        var shopire_section_id = jQuery(this).parent('.control-subsection').attr('id');
        shopirefrontpagesectionsscroll( shopire_section_id );
});