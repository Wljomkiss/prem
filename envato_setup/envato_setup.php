<?php
/**
 *
 * @author     nrgthemes
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!defined('ENVATO_THEME_VERSION')){
	define('ENVATO_THEME_VERSION',1.0);
}

/**
 * Envato_NRGThemes_Setup class
 */
class Envato_NRGThemes_Setup {

	/** @var string Theme author username, used in check for oauth. */
	private $envato_username = 'nrgthemes';

	/** @var string Full url to server-script.php  */
	private $oauth_script = 'http://demo.nrgthemes.com/envato/api/server-script.php';


	/** @var string Currenct Step */
	private $step   = '';


	/** @var array Steps for the setup wizard */
	private $steps  = array();


	/** @var string url for this plugin folder, used when enquing scripts */
	private $public_base_url = ''; // set in construct

	/** @var string Current theme name, used as namespace in actions. */
	private $theme_name = ''; // set in construct

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		$current_theme = wp_get_theme();
		$this->theme_name = strtolower(preg_replace('#[^a-zA-Z]#','',$current_theme->get('Name')));
		if ( apply_filters( $this->theme_name . '_enable_setup_wizard', true ) && current_user_can( 'manage_options' )  ) {
			$this->public_base_url = get_template_directory_uri().'/envato_setup';
			add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );
			add_action( 'admin_menu', array( $this, 'admin_menus' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_init', array( $this, 'admin_redirects' ), 30 );
			add_action( 'admin_init', array( $this, 'setup_wizard' ), 30 );
			add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1);
			add_action( 'wp_ajax_envato_setup_plugins', array($this, 'ajax_plugins') );
			add_action( 'wp_ajax_envato_setup_content', array($this, 'ajax_content') );
		}
		if ( function_exists( 'envato_market' ) ) {
			add_action( 'admin_init', array( $this, 'envato_market_admin_init' ), 20 );
			add_filter( 'http_request_args', array( $this, 'envato_market_http_request_args' ), 10, 2 );
		}
	}

	public function enqueue_scripts(){
	}
	public function tgmpa_load($status){
		return is_admin() || current_user_can( 'install_themes' );
	}

	public function switch_theme(){
		set_transient( '_'.$this->theme_name.'_activation_redirect', 1 );
	}
	public function admin_redirects() {
		ob_start();
		if ( !get_transient( '_'.$this->theme_name.'_activation_redirect' ) ) {
			return;
		}
		delete_transient( '_'.$this->theme_name.'_activation_redirect' );
		wp_safe_redirect( admin_url( 'themes.php?page='.$this->theme_name.'-setup' ) );
		exit;
	}
		/**
	 * Add admin menus/screens.
	 */
	public function admin_menus() {
		add_theme_page(esc_html__('Setup Theme and Import Demo','nrg_premium'), esc_html__('Setup and Import Demo','nrg_premium'), 'manage_options', $this->theme_name.'-setup', array($this,'setup_wizard') );
	}

	/**
	 * Show the setup wizard
	 */
	public function setup_wizard() {
		if ( empty( $_GET['page'] ) || $this->theme_name.'-setup' !== $_GET['page'] ) {
			return;
		}
		ob_end_clean();
		$this->steps = array(
			'introduction' => array(
				'name'    =>  esc_html__( 'Introduction', 'nrg_premium' ),
				'view'    => array( $this, 'envato_setup_introduction' ),
				'handler' => ''
			),
		);
		if(class_exists( 'TGM_Plugin_Activation' ) && isset($GLOBALS['tgmpa'])) {
			$this->steps['default_plugins'] = array(
				'name' => esc_html__( 'Plugins', 'nrg_premium' ),
				'view' => array( $this, 'envato_setup_default_plugins' ),
				'handler' => ''
			);
		}
		$this->steps['default_content'] = array(
			'name'    =>  esc_html__( 'Content', 'nrg_premium' ),
			'view'    => array( $this, 'envato_setup_default_content' ),
			'handler' => ''
		);
		$this->steps['customize'] = array(
			'name'    =>  esc_html__( 'Customize', 'nrg_premium' ),
			'view'    => array( $this, 'envato_setup_customize' ),
			'handler' => '',
		);
		$this->steps['help_support'] = array(
			'name'    =>  esc_html__( 'Support', 'nrg_premium' ),
			'view'    => array( $this, 'envato_setup_help_support' ),
			'handler' => '',
		);
		$this->steps['next_steps'] = array(
			'name'    =>  esc_html__( 'Ready!', 'nrg_premium' ),
			'view'    => array( $this, 'envato_setup_ready' ),
			'handler' => ''
		);
		$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

		wp_register_script( 'jquery-blockui', $this->public_base_url . '/js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
		wp_register_script( 'envato-setup', $this->public_base_url . '/js/envato-setup.js', array( 'jquery', 'jquery-blockui' ), ENVATO_THEME_VERSION );
		wp_localize_script( 'envato-setup', 'envato_setup_params', array(
			'tgm_plugin_nonce'            => array(
				'update' => wp_create_nonce( 'tgmpa-update' ),
				'install' => wp_create_nonce( 'tgmpa-install' ),
			),
			'tgm_bulk_url' => admin_url('themes.php?page=tgmpa-install-plugins'),
			'ajaxurl' => admin_url('admin-ajax.php'),
			'wpnonce' => wp_create_nonce('envato_setup_nonce'),
			'verify_text' => esc_html__('...verifying','nrg_premium'),
		) );

		wp_enqueue_style( 'envato-setup', $this->public_base_url . '/css/envato-setup.css', array( 'dashicons', 'install' ), ENVATO_THEME_VERSION );

		wp_enqueue_media();
		wp_enqueue_script( 'media' );

		ob_start();
		$this->setup_wizard_header();
		$this->setup_wizard_steps();
		$show_content = true;
		echo '<div class="envato-setup-content">';
		if ( ! empty( $_REQUEST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
			$show_content = call_user_func( $this->steps[ $this->step ]['handler'] );
		}
		if($show_content){
			$this->setup_wizard_content();
		}
		echo '</div>';
		$this->setup_wizard_footer();
		exit;
	}

	public function get_step_link($step) {
		return  add_query_arg( 'step', $step, admin_url('admin.php?page=' .$this->theme_name.'-setup') );
	}
	public function get_next_step_link() {
		$keys = array_keys( $this->steps );
		return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
	}

	/**
	 * Setup Wizard Header
	 */
	public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php wp_title(); ?></title>
			<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.ico' ); ?>" type="image/x-icon">
			<?php wp_print_scripts( 'envato-setup' ); ?>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_print_scripts' ); ?>
			<?php do_action( 'admin_head' ); ?>
		</head>
		<body class="envato-setup wp-core-ui">
		<h1 id="wc-logo">
			<a href="http://themeforest.net/user/nrgthemes/portfolio" target="_blank">
				<img src="<?php echo esc_attr($this->public_base_url); ?>/images/logo.jpg" alt="<?php esc_html_e( 'Envato install theme','nrg_premium'); ?>" />
			</a>
		</h1>
		<?php
		}

	/**
	 * Setup Wizard Footer
	 */
	public function setup_wizard_footer() {
		?>
			<?php if ( 'next_steps' === $this->step ) : ?>
			<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'nrg_premium' ); ?></a>
			<?php endif; ?>
		</body>
		<?php
			@do_action( 'admin_footer' ); // this was spitting out some errors in some admin templates. quick @ fix until I have time to find out what's causing errors.
			do_action( 'admin_print_footer_scripts' );
		?>
		</html>
	<?php
}

	/**
	 * Output the steps
	 */
	public function setup_wizard_steps() {
		$ouput_steps = $this->steps;
		array_shift( $ouput_steps );
		?>
		<ol class="envato-setup-steps">
			<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
				<li class="<?php
				$show_link = false;
				if ( $step_key === $this->step ) {
					echo 'active';
				} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
					echo 'done';
					$show_link = true;
				}
				?>"><?php
					if($show_link){
						?>
						<a href="<?php echo esc_url($this->get_step_link($step_key));?>"><?php echo esc_html( $step['name'] );?></a>
						<?php
					}else{
						echo esc_html( $step['name'] );
					}
					?></li>
			<?php endforeach; ?>
		</ol>
		<?php
	}

	/**
	 * Output the content for the current step
	 */
	public function setup_wizard_content() {
		isset($this->steps[ $this->step ]) ? call_user_func( $this->steps[ $this->step ]['view'] ) : false;
	}

	/**
	 * Introduction step
	 */
	public function envato_setup_introduction() {
		if(isset($_REQUEST['export'])){

			// find the ID of our menu names so we can import them into default menu locations and also the widget positions below.
			$menus = get_terms('nav_menu');
			$menu_ids = array();
			foreach($menus as $menu){
				if($menu->name == 'Main Menu'){
					$menu_ids['primary'] = $menu->term_id;
				}else if($menu->name == 'Quick Links'){
					$menu_ids['footer_quick'] = $menu->term_id;
				}
			}
			// used for me to export my widget settings.
			$widget_positions = get_option('sidebars_widgets');
			$widget_options = array();
			$my_options = array();
			foreach($widget_positions as $sidebar_name => $widgets){
				if(is_array($widgets)){
					foreach($widgets as $widget_name){
						$widget_name_strip = preg_replace('#-\d+$#','',$widget_name);
						$widget_options[$widget_name_strip] = get_option('widget_'.$widget_name_strip);
					}
				}
			}
			// choose which custom options to load into defaults
			$all_options = wp_load_alloptions();
			foreach( $all_options as $name => $value ) {
				if(stristr($name, '_widget_area_manager')) $my_options[$name] = $value;
			}
			$my_options['travel_settings'] = array('api_key'=>'AIzaSyBsnYWO4SSibatp0SjsU9D2aZ6urI-_cJ8');
			$my_options['tt-font-google-api-key'] = 'AIzaSyBsnYWO4SSibatp0SjsU9D2aZ6urI-_cJ8';
			?>
			<h1><?php esc_html_e( 'Current Settings:','nrg_premium'); ?></h1>
			<p><?php esc_html_e( 'Widget Positions:','nrg_premium'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($widget_positions);?></textarea>
			<p><?php esc_html_e( 'Widget Options:','nrg_premium'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($widget_options);?></textarea>
			<p><?php esc_html_e( 'Menu IDs:','nrg_premium'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($menu_ids);?></textarea>
			<p><?php esc_html_e( 'Custom Options:','nrg_premium'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($my_options);?></textarea>
			<p><?php esc_html_e( 'Copy these values into your PHP code when distributing/updating the theme.','nrg_premium'); ?></p>
			<?php
		}else {
			?>
			<h1><?php esc_html_e( 'Welcome to the setup themes!', 'nrg_premium' ); ?></h1>
			<p><?php esc_html_e( 'This quick setup wizard will help you configure your new website. This wizard will install the required WordPress plugins, default content, logo and tell you a little about Help &amp; Support options. It should only take 5 minutes.', 'nrg_premium' ); ?></p>
			<p><?php esc_html_e( "No time right now? If you don't want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime if you change your mind!", "nrg_premium" ); ?></p>
			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
				   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'nrg_premium' ); ?></a>
				<a href="<?php echo esc_url( wp_get_referer() ? wp_get_referer() : admin_url( '' ) ); ?>"
				   class="button button-large"><?php esc_html_e( 'Not right now', 'nrg_premium' ); ?></a>
			</p>
			<?php
		}
	}


	private function _get_plugins(){
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$plugins = array(
			'all'      => array(), // Meaning: all plugins which still have open actions.
			'install'  => array(),
			'update'   => array(),
			'activate' => array(),
		);

		foreach ( $instance->plugins as $slug => $plugin ) {
			if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
				// No need to display plugins if they are installed, up-to-date and active.
				continue;
			} else {
				$plugins['all'][ $slug ] = $plugin;

				if ( ! $instance->is_plugin_installed( $slug ) ) {
					$plugins['install'][ $slug ] = $plugin;
				} else {
					if ( false !== $instance->does_plugin_have_update( $slug ) ) {
						$plugins['update'][ $slug ] = $plugin;
					}

					if ( $instance->can_plugin_activate( $slug ) ) {
						$plugins['activate'][ $slug ] = $plugin;
					}
				}
			}
		}
		return $plugins;
	}

	/**
	 * Page setup
	 */
	public function envato_setup_default_plugins() {

		tgmpa_load_bulk_installer();
		// install plugins with TGM.
		if(!class_exists( 'TGM_Plugin_Activation' ) || !isset($GLOBALS['tgmpa'])){
			die('Failed to find TGM');
		}
		$url = wp_nonce_url( add_query_arg( array('plugins'=>'go')), 'envato-setup' );
		$plugins = $this->_get_plugins();

		// copied from TGM

		$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
		$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

		if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
			return true; // Stop the normal page form from displaying, credential request form will be shown.
		}

		// Now we have some credentials, setup WP_Filesystem.
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again.
			request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

			return true;
		}

		/* If we arrive here, we have the filesystem */

		?>
		<h1><?php esc_html_e( 'Default Plugins', 'nrg_premium' ); ?></h1>
		<form method="post">

			<?php
			$plugins = $this->_get_plugins();
			if(count($plugins['all'])){
			?>
				<p><?php esc_html_e( 'Your website needs a few essential plugins. The following plugins will be installed:', 'nrg_premium' ); ?></p>
				<ul class="envato-wizard-plugins">
					<?php foreach($plugins['all'] as $slug => $plugin){ ?>
						<li data-slug="<?php echo esc_attr($slug);?>"><?php echo esc_html($plugin['name']);?>
							<span>
								<?php
								$keys = array();
								if(isset($plugins['install'][$slug]))$keys[] = 'Installation';
								if(isset($plugins['update'][$slug]))$keys[] = 'Update';
								if(isset($plugins['activate'][$slug]))$keys[] = 'Activation';
								echo implode(' and ',$keys).' required';
								?>
							</span>
							<div class="spinner"></div>
						</li>
					<?php } ?>
				</ul>
				<?php
			}else{
				echo '<p><strong>'.esc_html__('Good news! All plugins are already installed and up to date. Please continue.','nrg_premium').'</strong></p>';
			} ?>

			<p><?php esc_html_e( 'You can add and remove plugins later on from within WordPress.', 'nrg_premium'); ?></p>

			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_plugins"><?php esc_html_e( 'Continue', 'nrg_premium' ); ?></a>
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'nrg_premium' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
			</p>
		</form>
		<?php
	}


	public function ajax_plugins(){
		if(!check_ajax_referer( 'envato_setup_nonce', 'wpnonce') || empty($_POST['slug'])){
			wp_send_json_error(array('error'=>1,'message'=>esc_html__('No Slug Found','nrg_premium')));
		}
		$json = array();
		// send back some json we use to hit up TGM
		$plugins = $this->_get_plugins();
		// what are we doing with this plugin?
		foreach($plugins['activate'] as $slug => $plugin){
			if($_POST['slug'] == $slug){
				$json = array(
					'url' => admin_url('themes.php?page=tgmpa-install-plugins'),
					'plugin' => array($slug),
					'tgmpa-page' => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
					'action' => 'tgmpa-bulk-activate',
					'action2' => -1,
					'message' => esc_html__('Activating Plugin','nrg_premium'),
				);
				break;
			}
		}
		foreach($plugins['update'] as $slug => $plugin){
			if($_POST['slug'] == $slug){
				$json = array(
					'url' => admin_url('themes.php?page=tgmpa-install-plugins'),
					'plugin' => array($slug),
					'tgmpa-page' => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
					'action' => 'tgmpa-bulk-update',
					'action2' => -1,
					'message' => esc_html__('Updating Plugin','nrg_premium'),
				);
				break;
			}
		}
		foreach($plugins['install'] as $slug => $plugin){
			if($_POST['slug'] == $slug){
				$json = array(
					'url' => admin_url('themes.php?page=tgmpa-install-plugins'),
					'plugin' => array($slug),
					'tgmpa-page' => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
					'action' => 'tgmpa-bulk-install',
					'action2' => -1,
					'message' => esc_html__('Installing Plugin','nrg_premium'),
				);
				break;
			}
		}

		if($json){
			$json['hash'] = md5(serialize($json)); // used for checking if duplicates happen, move to next plugin
			wp_send_json($json);
		}else{
			wp_send_json(array('done'=>1,'message'=>esc_html__('Success','nrg_premium')));
		}
		exit;

	}


	private function _content_default_get(){

		$content = array();

		$content['pages'] = array(
			'title' => esc_html__( 'Pages', 'nrg_premium' ),
			'description' => esc_html__( 'This will create default pages as seen in the demo.', 'nrg_premium' ),
			'pending' => esc_html__( 'Pending.', 'nrg_premium' ),
			'installing' => esc_html__( 'Installing Default Pages.', 'nrg_premium' ),
			'success' => esc_html__( 'Success.', 'nrg_premium' ),
			'install_callback' => array($this,'_content_install_pages'),
		);
		$content['widgets'] = array(
			'title' => esc_html__( 'Widgets', 'nrg_premium' ),
			'description' => esc_html__( 'Insert default sidebar widgets as seen in the demo.', 'nrg_premium' ),
			'pending' => esc_html__( 'Pending.', 'nrg_premium' ),
			'installing' => esc_html__( 'Installing Default Widgets.', 'nrg_premium' ),
			'success' => esc_html__( 'Success.', 'nrg_premium' ),
			'install_callback' => array($this,'_content_install_widgets'),
		);
		$content['settings'] = array(
			'title' => esc_html__( 'Settings', 'nrg_premium' ),
			'description' => esc_html__( 'Configure default settings.', 'nrg_premium' ),
			'pending' => esc_html__( 'Pending.', 'nrg_premium' ),
			'installing' => esc_html__( 'Installing Default Settings.', 'nrg_premium' ),
			'success' => esc_html__( 'Success.', 'nrg_premium' ),
			'install_callback' => array($this,'_content_install_settings'),
		);
		$content['customize'] = array(
			'title' => esc_html__( 'Customize options', 'nrg_premium' ),
			'description' => esc_html__( 'Configure default customize settings', 'nrg_premium' ),
			'pending' => esc_html__( 'Pending.', 'nrg_premium' ),
			'installing' => esc_html__( 'Installing Default Customize Settings.', 'nrg_premium' ),
			'success' => esc_html__( 'Success.', 'nrg_premium' ),
			'install_callback' => array($this,'_content_install_customize'),
		);
		$content['theme_options'] = array(
			'title' => esc_html__( 'Theme options', 'nrg_premium' ),
			'description' => esc_html__( 'Configure default theme options', 'nrg_premium' ),
			'pending' => esc_html__( 'Pending.', 'nrg_premium' ),
			'installing' => esc_html__( 'Installing Default Customize Settings.', 'nrg_premium' ),
			'success' => esc_html__( 'Success.', 'nrg_premium' ),
			'install_callback' => array($this,'_content_install_codestar'),
		);
		return $content;

	}

	/**
	 * Page setup
	 */
	public function envato_setup_default_content() {
		?>
		<h1><?php esc_html_e( 'Default Content', 'nrg_premium' ); ?></h1>
		<form method="post">
			<p><?php printf( esc_html__( 'It\'s time to insert some default content for your new WordPress website. Choose what you would like inserted below and click Continue.', 'nrg_premium' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '" target="_blank">', '</a>' ); ?></p>
			<table class="envato-setup-pages" cellspacing="0">
				<thead>
				<tr>
					<td class="check"> </td>
					<th class="item"><?php esc_html_e( 'Item', 'nrg_premium' ); ?></th>
					<th class="description"><?php esc_html_e( 'Description', 'nrg_premium' ); ?></th>
					<th class="status"><?php esc_html_e( 'Status', 'nrg_premium' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($this->_content_default_get() as $slug => $default){ ?>
				<tr class="envato_default_content" data-content="<?php echo esc_attr($slug);?>">
					<td>
						<input type="checkbox" name="default_content[pages]" class="envato_default_content" id="default_content_<?php echo esc_attr($slug);?>" value="1" checked>
					</td>
					<td><label for="default_content_<?php echo esc_attr($slug);?>"><?php echo esc_html( $default['title'] ); ?></label></td>
					<td class="description"><?php echo wp_kses_post( $default['description'] ); ?></td>
					<td class="status"> <span><?php echo wp_kses_post( $default['pending'] );?></span> <div class="spinner"></div></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>

			<p><?php esc_html_e( 'Once inserted, this content can be managed from the WordPress admin dashboard.', 'nrg_premium'); ?></p>

			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_content"><?php esc_html_e( 'Continue', 'nrg_premium' ); ?></a>
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'nrg_premium' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
			</p>
		</form>
		<?php
	}


	public function ajax_content(){
		$content = $this->_content_default_get();
		if(!check_ajax_referer( 'envato_setup_nonce', 'wpnonce') || empty($_POST['content']) && isset($content[$_POST['content']])){
			wp_send_json_error(array('error'=>1,'message'=>esc_html__('No content Found','nrg_premium')));
		}

		$json = false;
		$this_content = $content[$_POST['content']];

		if(isset($_POST['proceed'])){
			// install the content!

			if(!empty($this_content['install_callback'])){
				if($result = call_user_func($this_content['install_callback'])){
					$json = array(
						'done' => 1,
						'message' => $this_content['success'],
						'debug' => $result,
					);
				}
			}

		}else {

			$json = array(
				'url' => admin_url( 'admin-ajax.php' ),
				'action' => 'envato_setup_content',
				'proceed' => 'true',
				'content' => $_POST['content'],
				'_wpnonce' => wp_create_nonce( 'envato_setup_nonce' ),
				'message' => $this_content['installing'],
			);
		}

		if($json){
			$json['hash'] = md5(serialize($json)); // used for checking if duplicates happen, move to next plugin
			wp_send_json($json);
		}else{
			wp_send_json(array('error'=>1,'message'=>esc_html__('Error','nrg_premium')));
		}

		exit;

	}

	private function _import_wordpress_xml_file($xml_file_path){
		global $wpdb;

		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) )
			{
				require $class_wp_importer;
			}
		}

		if ( ! class_exists( 'WP_Import' )) {
			$class_wp_importer = __DIR__ ."/importer/wordpress-importer.php";
			if ( file_exists( $class_wp_importer ) )
				require_once get_template_directory() . '/envato_setup/importer/wordpress-importer.php';
		}

		if ( class_exists( 'WP_Import' ) )
		{
			require_once get_template_directory() . '/envato_setup/importer/envato-content-import.php';
			$wp_import = new envato_content_import();
			$wp_import->fetch_attachments = true;
			ob_start();
			$wp_import->import($xml_file_path);
			$message = ob_get_clean();
			return array($wp_import->check(),$message);
		}
		return false;
	}

	private function _content_install_pages(){
		return $this->_import_wordpress_xml_file(__DIR__ ."/content/all.xml");
	}
	private function _content_install_products(){
		if($this->_import_wordpress_xml_file(__DIR__ ."/content/products.xml")){
			return $this->_import_wordpress_xml_file(__DIR__ ."/content/variations.xml");
		}
		return false;
	}
	private function _content_install_settings(){

		$custom_options = $this->_get_json('options.json');

		// we also want to update the widget area manager options.
		foreach($custom_options as $option => $value){
			update_option($option, $value);
		}
		return true;
	}

	private function _content_install_widgets(){
	    global $wp_registered_sidebars, $wp_registered_widget_controls;
	    $widget_controls = $wp_registered_widget_controls;

		// remove locations widgets
	    update_option( 'sidebars_widgets', '' );
	    $available_widgets = array();
	    foreach ( $widget_controls as $widget ) {
	        if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { 
	            $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
	            $available_widgets[$widget['id_base']]['name'] = $widget['name'];
	        }
	    }

	    $data = $this->_get_json('widget_options.json');

	    // Get all existing widget instances
	    $widget_instances = array();
	    foreach ( $available_widgets as $widget_data ) {
	        $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	    }
	    // Begin results
	    $results = array();

	    // Loop import data's sidebars
	    foreach ( $data as $sidebar_id => $widgets ) {

	        // Skip inactive widgets
	        // (should not be in export file)
	        if ( 'wp_inactive_widgets' == $sidebar_id ) {
	            continue;
	        }

	        // Check if sidebar is available on this site
	        // Otherwise add widgets to inactive, and say so
	        if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
	            $sidebar_available = true;
	            $use_sidebar_id = $sidebar_id;
	            $sidebar_message_type = 'success';
	            $sidebar_message = '';
	        } else {
	            $sidebar_available = false;
	            $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
	            $sidebar_message_type = 'error';
	            $sidebar_message = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'nrg_premium' );
	        }

	        // Result for sidebar
	        $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
	        $results[$sidebar_id]['message_type'] = $sidebar_message_type;
	        $results[$sidebar_id]['message'] = $sidebar_message;
	        $results[$sidebar_id]['widgets'] = array();

	        // Loop widgets
	        foreach ( $widgets as $widget_instance_id => $widget ) {

	            $fail = false;

	            // Get id_base (remove -# from end) and instance ID number
	            $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
	            $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

	            // Does site support this widget?
	            if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
	                $fail = true;
	                $widget_message_type = 'error';
	                $widget_message = esc_html__( 'Site does not support widget', 'nrg_premium' ); // explain why widget not imported
	            }

	            // Filter to modify settings before import
	            // Do before identical check because changes may make it identical to end result (such as URL replacements)
	            $widget = apply_filters( 'wie_widget_settings', $widget );

	            // Does widget with identical settings already exist in same sidebar?
	            if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

	                // Get existing widgets in this sidebar
	                $sidebars_widgets = get_option( 'sidebars_widgets' );
	                $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

	                // Loop widgets with ID base
	                $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
	                foreach ( $single_widget_instances as $check_id => $check_widget ) {

	                    // Is widget in same sidebar and has identical settings?
	                    if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

	                        $fail = true;
	                        $widget_message_type = 'warning';
	                        $widget_message = esc_html__( 'Widget already exists', 'nrg_premium' ); // explain why widget not imported
	                        break;
	                    }
	                }
	            }

	            // No failure
	            if ( ! $fail ) {

	                // Add widget instance
	                $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
	                $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
	                $single_widget_instances[] = (array) $widget; // add it

	                    // Get the key it was given
	                    end( $single_widget_instances );
	                    $new_instance_id_number = key( $single_widget_instances );

	                    // If key is 0, make it 1
	                    // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
	                    if ( '0' === strval( $new_instance_id_number ) ) {
	                        $new_instance_id_number = 1;
	                        $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
	                        unset( $single_widget_instances[0] );
	                    }

	                    // Move _multiwidget to end of array for uniformity
	                    if ( isset( $single_widget_instances['_multiwidget'] ) ) {
	                        $multiwidget = $single_widget_instances['_multiwidget'];
	                        unset( $single_widget_instances['_multiwidget'] );
	                        $single_widget_instances['_multiwidget'] = $multiwidget;
	                    }

	                    // Update option with new widget
	                    update_option( 'widget_' . $id_base, $single_widget_instances );

	                // Assign widget instance to sidebar
	                $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
	                $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
	                $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
	                update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

	                // Success message
	                if ( $sidebar_available ) {
	                    $widget_message_type = 'success';
	                    $widget_message = esc_html__( 'Imported', 'nrg_premium' );
	                } else {
	                    $widget_message_type = 'warning';
	                    $widget_message = esc_html__( 'Imported to Inactive', 'nrg_premium' );
	                }

	            }

	            // Result for widget instance
	            $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
	            @$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : esc_html__( 'No Title', 'nrg_premium' ); // show "No Title" if widget instance is untitled
	            $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
	            $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;
	        }
	    }
	    return true;

	}

	private function _content_install_customize(){

		$customize_options = $this->_get_json('customize.json');

		
		$menus = get_terms('nav_menu');
		$menu_ids = array();
		foreach($menus as $menu){
			if($menu->slug == 'main-menu'){
				$menu_ids['primary_menu'] = $menu->term_id;
			}
			if ($menu->slug == 'footer-menu') {
				$menu_ids['footer_menu'] = $menu->term_id;
			}
		}

		// adjust the widget settings to match our menu ID's which we discovered above.
		if(is_array($customize_options) && isset($customize_options['nav_menu_locations'])){
			foreach($customize_options['nav_menu_locations'] as $key => $val){
				if ($key == 'top_menu' && $val != $menu_ids['primary']) {
					$customize_options['nav_menu_locations'][$key] = $menu_ids['primary_menu'];
				}
				if ($key == 'footer_menu' && $val != $menu_ids['footer_menu']) {
					$customize_options['nav_menu_locations'][$key] = $menu_ids['footer_menu'];
				}
			}
		}

		foreach($customize_options as $option => $value){
			set_theme_mod( $option, $value );
		}
		return true;
	}
	private function _get_json($file){
		if(is_file(__DIR__.'/content/'.basename($file))) {
			WP_Filesystem();
			global $wp_filesystem;
			return json_decode( $wp_filesystem->get_contents( __DIR__ . '/content/' . basename( $file )), true  );
		}
		return array();
	}
	// settings codestar
	private function _content_install_codestar(){
		$theme_options = $this->_get_json('theme_options.json');
		if (function_exists('cs_decode_string')) {
			update_option( '_cs_options', cs_decode_string($theme_options['data']) );
		}
		return true;
	}
	/**
	 * Logo & Design
	 */
	public function envato_setup_logo_design() {

		?>
		<h1><?php esc_html_e( 'Logo &amp; Design', 'nrg_premium' ); ?></h1>
		<form method="post">
			<p><?php esc_html_e('Please add your logo below. For best results, the logo should be a transparent PNG ( 190 by 35 pixels). The logo can be changed at any time from the Appearance > Customize area in your dashboard.', 'nrg_premium' ); ?> </p>
			<table>
				<tr>
					<td>
						<div id="current-logo">
							<?php $image_url = get_theme_mod('logo_header_image', get_template_directory_uri().'/assets/img/logo_dark.png');
							if($image_url){
								$image = '<img class="site-logo" src="%s" alt="%s" style="width:%s; height:auto" />';
								printf(
									$image,
									esc_attr($image_url),
									esc_html(get_bloginfo('name')),
									'200px'
								);
							} ?>
						</div>
					</td>
					<td>
						<a href="#" class="button button-upload"><?php esc_html_e( 'Upload New Logo', 'nrg_premium' ); ?></a>
					</td>
				</tr>
			</table>


			<p><?php esc_html_e('Please choose the color scheme for this website. The color scheme (along with font colors &amp; styles) can be changed at any time from the Appearance > Customize area in your dashboard.' ,'nrg_premium' ); ?></p>

			<div class="theme-presets">
				<ul>
					<?php
					$current_demo = get_theme_mod('theme_style','pink');
					$demo_styles = apply_filters('beautiful_default_styles',array());
					foreach($demo_styles as $demo_name => $demo_style){
						?>
						<li<?php echo esc_attr( $demo_name==$current_demo ? ' class="current" ' : ''); ?>>
							<a href="#" data-style="<?php echo esc_attr($demo_name);?>"><img src="<?php echo esc_url($demo_style['image']);?>"></a>
						</li>
					<?php } ?>
				</ul>
			</div>

			<input type="hidden" name="new_logo_id" id="new_logo_id" value="">
			<input type="hidden" name="new_style" id="new_style" value="">

			<p class="envato-setup-actions step">
				<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'nrg_premium' ); ?>" name="save_step" />
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'nrg_premium' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
			</p>
		</form>
		<?php
	}

	/**
	 * Save logo & design options
	 */
	public function envato_setup_logo_design_save() {
		check_admin_referer( 'envato-setup' );


		$new_logo_id = (int)$_POST['new_logo_id'];
		// save this new logo url into the database and calculate the desired height based off the logo width.
		// copied from dtbaker.theme_options.php
		if($new_logo_id) {
			$attr = wp_get_attachment_image_src( $new_logo_id, 'full' );
			if ( $attr && !empty( $attr[1] ) && !empty( $attr[2] ) ) {
				set_theme_mod('logo_header_image',$attr[0]);
				// we have a width and height for this image. awesome.
				$logo_width = (int) get_theme_mod( 'logo_header_image_width', '467' );
				$scale = $logo_width / $attr[1];
				$logo_height = $attr[2] * $scale;
				if ( $logo_height > 0 ) {
					set_theme_mod( 'logo_header_image_height', $logo_height );
				}
			}
		}

		$new_style = $_POST['new_style'];
		$demo_styles = apply_filters('beautiful_default_styles',array());
		if(isset($demo_styles[$new_style])){
			set_theme_mod('theme_style',$new_style);
		}

		wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
		exit;
	}

	/**
	 * Payments Step
	 */
	public function envato_setup_updates() {
		?>
		<h1><?php esc_html_e( 'Theme Updates', 'nrg_premium' ); ?></h1>
		<?php if ( function_exists( 'envato_market' ) ) { ?>
		<form method="post">
			<?php
			$option = envato_market()->get_options();

			$my_items = array();
			if ( $option && !empty( $option['items'] ) ) {
				foreach ( $option['items'] as $item ) {
					if ( !empty($item['oauth']) && !empty($item['token_data']['expires']) && $item['oauth'] == $this->envato_username && $item['token_data']['expires'] >= time()) {
						// token exists and is active
						$my_items[] = $item;
					}
				}
			}
			if(count($my_items)){
				?>
				<p>Thanks! Theme updates have been enabled for the following items: </p>
				<ul>
					<?php foreach($my_items as $item){ ?>
					<li><?php echo esc_html($item['name']);?></li>
					<?php } ?>
				</ul>
				<p><?php esc_html_e( 'When an update becomes available it will show in the Dashboard with an option to install.', 'nrg_premium' ); ?></p>
				<p><?php esc_html_e( "Change settings from the 'Envato Market' menu in the WordPress Dashboard.", 'nrg_premium' ); ?></p>

				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next button-primary"><?php esc_html_e( 'Continue', 'nrg_premium' ); ?></a>
				</p>
				<?php
			}else{
			?>
				<p><?php esc_html_e( 'Please login using your ThemeForest account to enable Theme Updates. We update themes when a new feature is added or a bug is fixed. It is highly recommended to enable Theme Updates.', 'nrg_premium' ); ?></p>
				<p><?php esc_html_e( 'When an update becomes available it will show in the Dashboard with an option to install.', 'nrg_premium' ); ?></p>
				<p>
					<em><?php esc_html_e( 'On the next page you will be asked to Login with your ThemeForest account and grant permissions to enable Automatic Updates.', 'nrg_premium' ); ?></em>
				</p>
				<p class="envato-setup-actions step">
					<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Login with Envato', 'nrg_premium' ); ?>" name="save_step" />
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'nrg_premium' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			<?php } ?>
		</form>
			<?php }else{ ?>
		<?php esc_html_e( 'Please ensure the Envato Market plugin has been installed correctly. ', 'nrg_premium' ); ?><a href="<?php echo esc_url($this->get_step_link('default_plugins'));?>"><?php esc_html_e( 'Return to Required Plugins installer', 'nrg_premium' ); ?></a>.
		<?php } ?>
		<?php
	}

	/**
	 * Payments Step save
	 */
	public function envato_setup_updates_save() {
		check_admin_referer( 'envato-setup' );

		// redirect to our custom login URL to get a copy of this token.
		$url = $this->get_oauth_login_url($this->get_step_link('updates'));

		wp_redirect( esc_url_raw( $url ) );
		exit;
	}


	public function envato_setup_customize(){
		?>

		<h1><?php esc_html_e( 'Theme Customization', 'nrg_premium' ); ?></h1>
		<p>
			<?php esc_html_e( 'Most changes to the website can be made through the Appearance > Customize menu from the WordPress dashboard.', 'nrg_premium' ); ?>
		</p>
		<p><?php esc_html_e( 'To change the Sidebars go to Appearance > Widgets. Here widgets can be "drag &amp; droped" into sidebars. To control which "widget areas" appear, go to an individual page and look for the "Left/Right Column" menu. Here widgets can be chosen for display on the left or right of a page. More details in documentation.', 'nrg_premium' ); ?></p>
		<p>
			<em>
			<?php esc_html_e( 'Advanced Users: If you are going to make changes to the theme source code please use a', 'nrg_premium' );?>
				<a href="https://codex.wordpress.org/Child_Themes" target="_blank"><?php esc_html_e( 'Child Theme', 'nrg_premium' );?></a>
			<?php echo sprintf(esc_html__( 'rather than modifying the main theme HTML/CSS/PHP code. This allows the parent theme to receive updates without overwriting your source code changes. %s See %s in the main folder for a sample.', 'nrg_premium' ), '<br/>', '<code>child-theme.zip</code>'); ?></em>
		</p>

		<p class="envato-setup-actions step">
			<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-primary button-large button-next"><?php esc_html_e( 'Continue', 'nrg_premium' ); ?></a>
		</p>

		<?php
	}
	public function envato_setup_help_support(){
		?>
		<h1><?php esc_html_e( 'Help and Support', 'nrg_premium' ); ?></h1>
		<p><?php esc_html_e( 'This theme comes with 6 months item support from purchase date (with the option to extend this period). This license allows you to use this theme on a single website. Please purchase an additional license to use this theme on another website.', 'nrg_premium' ); ?></p>
		<p><?php 
		$help_desc = 'nrgthemes.ticksy.com';
		echo sprintf( esc_html__( 'Item Support can be accessed from %s and includes: ', 'nrg_premium' ), '<a href="' . esc_url( $help_desc, 'https') . '" target="_blank">https://nrgthemes.ticksy.com/</a>'  ); ?></p>
		<ul>
			<li><?php esc_html_e( 'Availability of the author to answer questions', 'nrg_premium' ); ?></li>
			<li><?php esc_html_e( 'Answering technical questions about item features', 'nrg_premium' ); ?></li>
			<li><?php esc_html_e( 'Assistance with reported bugs and issues', 'nrg_premium' ); ?></li>
			<li><?php esc_html_e( 'Help with bundled 3rd party plugins', 'nrg_premium' ); ?></li>
		</ul>
		<?php echo sprintf( esc_html__( 'Item Support %s Include:', 'nrg_premium' ), '<strong>DOES NOT</strong>' ); ?>
		<ul>
			<li><?php esc_html_e( 'Customization services', 'nrg_premium' ); ?></li>
			<li><?php esc_html_e( 'Installation services', 'nrg_premium' ); ?></li>
			<li><?php esc_html_e( 'Help and Support for non-bundled 3rd party plugins (i.e. plugins you install yourself later on)', 'nrg_premium' ); ?></li>
		</ul>
		<?php 
		$support_policy = 'http://themeforest.net/page/item_support_policy';
		?>
		<p><?php esc_html_e( 'More details about item support can be found in the ThemeForest', 'nrg_premium' ); ?> <a href="<?php echo esc_url( $support_policy, 'http'); ?>" target="_blank"><?php esc_html_e( 'Item Support Polity', 'nrg_premium' ); ?></a>. </p>
		<p class="envato-setup-actions step">
			<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-primary button-large button-next"><?php esc_html_e( 'Agree and Continue', 'nrg_premium' ); ?></a>
			<?php wp_nonce_field( 'envato-setup' ); ?>
		</p>
		<?php
	}

	/**
	 * Final step
	 */
	public function envato_setup_ready() {
		?>
	
		<h1><?php esc_html_e( 'Your Website is Ready!', 'nrg_premium' ); ?></h1>

		<p><?php esc_html_e( 'Congratulations! The theme has been activated and your website is ready. Login to your WordPress dashboard to make changes and modify any of the default content to suit your needs.', 'nrg_premium' ); ?></p>

		<div class="envato-setup-next-steps">
			<div class="envato-setup-next-steps-first">
				<h2><?php esc_html_e( 'Next Steps', 'nrg_premium' ); ?></h2>
				<ul>
					<li class="setup-product"><a class="button button-primary button-large" href="<?php echo esc_url( home_url() ); ?>"><b><?php esc_html_e( 'VIEW YOUR NEW WEBSITE!', 'nrg_premium' ); ?></b></a></li>
				</ul>
			</div>
			<div class="envato-setup-next-steps-last">
				<h2><?php esc_html_e( 'More Resources', 'nrg_premium' ); ?></h2>
				<ul>
					<li class="documentation"><a href="#" target="_blank"><?php esc_html_e( 'Read the Theme Documentation', 'nrg_premium' ); ?></a></li>
					<li class="howto"><a href="https://wordpress.org/support/" target="_blank"><?php esc_html_e( 'Learn how to use WordPress', 'nrg_premium' ); ?></a></li>
				</ul>
			</div>
		</div>
		<?php
	}

	public function envato_market_admin_init(){
		global $wp_settings_sections;
		if ( !isset( $wp_settings_sections[envato_market()->get_slug()] ) ) {
			// means we're running the admin_init hook before envato market gets to setup settings area.
			// good - this means our oauth prompt will appear first in the list of settings blocks
			register_setting( envato_market()->get_slug(), envato_market()->get_option_name() );
		}

		//add_thickbox();

		if ( !empty( $_POST['oauth_session'] ) && !empty( $_POST['bounce_nonce'] ) && wp_verify_nonce( $_POST['bounce_nonce'], 'envato_oauth_bounce_' . $this->envato_username ) ) {
			// request the token from our bounce url.
			$my_theme = wp_get_theme();
			$oauth_nonce = get_option('envato_oauth_'.$this->envato_username);
			if(!$oauth_nonce){
				// this is our 'private key' that is used to request a token from our api bounce server.
				// only hosts with this key are allowed to request a token and a refresh token
				// the first time this key is used, it is set and locked on the server.
				$oauth_nonce = wp_create_nonce( 'envato_oauth_nonce_' . $this->envato_username );
				update_option( 'envato_oauth_'.$this->envato_username, $oauth_nonce);
			}
			$response = wp_remote_post( $this->oauth_script, array(
					'method' => 'POST',
					'timeout' => 15,
					'redirection' => 1,
					'httpversion' => '1.0',
					'blocking' => true,
					'headers' => array(),
					'body' => array(
						'oauth_session' => $_POST['oauth_session'],
						'oauth_nonce' => $oauth_nonce,
						'get_token' => 'yes',
						'url' => home_url(),
						'theme' => $my_theme->get( 'Name' ),
						'version' => $my_theme->get( 'Version' ),
					),
					'cookies' => array()
				)
			);
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				sprintf( esc_html__( 'Something went wrong while trying to retrieve oauth token: %s', 'nrg_premium' ), $error_message  );
			} else {
				$token = @json_decode( wp_remote_retrieve_body( $response ), true );
				$result = false;
				if ( is_array( $token ) && !empty( $token['access_token'] ) ) {
					$token['oauth_session'] = $_POST['oauth_session'];
					$result = $this->_manage_oauth_token($token);
				}
				if($result !== true){
					esc_html_e( 'Failed to get oAuth token. Please go back and try again', 'nrg_premium' );
					exit;
				}
			}
		}

		add_settings_section(
			envato_market()->get_option_name() . '_' . $this->envato_username  . '_oauth_login',
			sprintf( esc_html__( 'Login for %s updates', 'nrg_premium' ), $this->envato_username  ),
			array( $this, 'render_oauth_login_description_callback' ),
			envato_market()->get_slug()
		);
		// Items setting.
		add_settings_field(
			$this->envato_username  . 'oauth_keys',
			esc_html__( 'oAuth Login', 'nrg_premium' ),
			array( $this, 'render_oauth_login_fields_callback' ),
			envato_market()->get_slug(),
			envato_market()->get_option_name() . '_' . $this->envato_username  . '_oauth_login'
		);
	}

	private static $_current_manage_token = false;

	private function _manage_oauth_token($token){
		if ( is_array( $token ) && !empty( $token['access_token'] ) ) {
			if(self::$_current_manage_token == $token['access_token']){
				return false; // stop loops when refresh auth fails.
			}
			self::$_current_manage_token = $token['access_token'];
			// yes! we have an access token. store this in our options so we can get a list of items using it.
			$option = envato_market()->get_options();
			if ( !is_array( $option ) ) {
				$option = array();
			}
			if ( empty( $option['items'] ) ) {
				$option['items'] = array();
			}
			// check if token is expired.
			if(empty($token['expires'])){
				$token['expires'] = time() + 3600;
			}
			if($token['expires'] < time() + 120 && !empty($token['oauth_session'])){
				// time to renew this token!
				$my_theme = wp_get_theme();
				$oauth_nonce = get_option('envato_oauth_'.$this->envato_username);
				$response = wp_remote_post( $this->oauth_script, array(
						'method' => 'POST',
						'timeout' => 10,
						'redirection' => 1,
						'httpversion' => '1.0',
						'blocking' => true,
						'headers' => array(),
						'body' => array(
							'oauth_session' => $token['oauth_session'],
							'oauth_nonce' => $oauth_nonce,
							'refresh_token' => 'yes',
							'url' => home_url(),
							'theme' => $my_theme->get( 'Name' ),
							'version' => $my_theme->get( 'Version' ),
						),
						'cookies' => array()
					)
				);
				if ( is_wp_error( $response ) ) {
					$error_message = $response->get_error_message();
					esc_html_e('Something went wrong while trying to retrieve oauth token: $error_message', 'nrg_premium' );;
				} else {
					$new_token = @json_decode( wp_remote_retrieve_body( $response ), true );
					$result = false;
					if ( is_array( $new_token ) && !empty( $new_token['new_token'] ) ) {
						$token['access_token'] = $new_token['new_token'];
					}
				}
			}
			// use this token to get a list of purchased items
			// add this to our items array.
			$response = envato_market()->api()->request( 'https://api.envato.com/v3/market/buyer/purchases', array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $token['access_token']
				)
			) );
			self::$_current_manage_token = false;
			if ( is_array( $response ) && is_array( $response['purchases'] ) ) {
				// up to here, add to items array
				foreach ( $response['purchases'] as $purchase ) {
					// check if this item already exists in the items array.
					$exists = false;
					foreach ( $option['items'] as $id => $item ) {
						if ( !empty( $item['id'] ) && $item['id'] == $purchase['item']['id'] ) {
							$exists = true;
							// update token.
							$option['items'][$id]['token'] = $token['access_token'];
							$option['items'][$id]['token_data'] = $token;
							$option['items'][$id]['oauth'] = $this->envato_username;
							if(!empty( $purchase['code'] )) {
								$option['items'][$id]['purchase_code'] = $purchase['code'];
							}
						}
					}
					if ( !$exists ) {
						$option['items'][] = array(
							'id' => $purchase['item']['id'],
							'name' => $purchase['item']['name'],
							'token' => $token['access_token'],
							'token_data' => $token,
							'oauth' => $this->envato_username,
							'type' => !empty( $purchase['item']['wordpress_theme_metadata'] ) ? 'theme' : 'plugin',
							'purchase_code' => !empty( $purchase['code'] ) ? $purchase['code'] : ''
						);
					}
				}
			}else{
				return false;
			}
			if(!isset($option['oauth'])){
				$option['oauth'] = array();
			}
			// store our 1 hour long token here. we can refresh this token when it comes time to use it again (i.e. during an update)
			$option['oauth'][$this->envato_username] = $token;
			update_option( envato_market()->get_option_name(), $option );
			envato_market()->items()->set_themes( true );
			envato_market()->items()->set_plugins( true );
			return true;
		}else{
			return false;
		}
	}

	/**
	 * @param $args
	 * @param $url
	 * @return mixed
	 *
	 * Filter the WordPress HTTP call args.
	 * We do this to find any queries that are using an expired token from an oAuth bounce login.
	 * Since these oAuth tokens only last 1 hour we have to hit up our server again for a refresh of that token before using it on the Envato API.
	 * Hacky, but only way to do it.
	 */
	public function envato_market_http_request_args($args, $url){
		if(strpos($url,'api.envato.com') && function_exists('envato_market')){
			// we have an API request.
			// check if it's using an expired token.
			if(!empty($args['headers']['Authorization'])){
				$token = str_replace('Bearer ','',$args['headers']['Authorization']);
				if($token){
					// check our options for a list of active oauth tokens and see if one matches, for this envato username.
					$option = envato_market()->get_options();
					if($option && !empty($option['oauth'][$this->envato_username]) && $option['oauth'][$this->envato_username]['access_token'] == $token && $option['oauth'][$this->envato_username]['expires'] < time() + 120){
						// we've found an expired token for this oauth user!
						// time to hit up our bounce server for a refresh of this token and update associated data.
						$this->_manage_oauth_token($option['oauth'][$this->envato_username]);
						$updated_option = envato_market()->get_options();
						if($updated_option && !empty($updated_option['oauth'][$this->envato_username]['access_token'])){
							// hopefully this means we have an updated access token to deal with.
							$args['headers']['Authorization'] = 'Bearer '.$updated_option['oauth'][$this->envato_username]['access_token'];
						}
					}
				}
			}
		}
		return $args;
	}
	public function render_oauth_login_description_callback() {
		esc_html_e('If you have purchased items from dtbaker on ThemeForest or CodeCanyon please login here for quick and easy updates. Items include: xxxx yyyy zzzz','nrg_premium');

	}

	public function render_oauth_login_fields_callback() {
		$option = envato_market()->get_options();
		?>
		<div class="oauth-login" data-username="<?php echo esc_attr( $this->envato_username ); ?>">
			<a href="<?php echo esc_url( $this->get_oauth_login_url( admin_url( 'admin.php?page=' . envato_market()->get_slug() . '#settings' ) ) ); ?>"
			   class="oauth-login-button button"><?php esc_html_e('Login with Envato','nrg_premium');?></a>
		</div>
		<?php
	}

	/// a better filter would be on the post-option get filter for the items array.
	// we can update the token there.

	public function get_oauth_login_url( $return ) {
		return $this->oauth_script . '?bounce_nonce=' . wp_create_nonce( 'envato_oauth_bounce_' . $this->envato_username ) . '&wp_return=' . urlencode( $return );
	}
}

new Envato_NRGThemes_Setup();