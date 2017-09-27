<?php
/**
 * Helper functions
 *
 * @package nrg_premium
 * @since 1.0.0
 *
 */
//include plugin.php
get_template_part( ABSPATH . 'wp-admin/includes/plugin' );
/**
 * Get social links list
 */
if ( ! function_exists( 'nrg_premium_get_social' ) ) {
	function nrg_premium_get_social(){
		$output = '';
		$fb_link = nrgOption('fb_link');
		$tw_link = nrgOption('tw_link');
		$in_link = nrgOption('in_link');
		$g_link  = nrgOption('g_link');
		if ($fb_link || $tw_link || $in_link || $g_link) {
			if ($fb_link) {
				$output .= '<a href="'.esc_url($fb_link).'" target="_blank"><span class="fa fa-facebook"></span></a>';
			}
			if ($tw_link) {
           		$output .= '<a href="'.esc_url($tw_link).'" target="_blank"><span class="fa fa-twitter"></span></a>';
	        }
            if ($in_link) {
            	$output .= '<a href="'.esc_url($in_link).'" target="_blank"><span class="fa fa-linkedin"></span></a>';
	        }
            if ($g_link) { 
            	$output .= '<a href="'.esc_url($g_link).'" target="_blank"><span class="fa fa-google-plus"></span></a>';
	        }
			echo $output;
		}
	}
}
/**
 * Get social links list
 */
if ( ! function_exists( 'nrg_premium_footer_social' ) ) {
	function nrg_premium_footer_social(){
		$output = '';
		$fb_link = nrgOption('fb_link');
		$tw_link = nrgOption('tw_link');
		$in_link = nrgOption('in_link');
		$g_link  = nrgOption('g_link');
		if ($fb_link || $tw_link || $in_link || $g_link) {
			// $output .= '<div class="follow-wide-link">';
			if ($fb_link) {
			$output .= '<a href="'.esc_url($fb_link).'" target="_blank"><span>'.esc_html__('facebook','nrg_premium').'</span><i class="fa fa-facebook"></i></a>';
			}
			if ($tw_link) {
            $output .= '<a href="'.esc_url($tw_link).'" target="_blank"><span>'.esc_html('twitter','nrg_premium').'</span><i class="fa fa-twitter"></i></a>';
            }
            if ($in_link) {
            $output .= '<a href="'.esc_url($in_link).'" target="_blank"><span>'.esc_html('linkedin','nrg_premium').'</span><i class="fa fa-linkedin"></i></a>';
            }
            if ($g_link) { 
            $output .= '<a href="'.esc_url($g_link).'" target="_blank"><span>'.esc_html('google','nrg_premium').'</span><i class="fa fa-google-plus"></i></a>';
	        }
			// $output.= '</div>'; 
			echo $output;
		}
	}
}
/**
 * Return theme logo
 D:\OpenServer\domains\UNITpremium.loc\wp-content\themes\NRGpremium\assets\img
 */
if ( ! function_exists( 'nrg_premium_logo' ) ) {
	function nrg_premium_logo(){
		$site_logo = nrgOption('site_logo');
		if ( $site_logo ) {
			print wp_kses_post('<img src="'. esc_url( $site_logo ) .'" alt="NRG" class="img-scrll hlogo-black" />');
		} else {
			print wp_kses_post('<img src="'. get_template_directory_uri().'/assets/img/logo.png" alt="NRG-logo" />');
		}
	}
}
if ( ! function_exists( 'nrg_premium_logo_2' ) ) {
	function nrg_premium_logo_2(){
		$site_logo_2 = nrgOption('site_logo_2');
		if ( $site_logo_2 ) {
			print wp_kses_post('<img src="'. esc_url( $site_logo_2 ) .'" alt="NRG" class="hlogo-white" />');
		} else {
			print wp_kses_post('<img src="'. get_template_directory_uri().'/assets/img/logo_white.png" alt="NRG-logo" />');
		}
	}
}
/**
 * Return theme footer logo
 */
if ( ! function_exists( 'nrg_premium_f_logo' ) ) {
	function nrg_premium_f_logo(){
		$footer_logo = nrgOption('footer_logo');
		if ( $footer_logo ) {
			print wp_kses_post('<img src="'. esc_url( $footer_logo ) .'" alt="NRG-logo" />');
		} else {
			print wp_kses_post('<img src="'. get_template_directory_uri().'/themes/assets/img/logo.png" alt="NRG-logo" />');
		}
	}
}
/**
 * Favicon
 */
if ( ! function_exists( 'nrg_premium_favicon' ) ) {
	function nrg_premium_favicon($class = ''){
		$favicon = nrgOption('favicon');
		if(!function_exists('wp_site_icon')) {
        if(!has_site_icon() and !empty($favicon)) {
            update_option('site_icon', $favicon);
        }
        wp_site_icon();
        } elseif(!empty($favicon)){ 
     	    print '<link rel="shortcut icon" href="'.esc_url($favicon).'"/>';
 		} else {
			print '<link rel="shortcut icon" href="'.NRG_PREMIUM_URI.'/assets/img/favicon.png"/>';
 		}
	}
}
/**
 * Addres helper
 */
if ( ! function_exists( 'nrg_premium_address_helper' ) ) {
	function nrg_premium_address_helper(){
		$address_info = nrgOption('address_info');
		$email_info = nrgOption('email_info');
		$phone_info = nrgOption('phone_info');
		$output_phone = preg_replace( '/[^0-9]/', "", $phone_info );
		if ( $address_info || $email_info || $phone_info) { ?>
			<div class="empty-md-60 empty-sm-40 empty-xs-40"></div>
			<ul>
				<?php if ( $address_info ) { ?>
				<li class="address-item">
					<div class="empty-sm-15 empty-xs-15"></div>
					<h6 class="h7 title"><?php print esc_html__('Address:','nrg_premium') ?></h6>
					<div class="empty-sm-10 empty-xs-10"></div>
					<p><?php print wp_kses_post($address_info); ?></p> 
					<div class="empty-sm-10 empty-xs-10"></div>
				</li>
				<?php }
				if ( $phone_info ) { ?>
				<li class="address-item">
					<div class="empty-sm-15 empty-xs-15"></div>
					<h6 class="h7 title"><?php print esc_html__('Reseption:','nrg_premium') ?></h6>
					<div class="empty-sm-10 empty-xs-10"></div>
					<a href="tel:+<?php print esc_html($output_phone); ?>"><?php print esc_html($phone_info); ?></a>
					<div class="empty-sm-10 empty-xs-10"></div>
				</li>
				<?php }
				if ( $email_info ) { ?>
				<li class="address-item">
					<div class="empty-sm-15 empty-xs-15"></div>
					<h6 class="h7 title"><?php print esc_html__('Email:','nrg_premium') ?></h6>
					<div class="empty-sm-10 empty-xs-10"></div>
					<a href="mailto:<?php print esc_html($email_info); ?>"><?php print esc_html($email_info); ?></a>
					<div class="empty-sm-10 empty-xs-10"></div>
				</li>
				<?php } ?>
			</ul>
		<?php }
	}
}
/**
 *  Footer button
 */
if ( ! function_exists( 'nrg_premium_f_button' ) ) {
	function nrg_premium_f_button(){
		$f_button_text = nrgOption('f_button_text');
		$f_button_link = nrgOption('f_button_link');
		if ($f_button_text && $f_button_link) {

			print wp_kses_post('<div class="empty-sm-40 empty-xs-40"></div>');
			print wp_kses_post('<a href="'.esc_html($f_button_link).'" class="main-link link-style-1 f_but"><span>'.esc_html($f_button_text).'</span></a>');

			$custom_css = '';
			$header_but_col = nrgOption('header_but_col');
			if( isset($header_but_col) && $header_but_col ){
				$custom_css.= '.f_but.link-style-1:before {border-color:'.$header_but_col.';}';
				$custom_css.= '.f_but.link-style-1:after {background:'.$header_but_col.';}';
				$custom_css.= '.f_but.link-style-1 span{color: '.$header_but_col.' !important;}';
				$custom_css.= '.f_but.link-style-1:hover span{color: #fff !important;}';
			}
			if( $custom_css ){ ?>
				<style type="text/css"><?php echo esc_html($custom_css); ?></style>
			<?php }
		}
	}
}
/**
 * Copyright
 */
if ( ! function_exists( 'nrg_premium_copyright' ) ) {
	function nrg_premium_copyright(){
		$copyright = nrgOption('copyright_text');
		if( $copyright ){
			$footer_layout = nrgOption('footer_layout');
			if ($footer_layout == '1') {
				print wp_kses_post('<div class="empty-sm-30 empty-xs-30"></div>');
			} elseif ($footer_layout == '2') {
				print wp_kses_post('<div class="empty-sm-50 empty-xs-20"></div>');
			} else {
				print wp_kses_post('<div class="empty-sm-40 empty-xs-40"></div>');
			}
			print wp_kses_post('<div class="copyright"><span>'.esc_html($copyright).'</span></div>');
		} 
	}
}
/* Custom JavaScript code */
if ( !function_exists( 'nrg_premium_custom_js' ) ){
	function nrg_premium_custom_js(){
		$output_js = '';
		$custom_js_code = nrgOption('custom_js_code');
		if ( $custom_js_code ){
			$output_js = $custom_js_code;
		}
		return $output_js;
	}
}
/** Custom styles from Theme Options */
if ( !function_exists( 'nrg_premium_custom_styles' ) ){
	function nrg_premium_custom_styles(){
		$output = '';
		/* Custom menu typography */
		$default_header_typography = nrgOption('default_header_typography');
		if ( !$default_header_typography ){
			$typo = nrgOption('header_typography_group');
			if ( !empty( $typo['header_typography']['family'] ) ) {
				$output .= '.header a {font-family:' . $typo['header_typography']['family'] . ';}' . "\n\r";

				if ( $typo['header_typography']['font'] == 'google' ) {
					$output .= '@import url( "https://fonts.googleapis.com/css?family=' . $typo['header_typography']['family'] . ':' . $typo['header_typography']['variant'].'");'."\n\r";
				}
			}
			if ( !empty( $typo['header_font_size'] ) ) {
				$output .= '.header a {font-size:' . $typo['header_font_size'] . 'px;}' . "\n\r";
			}
			if ( !empty( $typo['header_font_color'] ) ) {
				$output .= '.header a {color:' . $typo['header_font_color'] . ';}' . "\n\r";
			}
		}
		/* Footer menu typography */
		if ( !nrgOption('default_footer_typography') ) {
			$typo = nrgOption('footer_typography_group');

			if ( ! empty( $typo['footer_typography']['family'] ) ) {
				$output .= '.footer________ {font-family:' . $typo['footer_typography']['family'] . ';}' . "\n\r";

				if ( $typo['footer_typography']['font'] == 'google' ) {
					$output .= '@import url( "https://fonts.googleapis.com/css?family=' . $typo['footer_typography']['family'] . ':' . $typo['footer_typography']['variant'].'");'."\n\r";
				}
			}
			if ( ! empty( $typo['footer_font_size'] ) ) {
				$output .= '.footer________ {font-size:' . $typo['footer_font_size'] . 'px;}' . "\n\r";
			}
			if ( ! empty( $typo['footer_font_color'] ) ) {
				$output .= '.footer________ {color:' . $typo['footer_font_color'] . ';}' . "\n\r";
			}
		}
		/* Meta Box */
			if( class_exists('Woocommerce') && (is_woocommerce() || is_cart() || is_checkout()))
				$id = ( wc_get_page_id('shop') ? wc_get_page_id('shop') : get_the_ID() );
			else 
				$id = get_the_ID();

		$post_meta = get_post_meta( $id, '_custom_page_options', true );
		if( isset($post_meta['menu_color']) && $post_meta['menu_color'] ) {
			$output.= '.header nav > ul > li > a:hover, .header nav > ul > li.current-menu-item > a, .header nav > ul > li.current-menu-parent > a {color:'.$post_meta['menu_color'].'!important;}'."\n\r";
			$output.= '.header nav > ul > li.current-menu-item > a:before, .header nav > ul > li.current-menu-parent > a:before {left: 0;}';
			$output.= '.header-style-3 .header-folow.fin a:hover span {color:'.$post_meta['menu_color'].'!important;}';
			$output.= '.header-style-3.type-1 .header-folow a:hover span {color:'.$post_meta['menu_color'].'!important;}';
			$output.= '@media screen and (max-width: 992px){.header nav > ul > li > a:hover, .header nav > ul > li.current-menu-item > a, .header nav > ul > li.current-menu-parent > a {color: inherit !important;}}';
		}
		if( isset($post_meta['menu_hov_color']) && $post_meta['menu_hov_color'] ) {
			$output.= '.header nav > ul > li > a:before, .header nav > ul > li.current-menu-item > a:before, .header nav > ul > li.current-menu-parent > a:before {background:'.$post_meta['menu_hov_color'].'!important;}'."\n\r";
			$output.= '.header nav > ul > li.current-menu-item > a:before, .header nav > ul > li.current-menu-parent > a:before {left: 0;}';
			$output.= '.header-style-3 .header-folow a:hover span {color:'.$post_meta['menu_hov_color'].'!important;}';
			$output.= '.folow-style-1 a span:after {background:'.$post_meta['menu_hov_color'].'!important;}';
			$output.= '.header-style-3.head-2 .header-folow a:hover span {color:'.$post_meta['menu_hov_color'].'!important;}';
			$output.= '@media screen and (max-width: 992px){.header nav > ul > li.current-menu-item > a, .header nav > ul > li.current-menu-parent > a, .header nav > ul > li.current-menu-item > a:hover, .header nav > ul > li.current-menu-parent > a:hover, .header nav > ul > li.current-menu-parent > ul > li.current-menu-item > a:hover, .header nav > ul > li.current-menu-parent > ul > li.current-menu-item > a, .header nav > ul > li > a.anchor-link.active {color: '.$post_meta['menu_hov_color'].'!important;}}';
			if ($post_meta['menu_hov_color'] == '#fff') {
				$output.= '@media screen and (max-width: 992px){.header nav > ul > li.current-menu-item > a, .header nav > ul > li.current-menu-parent > a, .header nav > ul > li.current-menu-item > a:hover, .header nav > ul > li.current-menu-parent > a:hover, .header nav > ul > li.current-menu-parent > ul > li.current-menu-item > a:hover, .header nav > ul > li.current-menu-parent > ul > li.current-menu-item > a {color: #999 !important;}}';
			}
		}
		/* Custom CSS styles */
		$custom_css_styles = nrgOption('custom_css_styles');
		if ( $custom_css_styles) {
			$output .= $custom_css_styles;
		}
		return $output;
	}
}               
/**
 * Body class
 */
function nrg_premium_body_classes( $classes ){

	if( class_exists('Woocommerce') && (is_woocommerce() || is_cart() || is_checkout() ) )
		$id = ( wc_get_page_id('shop') ? wc_get_page_id('shop') : get_the_ID() );
	else 
		$id = get_the_ID();
	$post_meta     = get_post_meta( $id, '_custom_page_options', true );
	$font_class_page = nrgOption('font_class_page');
	$border_class_page = nrgOption('border_class_page');
	// FONT TYPE
		// Page options
	if( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_1' ){
		$classes[] = 'font-style-1';
	}	elseif( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_2' ){
		$classes[] = 'font-style-2';
	}	elseif( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_3' ){
		$classes[] = 'font-style-3';
	}	elseif( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_4' ){
		$classes[] = 'font-style-4';
	}	elseif( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_5' ){
		$classes[] = 'font-style-5';
	}	elseif( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_6' ){
		$classes[] = 'font-style-6';
	}	elseif( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_7' ){
		$classes[] = 'font-style-7';
	}	elseif( isset($post_meta['font_class_page']) && $post_meta['font_class_page'] && $post_meta['font_class_page'] == 'font_style_8' ){
		$classes[] = 'font-style-8';
	}	else {
		// Theme options
		$font_style = nrgOption('font_style');
		if ($font_style == 'font_style_1') { $classes[] = 'font-style-1';}
		elseif ($font_style == 'font_style_2') { $classes[] = 'font-style-2';} 
		elseif ($font_style == 'font_style_3') { $classes[] = 'font-style-3';} 
		elseif ($font_style == 'font_style_4') { $classes[] = 'font-style-4';} 
		elseif ($font_style == 'font_style_5') { $classes[] = 'font-style-5';} 
		elseif ($font_style == 'font_style_6') { $classes[] = 'font-style-6';} 
		elseif ($font_style == 'font_style_7') { $classes[] = 'font-style-7';} 
		elseif ($font_style == 'font_style_8') { $classes[] = 'font-style-8';} 
		else { $classes[] = 'font-style-1';}
	}
	// BORDER TYPE
		// Page options
	if( isset($post_meta['border_class_page']) && $post_meta['border_class_page'] && $post_meta['border_class_page'] == 'border_style' ){
		$classes[] = 'border-style';
	}	elseif( isset($post_meta['border_class_page']) && $post_meta['border_class_page'] && $post_meta['border_class_page'] == 'no_border' ){
		$classes[] = '';
	}	elseif( isset($post_meta['border_class_page']) && $post_meta['border_class_page'] && $post_meta['border_class_page'] == 'frame_style' ){
		$classes[] = 'frame-style';
	}	elseif( isset($post_meta['border_class_page']) && $post_meta['border_class_page'] && $post_meta['border_class_page'] == 'border_style_grey' ){
		$classes[] .= 'border-style';
		$classes[] .= 'grey-border';
	}	else {
		// Theme options
		$border_style = nrgOption('border_style');
		if 	   ($border_style == 'no_border') {$classes[] = '';}
		elseif ($border_style == 'border_style') {$classes[] = 'border-style';}
		elseif ($border_style == 'border_style_grey') {$classes[] = 'border-style'; $classes[] = 'grey-border'; }
		elseif ($border_style == 'frame_style') {$classes[] = 'frame-style';}
		else  	{$classes[] = '';}
	}
    return $classes;
}
add_filter('body_class', 'nrg_premium_body_classes');                              
/**
 *
 * Get categories functions for shortcode. Return array lists
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'nrg_premium_param_values' ) ) {
	function nrg_premium_param_values( $post_type = 'terms', $query_args = array(), $order = 'ASC' ) {
		$list = array();
		//check type
		switch( $post_type ) {
			case 'posts': // get posts
				$posts = get_posts( $query_args );
				if ( ! empty( $posts ) ) {
					foreach ( $posts as $post ) {
						$list[ $post->post_title ] = esc_html( $post->post_name );
					}
				} else {
					$list[ esc_html__('not found posts','nrg_premium') ] = '';
				}
			break;
			case 'pages': // get pages
				$posts = get_posts( $query_args );
				if( !empty( $posts ) ){
					foreach( $posts as $post ){
						if( $order == 'ASC' )
							$list[ $post->post_title ] = $post->ID;
						else
							$list[ $post->ID ] = $post->post_title;
					}
				} else {
					$list[ esc_html__('not found pages','nrg_premium') ] = '';
				}
			break;
			case 'terms': // get terms
				$taxonomies = ! empty( $query_args['taxonomies'] ) ? $query_args['taxonomies'] : 'portfolio_categories';
				$terms = get_terms( $taxonomies, $query_args );
				if( $terms ){
					foreach( $terms as $key => $term ){
						if( $term && is_object($term) ) {
							if( $order == 'ASC' )
								$list[$term->name] = $term->term_id;
							else
								$list[$term->term_id] = $term->name;
						}
					}
				} else {
					$list[ esc_html__('not found terms or terms empty','nrg_premium') ] = '';
				}
			break;
			case 'categories': // get categories
				$categories = get_categories( $query_args );
				if ( ! empty( $categories ) ) {
					if(is_array($categories)){
						foreach ( $categories as $category ) {
							$list[$category->name] = $category->term_id;
						}
					} else {
						$list[ esc_html__('categories not is array','nrg_premium') ] = '';
					}
				} else {
					$list[ esc_html__('not found categories','nrg_premium') ] = '';
				}
			break;
		}
		// return array
		return $list;
	}
}
/**
 * Global function with all theme options
 */
if ( ! function_exists( 'nrgOption' ) ) {
	function nrgOption($option)  {
		if( is_plugin_active('nrgpremium-plugins/nrgpremium-plugins.php') ){ 
			return cs_get_option($option);
		} else {
			return '';
		}
	}
}
/**
 * Replaces the excerpt "more" text by a link
 */
if ( ! function_exists( 'nrg_premium_excerpt_more' ) ) {
	function nrg_premium_excerpt_more()
	{
	    global $post;
		return '... <a class="moretag" href="'. esc_url(get_permalink($post->ID)) .'">'. esc_html__( 'Read more', 'nrg_premium' ) .'</a>';
	}
	add_filter('excerpt_more', 'nrg_premium_excerpt_more');
}

if ( ! function_exists( 'nrg_premium_blog_type' ) ) {
	function nrg_premium_blog_type($type=''){
		if( $type == 'wide' ){
			$test = array();
			$test['class'] = 'izotope-container gutt-col3';
			$test['container'] = '-fluid';
			$test['grey']	= 'bg-grey';
			return $test;
		} elseif ( $type == 'classic') {
			$test = array();
			$test['class'] = 'col-md-12';
			$test['container'] = '';
			$test['grey']	= '';
			return $test;
		} else {
			$test = array();
			$test['class'] = 'izotope-container gutt-col3';
			$test['container'] = '';
			$test['grey']	= 'bg-grey';
			return $test;
		}
	}
}
/**
 * Comments template
 **/
if ( ! function_exists( 'nrg_premium_comment' ) ) {
	function nrg_premium_comment( $comment, $args, $depth )
	{
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ):
			case 'pingback':
			case 'trackback': ?>
				<div class="pingback">
					<?php esc_html_e( 'Pingback:', 'nrg_premium' ); ?> <?php comment_author_link(); ?>
					<?php edit_comment_link( esc_html__( '(Edit)', 'nrg_premium' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
				<?php
				break;
			default: ?>
				<li <?php comment_class('ct-part'); ?> id="li-comment-<?php comment_ID(); ?>">
					<div class="comm-block" id="comment-<?php comment_ID(); ?>">
						<div class="comm-img">
							<?php echo get_avatar( $comment, 80 ); ?>
						</div>
						<div class="comm-txt">
							<h5><?php comment_author(); ?></h5>
							<div class="date-post">
								<span class="fa fa-calendar"></span>
								<h6><?php comment_date( get_option('date_format') );?></h6>
							</div>
							<?php comment_text(); ?>
							<?php comment_reply_link(
								array_merge( $args,
									array(
										'reply_text' => esc_html__( 'Reply', 'nrg_premium' ),
										'after' 	 => '',
										'depth' 	 => $depth,
										'max_depth'  => $args['max_depth']
									)
								)
							); ?>
						</div>
					</div>
			<?php
			break;
		endswitch;
	}
}
//PAGINATION
function nrg_premium_pagination($pages = '', $range = 2){
	$showitems = ($range * 2)+1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == ''){
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages){
			$pages = 1;
		}
	}
	if(1 != $pages){
		print wp_kses_post( '<nav class="navigation pagination" role="navigation"><div class="nav-links">' );
		if($paged > 1 && 1 < $pages) print wp_kses_post( '<div class="left-arrow-nav"><a href="'.get_pagenum_link($paged - 1).'" class="prev page-numbers"><span>Prev page</span></a></div>' );
		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
				print wp_kses_post( ($paged == $i)? "<span class='page-numbers current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='page-numbers'>".$i."</a>" );
			}
		}
		if ($paged < $pages && 1 < $pages) print wp_kses_post( '<div class="right-arrow-nav"><a href="'.get_pagenum_link($paged + 1).'" class="next page-numbers"><span>Next page</span></a>' );
		print wp_kses_post( '</div></div></nav>' );
	}
}
function nrg_premium_excerpt_length( $length ){
    return 25;
}
add_filter( 'excerpt_length', 'nrg_premium_excerpt_length', 0 );