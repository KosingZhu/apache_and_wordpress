<?php
$activate_theme_widget = array(
        'shopire-sidebar-primary' => array(
            'search-1',
            'recent-posts-1',
            'archives-1',
        ),
		'shopire-footer-widget-1' => array(
            'text-1',
        ),
		'shopire-footer-widget-2' => array(
            'text-2',
        ),
		'shopire-footer-widget-3' => array(
            'text-3',
        ),
		'shopire-footer-widget-4' => array(
            'text-4',
        )
    );
    /* the default titles will appear */
	update_option('widget_text', array(
		1 => array('title' => '',
        'text'=>'<aside class="widget widget_block">
                            <div class="wp-widget-group__inner-blocks">
                                <a href="index.html" class="custom-logo-link" rel="home" aria-current="page">
                                    <img width="150" height="36" src="'.esc_url(WPFE_URL) . '/inc/themes/shopire/assets/images/logo.png" class="custom-logo" alt="LogoShop">
                                </a>
                                <p class="wf-mt-4 wf-mb-3">We work with a passion of taking challenges and creating new ones in advertising sector.</p>
                                <ol class="list_none inf_list">
                                    <li>
                                        <a href="#">
                                            <i aria-hidden="true" class="text-primary wf-mr-2 fal fa-phone-volume"></i> <span>+1-888-452-1505</span>
                                        </a>
                                    </li>
                                    <li>
                                        <i aria-hidden="true" class="text-primary wf-mr-2 far fa-clock"></i> <span>Mon – Sat: 9:00 am – 5:00 pm,<br> Sunday: <strong class="text-primary">CLOSED</strong>
                                    </li>
                                </ol>
                                <a href="#" class="wf-btn wf-btn-primary wf-mt-4"><i class="far fa-calendar"></i> Get a Quote</a>
                            </div>
                        </aside>'),
		2 => array('',
        'text'=>'<aside class="widget widget_nav_menu">
                            <h5 class="widget-title">Quick Links</h5>
                            <div class="menu-services-container">
                                <ul id="menu-services-menu" class="menu">
                                    <li class="menu-item"><a href="#">Company</a></li>
                                    <li class="menu-item"><a href="#">How it’s Work</a></li>
                                    <li class="menu-item"><a href="#">Service</a></li>
                                    <li class="menu-item"><a href="#">Case Studies</a></li>
                                    <li class="menu-item"><a href="#">Privacy Policy</a></li>
                                    <li class="menu-item"><a href="#">Support</a></li>
                                    <li class="menu-item"><a href="#">Press media</a></li>
                                    <li class="menu-item"><a href="#">Careers</a></li>
                                    <li class="menu-item"><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </aside>'),	
		3 => array('title' => '',
        'text'=>'<aside class="widget widget_block">
		<h5 class="widget-title">Official Info</h5>
        <div class="wp-widget-group__inner-blocks">
            <ol class="list_none inf_list">
                <li>
                    <a href="#">
                        <i aria-hidden="true" class="text-primary wf-mr-2 fas fa-map-marker-alt"></i> <span>855 Kim Road, Broklyn Street,<br> New York USA</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i aria-hidden="true" class="text-primary wf-mr-2 fas fa-phone-alt"></i> <span>+1-888-452-1505</span>
                    </a>
                </li>
                <li>
                    <strong class="wf-d-block wf-mt-3 wf-mb-1">Open Hours:</strong> Mon – Sat: 9:00 am – 5:00 pm,<br> Sunday: CLOSED
                </li>
            </ol>
        </div>
    </aside>'),	
		4 => array('title' => '',
        'text'=>'<aside class="widget widget_block">
                            <h5 class="widget-title">Opening Hours</h5>
                            <div class="wf_business_hour">
                                <div class="wf_business_schedule no">
                                    <span class="wf_business_day">Week Days</span>
                                    <span class="wf_business_time">10:00 - 17:00</span>
                                </div>
                                <div class="wf_business_schedule no">
                                    <span class="wf_business_day">Saturday</span>
                                    <span class="wf_business_time">10:00 - 15:00 </span>
                                </div>
                                <div class="wf_business_schedule ">
                                    <span class="wf_business_day">Sunday</span>
                                    <span class="wf_business_time">Day Off</span>
                                </div>
                                <div class="wf_business_btn wf-mt-4">
                                    <a href="#" class="wf-btn wf-btn-primary">Contact us</a>
                                </div>
                            </div>
                        </aside>'),	
        ));
		 update_option('widget_categories', array(
			1 => array('title' => 'Categories'), 
			2 => array('title' => 'Categories')));

		update_option('widget_archives', array(
			1 => array('title' => 'Archives'), 
			2 => array('title' => 'Archives')));
			
		update_option('widget_search', array(
			1 => array('title' => 'Search'), 
			2 => array('title' => 'Search')));	
		
    update_option('sidebars_widgets',  $activate_theme_widget);
	$MediaId = get_option('shopire_media_id');
	set_theme_mod( 'custom_logo', $MediaId[0] );