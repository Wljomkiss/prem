<?php
/**
 * Action Config - Theme setting
 *
 * @package nrg_premium
 * @since 1.0.0
 *
 */
// ------------------------------------------
// Setting include CS-Framework modules
// ------------------------------------------
define( 'CS_ACTIVE_FRAMEWORK', true );
define( 'CS_ACTIVE_METABOX',   true );
define( 'CS_ACTIVE_TAXONOMY',  true );
define( 'CS_ACTIVE_SHORTCODE', false );
define( 'CS_ACTIVE_CUSTOMIZE', false );
//include plugin.php
get_template_part( ABSPATH . 'wp-admin/includes/plugin' );
// ------------------------------------------
// Global actions for theme
// ------------------------------------------
add_action( 'widgets_init',       'nrg_premium_register_sidebar' );
add_action( 'wp_enqueue_scripts', 'nrg_premium_enqueue_scripts');
//add_action( 'wp_head',            'nrg_premium_custom_styles', 8);
add_action( 'tgmpa_register',     'nrg_premium_include_required_plugins' );
// ------------------------------------------
// Function for add actions
// ------------------------------------------
/** Function for register sidebar */
if ( ! function_exists( 'nrg_premium_register_sidebar' ) ) {
	function nrg_premium_register_sidebar(){		
		// register main sidebars
		register_sidebar(
			array(
				'id'            => 'sidebar',
				'name'          => esc_html__( 'Sidebar' , 'nrg_premium' ),
				'before_widget' => '<div class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title-w">',
				'after_title'   => '</h4>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'shop_sidebar',
				'name'          => esc_html__( 'Shop sidebar' , 'nrg_premium' ),
				'before_widget' => '<div class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title-w">',
				'after_title'   => '</h5>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'mag_2_sidebar',
				'name'          => esc_html__( 'Magazine 2 sidebar' , 'nrg_premium' ),
				'before_widget' => '<div class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title-w h7 sm bold">',
				'after_title'   => '</h5>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'footer_sidebar_1',
				'name'          => esc_html__( 'Footer sidebar 1' , 'nrg_premium' ),
				'before_widget' => '<div class="footer-item widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title-w title h7">',
				'after_title'   => '</h5>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'footer_sidebar_2',
				'name'          => esc_html__( 'Footer sidebar 2' , 'nrg_premium' ),
				'before_widget' => '<div class="footer-item widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title-w title h7">',
				'after_title'   => '</h5>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'footer_sidebar_3',
				'name'          => esc_html__( 'Footer sidebar 3' , 'nrg_premium' ),
				'before_widget' => '<div class="footer-item widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title-w title h7">',
				'after_title'   => '</h5>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'footer_sidebar_4',
				'name'          => esc_html__( 'Footer sidebar 4' , 'nrg_premium' ),
				'before_widget' => '<div class="footer-item  widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title-w title h7">',
				'after_title'   => '</h4>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'footer_sidebar_5',
				'name'          => esc_html__( 'Footer sidebar 5' , 'nrg_premium' ),
				'before_widget' => '<div class="footer-item  widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title-w title h7">',
				'after_title'   => '</h4>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'footer_sidebar_6',
				'name'          => esc_html__( 'Footer sidebar 6' , 'nrg_premium' ),
				'before_widget' => '<div class="footer-item  widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title-w title h7">',
				'after_title'   => '</h4>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
		register_sidebar(
			array(
				'id'            => 'footer_sidebar_7',
				'name'          => esc_html__( 'Footer sidebar 7' , 'nrg_premium' ),
				'before_widget' => '<div class="footer-item  widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title-w title h7">',
				'after_title'   => '</h4>',
				'description'   => esc_html__( 'Drag the widgets for sidebars.', 'nrg_premium' )
			)
		);
	}
}
/** Loads all the js and css script to frontend */
if ( ! function_exists( 'nrg_premium_enqueue_scripts' ) ) {
	function nrg_premium_enqueue_scripts(){
		wp_enqueue_script('swiper.jquery.min',			'https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script('jquery.countTo',				NRG_PREMIUM_URI.'/assets/js/jquery.countTo.js', array( 'jquery' ), false, true );
		wp_enqueue_script('jquery.circliful.min',		NRG_PREMIUM_URI.'/assets/js/jquery.circliful.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script('isotope.pkgd.min',			NRG_PREMIUM_URI.'/assets/js/isotope.pkgd.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script('bootstrap.min',				NRG_PREMIUM_URI.'/assets/js/bootstrap.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script('instafeed.min',			    NRG_PREMIUM_URI.'/assets/js/instafeed.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script('jquery.final-countdown.min',	NRG_PREMIUM_URI.'/assets/js/jquery.final-countdown.min.js', array( 'jquery' ), false, true );
		wp_register_script('anchors.nav',				NRG_PREMIUM_URI.'/assets/js/anchors.nav.js', array( 'jquery' ), false, true );
		wp_enqueue_script('kinetic',			    	NRG_PREMIUM_URI.'/assets/js/kinetic.js', array( 'jquery' ), false, true );
		wp_enqueue_script('jquery.throttle',			NRG_PREMIUM_URI.'/assets/js/jquery.throttle.js', array( 'jquery' ), false, true );
		wp_enqueue_script('jquery.knob',				NRG_PREMIUM_URI.'/assets/js/jquery.knob.js', array( 'jquery' ), false, true );
		wp_enqueue_script('jquery.classycountdown',		NRG_PREMIUM_URI.'/assets/js/jquery.classycountdown.js', array( 'jquery' ), false, true );
		wp_enqueue_script('nrg_premium_map',			NRG_PREMIUM_URI.'/assets/js/map.js', array( 'jquery' ), false, true );
		wp_enqueue_script('nrg_premium_all',			NRG_PREMIUM_URI.'/assets/js/all.js', array( 'jquery' ), false, true );
		wp_enqueue_script('nrg_premium_custom',			NRG_PREMIUM_URI.'/assets/js/custom.js', array( 'jquery' ), false, true );
		if ( nrgOption('google_maps_key') != '' ){ wp_register_script( 'maps', 'https://maps.googleapis.com/maps/api/js?key='.nrgOption('google_maps_key').'&callback=initMap', array( 'jquery' ), null, true ); }
  		else { wp_register_script( 'maps', 'http://maps.googleapis.com/maps/api/js?sensor=false&amp;language=en', array( 'jquery' ), null, true ); }
		$custom_js = ( nrg_premium_custom_js() ? nrg_premium_custom_js() : '' );
		wp_add_inline_script('nrg_premium_all', $custom_js );
		// add TinyMCE style
		add_editor_style();
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
		// Fonts
		wp_enqueue_style( 'fonts', nrg_premium_g_fonts(), array(), null );

		wp_enqueue_style( 'bootstrap.min.css', 		NRG_PREMIUM_URI.'/assets/css/bootstrap.min.css' );
		wp_enqueue_style( 'font-awesome-min', 		NRG_PREMIUM_URI.'/assets/css/font-awesome.min.css' );
		wp_enqueue_style( 'swiper.min', 			'https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css' );
		wp_enqueue_style( 'nrg_premium-assets-css', NRG_PREMIUM_URI.'/assets/css/style.css' );
		wp_enqueue_style( 'nrg_premium-mstyle-css', NRG_PREMIUM_URI.'/assets/css/mstyle.css' );
		wp_enqueue_style( 'nrg_premium-core-css',   NRG_PREMIUM_URI.'/style.css' );
		$custom_css = ( nrg_premium_custom_styles() ? nrg_premium_custom_styles() : '' );
		wp_add_inline_style('nrg_premium-core-css', $custom_css );
	}
}

if( !function_exists( 'nrg_premium_g_fonts' ) ){
	function nrg_premium_g_fonts(){
		$font_url = '';
		if( 'off' !== _x( 'on', 'Google font: on or off', 'nrg_premium' ) ){
			$font_url = add_query_arg( 'family', urlencode( 'Roboto Slab:400,300,700,100|Raleway:100,300,400,500,600,700,800,900|Droid Serif:400,400i,700,700i|Great Vibes|Roboto:100,300,300i,400,400i,500,500i,700,900,900i|Lora:400,400i,700,700i|Ubuntu:300,400,500,700' ), "//fonts.googleapis.com/css" );
		}
		return $font_url;
	}
}

//--remove version css, js--//
function nrg_premium_remove_script_version( $src ) {
	if( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'script_loader_src', 'nrg_premium_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'nrg_premium_remove_script_version', 15, 1 );

/** Include required plugins */
if ( ! function_exists( 'nrg_premium_include_required_plugins' ) ) {
	function nrg_premium_include_required_plugins(){
		$plugins = array(
			array(
				'name'                  => esc_html__( 'Contact Form 7', 'nrg_premium' ), // The plugin name
				'slug'                  => 'contact-form-7', // The plugin slug (typically the folder name)
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'WooCommerce', 'nrg_premium' ), // The plugin name
				'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'Wishlist', 'nrg_premium' ), // The plugin name
				'slug'                  => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'Mailshimp', 'nrg_premium' ), // The plugin name
				'slug'                  => 'yikes-inc-easy-mailchimp-extender', // The plugin slug (typically the folder name)
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'Visual Composer', 'nrg_premium' ), // The plugin name
				'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
				'source'                => NRG_PREMIUM_F_PATH .'/plugins/js_composer.zip', // The plugin source
				'required'              => true, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'nrg_premium Plugins', 'nrg_premium' ), // The plugin name
				'slug'                  => 'nrgpremium-plugins', // The plugin slug (typically the folder name)
				'source'                => NRG_PREMIUM_F_PATH .'/plugins/nrgpremium-plugins.zip', // The plugin source
				'required'              => true, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => esc_html__( 'nrg_premium Options', 'nrg_premium' ), // The plugin name
				'slug'                  => 'cs-framework', // The plugin slug (typically the folder name)
				'source'                => NRG_PREMIUM_F_PATH .'/plugins/cs-framework.zip', // The plugin source
				'required'              => true, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
		);
		// Change this to your theme text domain, used for internationalising strings
		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'id'           => 'nrg_premium',                // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);
		tgmpa( $plugins, $config );
	}
}
if ( ! function_exists( 'nrg_premium_oembed_filter' ) ) {
	function nrg_premium_oembed_filter($html, $url, $attr, $post_ID) {

		if ( !is_single() || get_post_type() != 'portfolio')  return $html;
		
		$post_options = get_post_meta( $post_ID, '_portfolio_options_info', true );
	    ob_start(); 
	    ?>
	    <div class="video-details s-back-switch">
	        <?php 
	        echo $html; 
	        if( !empty($post_options['preview_video']) ) : 
	        	$url = wp_get_attachment_image_url( $post_options['preview_video'], 'full'); ?>
	        	<img src="<?php echo esc_url( $url ); ?>" alt="preview_video" class="s-img-switch">
	        <?php endif; ?>
	        <div class="btnVideo" data-params="&amp;autoplay=1&amp;rel=0"></div>
	        <div class="videoClose"><?php esc_html_e('x', 'nrg_premium'); ?></div>
	    </div>
	    <?php
	    return ob_get_clean();
	}
}
add_filter( 'embed_oembed_html', 'nrg_premium_oembed_filter', 99, 4 ) ;

//remove_action
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//add_action
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 10 );
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 15 );
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 25 );



//INSTAGRAM WIDGET
class nrg_premium_widget_instagram extends WP_Widget {

// Create Widget
	function __construct() {
        parent::__construct(false, $name = 'NRGPremium Instagram', array('description' => 'Widget with Instagram images.'));
    }
// Widget Content
    function widget($args, $instance) {
        extract( $args );
        $instagram_userid 		= strip_tags($instance['instagram_userid']);
        $instagram_access_token = strip_tags($instance['instagram_access_token']);
        $inst_id 				= uniqid();
        $img_limit 				= strip_tags($instance['img_limit']);
        $user_name 				= strip_tags($instance['user_name']);
        $profile_link 			= strip_tags($instance['profile_link']);
        $type 					= strip_tags($instance['type']);
        if ($instagram_userid && $img_limit && $instagram_access_token) {
	        if ($type == 'type_1') { ?>
				<div class="footer-item widget widget_instagram" <?php echo $type; ?>>
					<h5 class="widget-title-w title h7"><?php echo $user_name; ?></h5>
					<div class="some-wrap" id="<?php echo $inst_id;?>"></div>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
					//Instagram
						try{Typekit.load();}catch(e){}
							var feed = new Instafeed({
								get: 'user',
								userId: '<?php echo $instagram_userid; ?>',
								'limit': '<?php echo $img_limit; ?>',
								accessToken: '<?php echo $instagram_access_token; ?>',
								template: '<a href="{{link}}" target="_blank"><img class="imgShortcode" src="{{image}}" alt=""></a>',
								target: '<?php echo $inst_id;?>',
								resolution: 'standard_resolution',
								after: function() {
								}
							});
						feed.run();
					});
				</script>
			<?php
			 } else { 
			 	?>
				<div class="widget widget_instagram " <?php echo $type; ?>>
					<h5 class="widget-title-w h7 sm bold"><?php echo $user_name; ?></h5>
					<div class="instagram-photo wh-33" id="<?php echo $inst_id;?>"></div>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
					//Instagram
						try{Typekit.load();}catch(e){}
							var feed = new Instafeed({
								get: 'user',
								userId: '<?php echo $instagram_userid; ?>',
								'limit': '<?php echo $img_limit; ?>',
								accessToken: '<?php echo $instagram_access_token; ?>',
								template: '<a href="{{link}}" target="_blank"><img src="{{image}}" alt=""></a>',
								target: '<?php echo $inst_id;?>',
								resolution: 'standard_resolution',
								after: function() {
								}
							});
						feed.run();
					});
				</script>
			<?php
			}
		}
    }

    // Update and save the widget
    function update($new_instance, $old_instance){
    	$instance = array();
		$instance['instagram_userid'] 		= sanitize_text_field( $new_instance['instagram_userid'] );
		$instance['instagram_access_token'] = sanitize_text_field($new_instance['instagram_access_token']);
		$instance['img_limit'] 				= sanitize_text_field( $new_instance['img_limit'] );
		$instance['user_name'] 				= sanitize_text_field($new_instance['user_name']);
		$instance['profile_link'] 			= sanitize_text_field($new_instance['profile_link']);
		$instance['type'] 					= sanitize_text_field($new_instance['type']);
        return $instance;
    }

    // If widget content needs a form
    function form($instance) {
        //widgetform in backend
        $instagram_userid		= (isset($instance['instagram_userid'])) ? strip_tags($instance['instagram_userid']) : '';
        $instagram_access_token = (isset($instance['instagram_access_token'])) ? strip_tags($instance['instagram_access_token']) : '';
        $img_limit 				= (isset($instance['img_limit'])) ? strip_tags($instance['img_limit']) : '';
        $user_name 				= (isset($instance['user_name'])) ? strip_tags($instance['user_name']) : '';
        $profile_link 			= (isset($instance['profile_link'])) ? strip_tags($instance['profile_link']) : '';
        $type 					= (isset($instance['type'])) ? strip_tags($instance['type']) : 'type_1'; ?>
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php esc_html_e('Type Style', 'nrg_premium'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option value="type_1" <?php echo ( $type == 'type_1' ? 'selected' : '' ); ?>>Type 1</option>
				<option value="type_2" <?php echo ( $type == 'type_2' ? 'selected' : '' ); ?>>Type 2</option>
			</select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('user_name'); ?>"><?php  esc_html_e('Instagram user name: ', 'nrg_premium'); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id('user_name'); ?>" name="<?php echo $this->get_field_name('user_name'); ?>" type="text" value="<?php echo esc_attr($user_name); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('profile_link'); ?>"><?php  esc_html_e('Link to Instagram user profile: ', 'nrg_premium'); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id('profile_link'); ?>" name="<?php echo $this->get_field_name('profile_link'); ?>" type="text" value="<?php echo esc_attr($profile_link); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('instagram_userid'); ?>"><?php  esc_html_e('Instagram user ID: ', 'nrg_premium'); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram_userid'); ?>" name="<?php echo $this->get_field_name('instagram_userid'); ?>" type="text" value="<?php echo esc_attr($instagram_userid); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('instagram_access_token'); ?>"><?php  esc_html_e('Instagram access token: ', 'nrg_premium'); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram_access_token'); ?>" name="<?php echo $this->get_field_name('instagram_access_token'); ?>" type="text" value="<?php echo esc_attr($instagram_access_token); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('img_limit'); ?>"><?php  esc_html_e('Instagram image limit: ', 'nrg_premium'); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id('img_limit'); ?>" name="<?php echo $this->get_field_name('img_limit'); ?>" type="text" value="<?php echo esc_attr($img_limit); ?>" />
        </p>

        <?php
    }
}
register_widget('nrg_premium_widget_instagram');

//Contact info WIDGET
class nrg_premium_widget_contact extends WP_Widget{
    function __construct() {
        parent::__construct(false, $name = 'NRGPremium Contact info', array('description' => 'You can enter your contact information in theme options'));
    }
    function widget($args, $instance) {
        extract($args);
        extract($instance);
        $address_info = nrgOption('address_info');
		$email_info = nrgOption('email_info');
		$phone_info = nrgOption('phone_info');
		$output_phone = preg_replace( '/[^0-9]/', "", $phone_info );

       	$title = esc_attr($title);

        if ( $address_info || $email_info || $phone_info) { ?>

	        <div class="footer-item widget widget_instagram">
	        	<?php if ($title) { ?>
		        	<h5 class="widget-title-w title h7"><?php print esc_html($title); ?></h5>
		        <?php } ?>
				<ul>
					<?php if ( $address_info ) { ?>
						<li class="address-item type-2">
							<h6 class="h7 title"><?php esc_html_e('Address:', 'nrg_premium');?></h6>
							<p><?php print wp_kses_post($address_info); ?></p> 
							<div class="empty-sm-20 empty-xs-20"></div>    
						</li>
					<?php }
					if ( $email_info ) { ?>
						<li class="address-item type-2">
							<h6 class="h7 title"><?php esc_html_e('Email:', 'nrg_premium');?></h6>
							<div class="link">
								<a href="mailto:<?php print esc_html($email_info); ?>"><?php print esc_html($email_info); ?></a>
							</div>
							<div class="empty-sm-20 empty-xs-20"></div> 
						</li>
					<?php }
					if ( $phone_info ) { ?>
						<li class="address-item type-2">
							<h6 class="h7 title"><?php esc_html_e('Contact us:', 'nrg_premium');?></h6>
							<div class="link">
								<a href="tel:+<?php print esc_html($output_phone); ?>"><?php print esc_html($phone_info); ?></a>
							</div>
							<div class="empty-sm-20 empty-xs-0"></div>  
						</li>
					<?php } ?>
				</ul>
			</div>
		
		<?php }	
    }
    function form($instance){
        extract($instance);
        $title = (isset($title)) ? $title : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'nrg_premium'); ?></label>
            <input type="text" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
}
register_widget('nrg_premium_widget_contact');


//WIGET 
class nrg_premium_widget_lat_posts extends WP_Widget{
    function __construct() {
        parent::__construct(false, $name = 'NRGPremium Latest posts', array('description' => 'all latest posts'));
    }
    function widget($args, $instance) {
        extract($args);
        extract($instance);

       	$limit = esc_attr($limit);

       	$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $limit,
			'order'			 => 'DESC',
			'orderby'		 => 'date',
		);
       	$query = new WP_Query( $args );
        ?>


        	<?php
			// TYPE 1
			while ( $query->have_posts() ) {
			$query->the_post(); ?>
				<div class="mag-item-1 type-img min-sm-height">
					<div class="bg layer-hold type-4" style="background-image: url(<?php the_post_thumbnail_url();?>)"></div> 
					<div class="text">
						<div class="sub-title sm col-1"><i><?php the_time(get_option('date_format')); ?></i></div>
						<div class="empty-sm-10 empty-xs-10"></div>
						<div class="caption type-2">
							<h3 class="h5 sm title">
								<a href="<?php the_permalink();?>" class="text-line-animate sm"><?php the_title();?></a>
							</h3>
						</div>
						<?php
						$term_list = get_the_terms(get_the_ID(), 'category' );
						if( $term_list ){
							echo '<div class="mag-item-cat-wr bottom type-2">';
								foreach( $term_list as $value ){
									$bg_color = '';
									$term_data = get_term_meta( $value->term_id, '_custom_category_options', true );
									if(isset($term_data['post_cat_color'])){
										$bg_color = 'style="background-color:'.$term_data['post_cat_color'].';"';
									}
									echo '<div class="mag-item-cat type-2"><a href="'.get_term_link($value->term_id).'">'.$value->name.'</a></div>';
								}
							echo '</div>';
						}
					?>
					</div>
				</div>
				<div class="empty-sm-30 empty-xs-30"></div>
			<?php }
			wp_reset_postdata();
			?>
		<?php
    }
    function form($instance){
        extract($instance);
        $limit = (isset($instance['limit'])) ? strip_tags($instance['limit']) : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php  esc_html_e('Posts limit: ', 'nrg_premium'); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
        </p>
        <?php
    }
}
register_widget('nrg_premium_widget_lat_posts');

//--One Page Header Menu--//
class nrg_premium_Walker_Nav_Menu extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){
		global $wp_query;
		$tr_page_post = get_option( 'page_for_posts');
		$post = get_post($item->object_id);
		$post_type = get_post_type($post->ID); 

		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

		if ( ($post->ID == $tr_page_post) || $post_type != 'page' ) {
			$attributes .= ! empty( $item->url )        ? ' href="'.esc_attr( $item->url ) .'"' : '';
		} else {
			$attributes .= ! empty( $item->url )        ? ' href="#onepage-'.$post->post_name.'"' : '';  
		}
		$attributes.= ' class="anchor-link"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}