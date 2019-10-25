<?php

class Simple_Author_Box_Block {

	/**
	 * Function constructor
	 */
	function __construct() {

		// Return early if this function does not exist.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'register_block_type' ) );
		add_action( 'init', array( $this, 'generate_js_vars' ) );
		add_action( 'wp_ajax_sab_get_author', array( $this, 'get_author' ) );
	}

	public function register_block_type() {

		wp_register_script( 'sab_gutenberg_editor_script', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sab_gutenberg_editor_script.js', array( 'wp-blocks', 'wp-element', 'wp-editor' ) );
		wp_register_style( 'sab_gutenberg_editor_style', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sab_gutenberg_editor_style.css', array() );

		register_block_type(
			'simple-author-box/sab',
			array(
				'render_callback' => array( $this, 'render_sab_block' ),
				'editor_script'   => 'sab_gutenberg_editor_script',
				'editor_style'    => 'sab_gutenberg_editor_style',
			)
		);

	}

	public function generate_js_vars() {

		$user               = wp_get_current_user();
		$padding_top_bottom = Simple_Author_Box_Helper::get_option( 'sab_box_padding_top_bottom' );
		$padding_left_right = Simple_Author_Box_Helper::get_option( 'sab_box_padding_left_right' );
		$top_margin         = Simple_Author_Box_Helper::get_option( 'sab_box_margin_top' );
		$sabox_name_size    = Simple_Author_Box_Helper::get_option( 'sab_box_name_size' );
		$sabox_desc_size    = Simple_Author_Box_Helper::get_option( 'sab_box_desc_size' );
		$sabox_web_size     = Simple_Author_Box_Helper::get_option( 'sab_box_web_size' );
		$sabox_icon_size    = Simple_Author_Box_Helper::get_option( 'sab_box_icon_size' );
		$sab_box_name_font  = Simple_Author_Box_Helper::get_option( 'sab_box_name_font' );
		$sab_box_desc_font  = Simple_Author_Box_Helper::get_option( 'sab_box_desc_font' );
		$sab_box_web_font   = Simple_Author_Box_Helper::get_option( 'sab_box_web_font' );
		$sab_box_subset     = Simple_Author_Box_Helper::get_option( 'sab_box_subset' );
		$bottom_margin      = Simple_Author_Box_Helper::get_option( 'sab_box_margin_bottom' );
		$sabox_options      = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );
		$authors            = get_users(
			array(
				'role__in' => array( 'administrator', 'editor', 'author', 'contributor' ),
				'fields'   => array( 'ID', 'display_name' ),
			)
		);

		wp_localize_script(
			'sab_gutenberg_editor_script',
			'sabVars',
			array(
				'ajaxURL'                => admin_url( 'admin-ajax.php' ),
				'currentUserID'          => get_current_user_id(),
				'currentUserRoles'       => $user->roles,
				'adminURL'               => admin_url(),
				'sab_avatar_style'       => isset( $sabox_options['sab_avatar_style'] ) ? $sabox_options['sab_avatar_style'] : '0',
				'sab_box_long_shadow'    => isset( $sabox_options['sab_box_long_shadow'] ) ? $sabox_options['sab_box_long_shadow'] : '0',
				'sab_box_thin_border'    => isset( $sabox_options['sab_box_thin_border'] ) ? $sabox_options['sab_box_thin_border'] : '0',
				'sab_box_border'         => isset( $sabox_options['sab_box_border'] ) ? $sabox_options['sab_box_border'] : '',
				'sab_box_border_width'   => isset( $sabox_options['sab_box_border_width'] ) ? $sabox_options['sab_box_border_width'] : '1',
				'sab_box_icons_back'     => isset( $sabox_options['sab_box_icons_back'] ) ? $sabox_options['sab_box_icons_back'] : '',
				'sab_box_author_back'    => isset( $sabox_options['sab_box_author_back'] ) ? $sabox_options['sab_box_author_back'] : '',
				'sab_box_author_p_color' => isset( $sabox_options['sab_box_author_p_color'] ) ? $sabox_options['sab_box_author_p_color'] : '',
				'sab_box_author_a_color' => isset( $sabox_options['sab_box_author_a_color'] ) ? $sabox_options['sab_box_author_a_color'] : '',
				'sab_box_author_color'   => isset( $sabox_options['sab_box_author_color'] ) ? $sabox_options['sab_box_author_color'] : '',
				'sab_box_web_color'      => isset( $sabox_options['sab_box_web_color'] ) ? $sabox_options['sab_box_web_color'] : '',
				'sab_box_name_font'      => isset( $sab_box_name_font ) ? $sab_box_name_font : 'None',
				'sab_box_desc_font'      => isset( $sab_box_desc_font ) ? $sab_box_desc_font : 'None',
				'sab_box_web_font'       => isset( $sab_box_web_font ) ? $sab_box_web_font : 'None',
				'sab_box_subset'         => isset( $sab_box_subset ) ? $sab_box_subset : 'none',
				'sab_desc_style'         => isset( $sabox_options['sab_desc_style'] ) ? $sabox_options['sab_desc_style'] : '0',
				'padding_top_bottom'     => isset( $padding_top_bottom ) ? $padding_top_bottom : '',
				'padding_left_right'     => isset( $padding_left_right ) ? $padding_left_right : '',
				'top_margin'             => isset( $top_margin ) ? $top_margin : '',
				'bottom_margin'          => isset( $bottom_margin ) ? $bottom_margin : '',
				'sabox_name_size'        => isset( $sabox_name_size ) ? $sabox_name_size : '18',
				'sabox_desc_size'        => isset( $sabox_desc_size ) ? $sabox_desc_size : '14',
				'sabox_web_size'         => isset( $sabox_web_size ) ? $sabox_web_size : '14',
				'sabox_icon_size'        => isset( $sabox_icon_size ) ? $sabox_icon_size : '18',
				'sab_web'                => isset( $sabox_options['sab_web'] ) ? $sabox_options['sab_web'] : 0,
				'sab_hide_socials'       => isset( $sabox_options['sab_hide_socials'] ) ? $sabox_options['sab_hide_socials'] : 0,
				'sab_colored'            => isset( $sabox_options['sab_colored'] ) ? $sabox_options['sab_colored'] : 0,
				'sab_icons_style'        => isset( $sabox_options['sab_icons_style'] ) ? $sabox_options['sab_icons_style'] : 0,
				'authors'                => $authors,
				'nonce'                  => wp_create_nonce( 'sab_nonce' ),
			)
		);
	}

	public function get_author() {

		$author_id = absint($_POST['author_ID']);
		$nonce     = $_POST['nonce'];

		if ( ! wp_verify_nonce( $nonce, 'sab_nonce' ) ) {
			wp_send_json_error();
			die();
		}

		$author      = get_user_by( 'ID', $author_id );
		$author_meta = get_user_meta( $author_id );

		if ( $author == false || $author_meta == false ) {
			wp_send_json_error();
			die();
		}

		$author_meta['avatar']             = get_avatar_url( $author_id, array( 'size' => 200 ) );
		$author_meta['description']        = get_the_author_meta( 'description', $author_id );
		$author_meta['description']        = wpautop( $author_meta['description'] );
		$author_meta['sabox_social_links'] = Simple_Author_Box_Helper::get_user_social_links( $author_id );

		echo json_encode( (object) array_merge( (array) $author, (array) $author_meta ) );
		die();
	}


	public function render_sab_block( $atts ) {
		return do_shortcode( '[simple-author-box ids=' . $atts['authorID'] . ' ]' );
	}


}

new Simple_Author_Box_Block();


