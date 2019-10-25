<?php

// If this file is called directly, busted!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*----------------------------------------------------------------------------------------------------------
	Adding the author box to the end of your single post
-----------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'wpsabox_author_box' ) ) {


	function wpsabox_author_box( $saboxmeta = null ) {
		$show = ( is_single() || is_author() || is_archive() || is_home());

		/**
		 * Hook: sabox_check_if_show.
		 *
		 * @hooked Simple_Author_Box::check_if_show_archive - 10
		 */
		//$show = apply_filters( 'sabox_check_if_show', $show );

		if ( $show ) {

			global $post;
			$template = Simple_Author_Box_Helper::get_template();

			ob_start();
			$sabox_options        = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );
			$sabox_author_id      = $post->post_author;
			$show_post_author_box = apply_filters( 'sabox_check_if_show_post_author_box', true, $sabox_options );

			do_action( 'sabox_before_author_box', $sabox_options );
			if ( $show_post_author_box ) {
				include( $template );
			}

			do_action( 'sabox_after_author_box', $sabox_options );

			$sabox  = ob_get_clean();
			$return = $saboxmeta . $sabox;

			// Filter returning HTML of the Author Box
			$saboxmeta = apply_filters( 'sabox_return_html', $return, $sabox, $saboxmeta );

		}

		return $saboxmeta;
	}
}

//return notice if user hasn't filled Biographical Info
function sab_user_description_notice() {
	$user_id         = get_current_user_id();
	$user            = get_userdata( $user_id );
	$user_descrition = $user->description;
	$user_roles      = $user->roles;
	if ( ! $user_descrition && in_array( 'author', $user_roles ) ) {

		?>
        <div class="notice notice-info is-dismissible">
            <p><?php _e( 'Please complete Biographical Info', 'saboxplugin' ); ?></p>
        </div>
		<?php
	}
}

add_action( 'admin_notices', 'sab_user_description_notice' );


//return notice if user hasn't filled any social profiles
function sab_user_social_notice() {
	$user_id     = get_current_user_id();
	$user_social = get_user_meta( $user_id, 'sabox_social_links' );
	$user        = get_userdata( $user_id );
	$user_roles  = $user->roles;

	if ( ! $user_social && in_array( 'author', $user_roles ) ) {

		?>
        <div class="notice notice-info is-dismissible">
            <p><?php _e( 'Please enter a social profile', 'saboxplugin' ); ?></p>
        </div>
		<?php
	}
}

add_action( 'admin_notices', 'sab_user_social_notice' );
