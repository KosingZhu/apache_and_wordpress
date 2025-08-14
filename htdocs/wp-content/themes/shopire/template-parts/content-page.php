<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shopire
 */
$shopire_enable_post_excerpt	= get_theme_mod('shopire_enable_post_excerpt','1'); 
$shopire_enable_post_cat		= get_theme_mod('shopire_enable_post_cat','1'); 
$shopire_enable_post_date		= get_theme_mod('shopire_enable_post_date','1'); 
$shopire_enable_post_author		= get_theme_mod('shopire_enable_post_author','1'); 
$shopire_enable_post_comments	= get_theme_mod('shopire_enable_post_comments','1'); 
$shopire_enable_post_views		= get_theme_mod('shopire_enable_post_views'); 
$shopire_enable_post_rt			= get_theme_mod('shopire_enable_post_rt'); 
$shopire_enable_post_tag		= get_theme_mod('shopire_enable_post_tag'); 
$shopire_enable_post_ttl		= get_theme_mod('shopire_enable_post_ttl','1');  
$shopire_enable_post_social		= get_theme_mod('shopire_enable_post_social'); 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('wf_post_item wf_posts--one wf-mb-4'); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="image">
			<?php if($shopire_enable_post_date=='1'): ?>
				<div class="date">
					<span class="day"><?php echo esc_html(get_the_date( 'j' )); ?></span>
					<span class="month"><?php echo esc_html(get_the_date( 'F' )); ?></span>
				</div>
			<?php endif; ?>
			<?php the_post_thumbnail(); ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>"><span class="link"><span></span></span></a>
		</div>
	<?php } ?>
	
	<div class="inner">
		<?php if($shopire_enable_post_cat=='1'): ?>
			<div class="catetag">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="category tag"><?php the_category(' , '); ?></a>
			</div>
		<?php    
			endif;
			if($shopire_enable_post_ttl=='1'):
				if ( is_single() ) :
				
				the_title('<h5 class="title">', '</h5>' );
				
				else:
				
				the_title( sprintf( '<h5 class="title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
				
				endif; 
			endif;
		?> 
		<div class="meta">
			<ul>
				<?php if($shopire_enable_post_author=='1'): ?>
					<li>
						<div class="author">                                                    
							<img src="<?php echo esc_url( get_avatar_url( absint(get_the_author_meta( 'ID' )) ) ); ?>" width="90" height="90" alt="<?php esc_attr(the_author()); ?>" class="avatar">
							<a href="<?php echo esc_url(get_author_posts_url( absint(get_the_author_meta( 'ID' )) ));?>"><span><?php esc_html(the_author()); ?></span></a>
						</div>
					</li>
				<?php endif; ?>
				
				<?php if($shopire_enable_post_comments=='1'): ?>
					<li>
						<div class="reply">
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<i class="far fa-message" aria-hidden="true"></i>
								<span class="count"><?php echo esc_html(get_comments_number($post->ID)); ?></span>
							</a>
						</div>
					</li>
				<?php endif; ?>
				
				<?php if($shopire_enable_post_views=='1'): ?>
					<li><i class="far fa-eye"></i> <?php echo wp_kses_post(shopire_get_post_view(get_the_ID())); ?></li>
				<?php endif; ?>	
				
				<?php if($shopire_enable_post_rt=='1'): ?>
					<li><i class="fa-solid fa-eye"></i> <?php echo esc_html(shopire_read_time()); ?></li>
				<?php endif; ?>
				
				<?php if($shopire_enable_post_tag=='1'): ?>
					<li>
						<i class="fa-solid fa-tag"></i>
					<?php
						$posttags = get_tags();
						if($posttags):
							foreach($posttags as $index=>$tag){
								echo '<a href="'.esc_url(get_tag_link($tag->term_id)).'">' .esc_html($tag->name). '</a>, ';
								 if($index>7){break;}
							}
						endif; 
					 ?>
					</li>
				<?php endif; ?>
				
				<?php if($shopire_enable_post_social=='1'): ?>
					<li>
						<?php do_action('shopire_post_sharing'); ?>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="content clear">
			<?php 
				  if($shopire_enable_post_excerpt == '1' && !is_single()):
				  
					the_excerpt();
					if ( function_exists( 'shopire_execerpt_btn' ) ) : shopire_execerpt_btn(); endif; 
					
					else:
					
					the_content( 
							sprintf( 
								__( 'Read More', 'shopire' ), 
								'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
							) 
						);
						
					endif;	
			?>
		</div>
	</div>
</article>