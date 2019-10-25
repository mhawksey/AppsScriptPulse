<?php

/**
 * Our main plugin class
 */
if( !defined( 'ABSPATH' ) ) exit;

class Simple_Author_Box {

	private static $instance = null;
	private $options;

	/**
	 * Function constructor
	 */
	function __construct() {

		$this->load_dependencies();
		$this->define_admin_hooks();

		add_action( 'init', array( $this, 'define_public_hooks' ) );
        add_action('widgets_init',array($this,'sab_lite_register_widget'));


	}

	// Register Simple Author Box widget
	public function sab_lite_register_widget(){
        register_widget('Simple_Author_Box_Widget_LITE');
    }

	/**
	 * Singleton pattern
	 *
	 * @return void
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function load_dependencies() {

		require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-social.php';
		require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-helper.php';
		require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/functions.php';
    	require_once SIMPLE_AUTHOR_BOX_PATH . '/inc/elementor/class-simple-author-box-elementor-check.php';
    	require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-widget.php';

		if ( apply_filters( 'sabox_remove_lite_block', true ) ) {
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-block.php';
		}
    
    	// everything below this line gets loaded only in the admin back-end
		if ( is_admin() ) {
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-admin-page.php';
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-user-profile.php';
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-previewer.php';
		}

	}


	/**
	 * Admin hooks
	 *
	 * @return void
	 */
	private function define_admin_hooks() {

		/**
		 * everything hooked here loads on both front-end & back-end
		 */
		add_filter( 'get_avatar', array( $this, 'replace_gravatar_image' ), 10, 6 );
		add_filter( 'amp_post_template_data', array( $this, 'sab_amp_css' ) ); // @since 2.0.7

		/**
		 * Only load when we're in the admin panel
		 */
		if ( is_admin() ) {
			add_action( 'init', array( $this, 'initialize_admin' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_style_and_scripts' ) );
			add_filter( 'user_contactmethods', array( $this, 'add_extra_fields' ) );
			add_filter( 'plugin_action_links_' . SIMPLE_AUTHOR_BOX_SLUG, array( $this, 'settings_link' ) );
		}
	}

	public function initialize_admin() {
		// Class that handles admin page
		new Simple_Author_Box_Admin_Page();

		// Class that handles author box previewer
		new Simple_Author_Box_Previewer();
	}


	/**
	 * See this: https://codex.wordpress.org/Plugin_API/Filter_Reference/get_avatar
	 *
	 * Custom function to overwrite WordPress's get_avatar function
	 *
	 * @param [type] $avatar
	 * @param [type] $id_or_email
	 * @param [type] $size
	 * @param [type] $default
	 * @param [type] $alt
	 * @param [type] $args
	 *
	 * @return void
	 */
	public function replace_gravatar_image( $avatar, $id_or_email, $size, $default, $alt, $args = array() ) {

		// Process the user identifier.
		$user = false;
		if ( is_numeric( $id_or_email ) ) {
			$user = get_user_by( 'id', absint( $id_or_email ) );
		} elseif ( is_string( $id_or_email ) ) {

			$user = get_user_by( 'email', $id_or_email );

		} elseif ( $id_or_email instanceof WP_User ) {
			// User Object
			$user = $id_or_email;
		} elseif ( $id_or_email instanceof WP_Post ) {
			// Post Object
			$user = get_user_by( 'id', (int) $id_or_email->post_author );
		} elseif ( $id_or_email instanceof WP_Comment ) {

			if ( ! empty( $id_or_email->user_id ) ) {
				$user = get_user_by( 'id', (int) $id_or_email->user_id );
			}
		}

		if ( ! $user || is_wp_error( $user ) ) {
			return $avatar;
		}

		$custom_profile_image = get_user_meta( $user->ID, 'sabox-profile-image', true );
		$class                = array( 'avatar', 'avatar-' . (int) $args['size'], 'photo' );

		if ( ! $args['found_avatar'] || $args['force_default'] ) {
			$class[] = 'avatar-default';
		}

		if ( $args['class'] ) {
			if ( is_array( $args['class'] ) ) {
				$class = array_merge( $class, $args['class'] );
			} else {
				$class[] = $args['class'];
			}
		}

		$class[] = 'sab-custom-avatar';

		if ( '' !== $custom_profile_image && true !== $args['force_default'] ) {

			$avatar = sprintf(
				"<img alt='%s' src='%s' srcset='%s' class='%s' height='%d' width='%d' %s/>",
				esc_attr( $args['alt'] ),
				esc_url( $custom_profile_image ),
				esc_url( $custom_profile_image ) . ' 2x',
				esc_attr( join( ' ', $class ) ),
				(int) $args['height'],
				(int) $args['width'],
				$args['extra_attr']
			);
		}

		return $avatar;
	}

	public function define_public_hooks() {

		$this->options                            = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );

		add_action( 'wp_enqueue_scripts', array( $this, 'saboxplugin_author_box_style' ), 10 );
		add_shortcode( 'simple-author-box', array( $this, 'shortcode' ) );
		add_filter( 'sabox_hide_social_icons', array( $this, 'show_social_media_icons' ), 10, 2 );
		add_filter( 'sabox_check_if_show', array( $this, 'check_if_show_archive' ), 10 );

		if ( '0' == $this->options['sab_autoinsert'] ) {
			add_filter( 'the_content', 'wpsabox_author_box' );
		}

		if ( isset($this->options['sab_footer_inline_style']) && '0' == $this->options['sab_footer_inline_style'] ) {
			add_action(
				'wp_footer', array(
				$this,
				'inline_style',
			), 13
			);
		} else {
			add_action( 'wp_head', array( $this, 'inline_style' ), 15 );
		}

	}

	public function settings_link(  $links ) {
	    if(is_array($links)) {
            $links['sab'] = sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=simple-author-box-options'), __('Settings', 'saboxplugin'));
        }

		return $links;
	}

	public function admin_style_and_scripts( $hook ) {

		$suffix = '.min';
		if ( SIMPLE_AUTHOR_SCRIPT_DEBUG ) {
			$suffix = '';
		}

		// globally loaded
		wp_enqueue_style( 'sabox-css', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox.css' );
		wp_enqueue_style( 'saboxplugin-admin-style', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox-admin-style' . $suffix . '.css' );

		// loaded only on plugin page
		if ( 'toplevel_page_simple-author-box-options' == $hook ) {

			// Styles
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'jquery-ui', SIMPLE_AUTHOR_BOX_ASSETS . 'css/jquery-ui.min.css' );

			// Scripts
			wp_enqueue_script(
				'sabox-admin-js', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sabox-admin.js', array(
				'jquery-ui-slider',
				'wp-color-picker',
			), false, true
			);
			wp_enqueue_script(
				'sabox-plugin-install', SIMPLE_AUTHOR_BOX_ASSETS . 'js/plugin-install.js', array(
				'jquery',
				'updates',
			), '1.0.0', 'all'
			);

			// loaded only on user profile page
		} elseif ( 'profile.php' == $hook || 'user-edit.php' == $hook ) {

			wp_enqueue_style( 'saboxplugin-admin-style', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox-admin-style' . $suffix . '.css' );

			wp_enqueue_media();
			wp_enqueue_editor();
			wp_enqueue_script( 'sabox-admin-editor-js', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sabox-editor.js', array(), false, true );
			$sabox_js_helper = array();
			$social_icons    = apply_filters( 'sabox_social_icons', Simple_Author_Box_Helper::$social_icons );
			unset( $social_icons['user_email'] );
			$sabox_js_helper['socialIcons'] = $social_icons;

			wp_localize_script( 'sabox-admin-editor-js', 'SABHerlper', $sabox_js_helper );

		}

	}

	public function add_extra_fields( $extra_fields ) {

		unset( $extra_fields['aim'] );
		unset( $extra_fields['jabber'] );
		unset( $extra_fields['yim'] );

		return $extra_fields;

	}

	/*----------------------------------------------------------------------------------------------------------
		Adding the author box main CSS
	-----------------------------------------------------------------------------------------------------------*/
	public function saboxplugin_author_box_style() {

		$suffix = '.min';
		if ( SIMPLE_AUTHOR_SCRIPT_DEBUG ) {
			$suffix = '';
		}

		$sab_protocol   = is_ssl() ? 'https' : 'http';
		$sab_box_subset = Simple_Author_Box_Helper::get_option( 'sab_box_subset' );

		/**
		 * Check for duplicate font families, remove duplicates & re-work the font enqueue procedure
		 *
		 * @since 2.0.4
		 */
		if ( 'none' != strtolower( $sab_box_subset ) ) {
			$sab_subset = '&amp;subset=' . strtolower( $sab_box_subset );
		} else {
			$sab_subset = '&amp;subset=latin';
		}

		$sab_author_font = Simple_Author_Box_Helper::get_option( 'sab_box_name_font' );
		$sab_desc_font   = Simple_Author_Box_Helper::get_option( 'sab_box_desc_font' );
		$sab_web_font    = Simple_Author_Box_Helper::get_option( 'sab_box_web_font' );

		$google_fonts = array();

		if ( $sab_author_font && 'none' != strtolower( $sab_author_font ) ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_author_font ) );
		}

		if ( $sab_desc_font && 'none' != strtolower( $sab_desc_font ) ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_desc_font ) );
		}

		if ( '1' == $this->options['sab_web'] && $sab_web_font && 'none' != strtolower( $sab_web_font ) ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_web_font ) );
		}

		$google_fonts = apply_filters( 'sabox_google_fonts', $google_fonts );

		$google_fonts = array_unique( $google_fonts );

		if ( ! empty( $google_fonts ) ) { // let's check the array's not empty before actually loading; we want to avoid loading 'none' font-familes
			$final_google_fonts = array();

			foreach ( $google_fonts as $v ) {
				$final_google_fonts[] = $v . ':400,700,400italic,700italic';
			}

			wp_register_style( 'sab-font', $sab_protocol . '://fonts.googleapis.com/css?family=' . implode( '|', $final_google_fonts ) . $sab_subset, array(), null );

		}
		/**
		 * end changes introduced in 2.0.4
		 */

		if ( ! is_single() && ! is_page() && ! is_author() && ! is_archive() ) {
			return;
		}

		if ( ! empty( $google_fonts ) ) {
			wp_enqueue_style( 'sab-font' );
		}

	}


	public function inline_style() {

		if ( ! is_single() && ! is_page() && ! is_author() && ! is_archive() ) {
			return;
		}

		$style = '<style type="text/css">';
		$style .= Simple_Author_Box_Helper::generate_inline_css();
		$style .= '</style>';

		echo $style;
	}

	public function shortcode( $atts ) {
		$defaults = array(
			'ids' => '',
		);

		$atts = wp_parse_args( $atts, $defaults );

		if ( '' != $atts['ids'] ) {


			if ( 'all' != $atts['ids'] ) {
				$ids = explode( ',', $atts['ids'] );
			} else {
				$ids = get_users( array( 'fields' => 'ID' ) );
			}

			ob_start();
			$sabox_options = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );
			if ( ! empty( $ids ) ) {
				foreach ( $ids as $user_id ) {

					$template        = Simple_Author_Box_Helper::get_template();
					$sabox_author_id = $user_id;
					echo '<div class="sabox-plus-item">';
					include( $template );
					echo '</div>';

				}
			}

			$html = ob_get_clean();

		} else {
			$html = wpsabox_author_box();
		}

		return $html;
	}


	public function show_social_media_icons( $return, $user ) {
		if ( in_array( 'sab-guest-author', (array) $user->roles ) ) {
			return false;
		}

		return true;
	}

	public function check_if_show_archive() {

		if ( ! is_single() && ! is_author() && ! is_archive() ) {
			return false;
		}

		if ( 1 == $this->options['sab_hide_on_archive'] && ! is_single() ) {
			return false;
		}

		return true;

	}

	/**
	 * AMP compatibility
	 * @since 2.0
	 *
	 * @param $data
	 *
	 * @return mixed
	 */

	function sab_amp_css( $data ) {

		$options = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );

		$icon_size = absint( Simple_Author_Box_Helper::get_option( 'sab_box_icon_size' ) );
		if ( '1' == $options['sab_colored'] ) {
			$icon_size = $icon_size * 2;
		}

		$data['post_amp_styles'] = array(
			'.saboxplugin-wrap .saboxplugin-gravatar'                                      => array(
				'float: left',
				'padding: 20px',
			),
			'.saboxplugin-wrap .saboxplugin-gravatar img'                                  => array(
				'max-width: 100px',
				'height: auto',
			),
			'.saboxplugin-wrap .saboxplugin-authorname'                                    => array(
				'font-size: 18px',
				'line-height: 1',
				'margin: 20px 0 0 20px',
				'display: block',
			),
			'.saboxplugin-wrap .saboxplugin-authorname a'                                  => array(
				'text-decoration: none',
			),
			'.saboxplugin-wrap .saboxplugin-desc'                                          => array(
				'display: block',
				'margin: 5px 20px',
			),
			'.saboxplugin-wrap .saboxplugin-desc a'                                        => array(
				'text-decoration: none',
			),
			'.saboxplugin-wrap .saboxplugin-desc p'                                        => array(
				'margin: 5px 0 12px 0',
				'font-size: ' . absint( Simple_Author_Box_Helper::get_option( 'sab_box_desc_size' ) ) . 'px',
				'line-height: ' . absint( Simple_Author_Box_Helper::get_option( 'sab_box_desc_size' ) + 7 ) . 'px',
			),
			'.saboxplugin-wrap .saboxplugin-web'                                           => array(
				'margin: 0 20px 15px',
				'text-align: left',
			),
			'.saboxplugin-wrap .saboxplugin-socials'                                       => array(
				'position: relative',
				'display: block',
				'background: #fcfcfc',
				'padding: 5px',
				'border-top: 1px solid #eee;',
			),
			'.saboxplugin-wrap .saboxplugin-socials a'                                     => array(
				'text-decoration: none',
				'box-shadow: none',
				'padding: 0',
				'margin: 0',
				'border: 0',
				'transition: opacity 0.4s',
				'-webkit-transition: opacity 0.4s',
				'-moz-transition: opacity 0.4s',
				'-o-transition: opacity 0.4s',
				'display: inline-block',
			),
			'.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey'                => array(
				'display: inline-block',
				'vertical-align: middle',
				'margin: 10px 5px',
				'color: #444',
			),
			'.saboxplugin-wrap .saboxplugin-socials a svg'                                 => array(
				'width:' . absint( $icon_size ) . 'px;',
				'height:' . absint( $icon_size ) . 'px',
				'display:block'
			),
			'.saboxplugin-wrap .saboxplugin-socials.sabox-colored .saboxplugin-icon-color' => array(
				'color: #FFF',
				'margin: 5px',
				'vertical-align: middle',
				'display: inline-block',
			),
			'.saboxplugin-wrap .clearfix'                                                  => array(
				'clear:both;',
			),
			'.saboxplugin-wrap .saboxplugin-socials a svg .st2'                            => array(
				'fill: #fff;'
			),
			'.saboxplugin-wrap .saboxplugin-socials a svg .st1'                            => array(
				'fill: rgba( 0, 0, 0, .3 );'
			),
			'img.sab-custom-avatar'                                                        => array(
				'max-width:75px;'
			),
			// custom paddings & margins
			'.saboxplugin-wrap'                                                            => array(
				'margin-top: ' . absint( Simple_Author_Box_Helper::get_option( 'sab_box_margin_top' ) ) . 'px',
				'margin-bottom: ' . absint( Simple_Author_Box_Helper::get_option( 'sab_box_margin_bottom' ) ) . 'px',
				'padding: ' . absint( Simple_Author_Box_Helper::get_option( 'sab_box_padding_top_bottom' ) ) . 'px ' . absint( Simple_Author_Box_Helper::get_option( 'sab_box_padding_left_right' ) ) . 'px',
				'box-sizing: border-box',
				'border: 1px solid #EEE',
				'width: 100%',
				'clear: both',
				'overflow : hidden',
				'word-wrap: break-word',
				'position: relative',
			),
			'.sab-edit-settings'                                                           => array(
				'display: none;',
			),
			'.sab-profile-edit'                                                            => array(
				'display: none;',
			),
		);

		if ( '1' == $options['sab_colored'] && '1' != $options['sab_box_long_shadow'] ) {
			$data['post_amp_styles']['.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color .st1'] = array(
				'display: none;',
			);
		}

		return $data;
	}
}
