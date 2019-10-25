<?php

/**
 *
 */
class Simple_Author_Box_Previewer {

	// These are fields that we need to listen to see if we need to change the preview.
	private $fields = array(
		'sab_email',
		'sab_hide_socials',
		'sab_box_padding_top_bottom',
		'sab_box_padding_left_right',
		'sab_box_border_width',
		'sab_avatar_style',
		'sab_avatar_hover',
		'sab_web',
		'sab_web_position',
		'sab_colored',
		'sab_icons_style',
		'sab_social_hover',
		'sab_box_long_shadow',
		'sab_box_thin_border',
		'sab_box_author_color',
		'sab_box_web_color',
		'sab_box_border',
		'sab_box_icons_back',
		'sab_box_author_back',
		'sab_box_author_p_color',
		'sab_box_author_a_color',
		'sab_box_icons_color',
		'sab_box_name_font',
		'sab_box_web_font',
		'sab_box_desc_font',
		'sab_box_name_size',
		'sab_box_web_size',
		'sab_box_desc_size',
		'sab_box_icon_size',
		'sab_desc_style'
	);

	private $options;

	function __construct() {

		// Output Author Box
		add_action( 'sab_admin_preview', array( $this, 'output_author_box' ) );

		// Enqueue previewer js
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_style_and_scripts' ) );

	}

	public function admin_style_and_scripts( $hook ) {

		// loaded only on plugin page
		if ( 'toplevel_page_simple-author-box-options' == $hook ) {

			wp_enqueue_script( 'sabox-webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', array(), false, true );
			wp_enqueue_script( 'sabox-previewer', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sab-preview.js', array(
				'jquery',
				'backbone',
				'sabox-webfont'
			), false, true );
		}

	}

	public function output_author_box() {

		$this->options = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );

		echo '<style type="text/css">';
		echo $this->generate_inline_css();
		echo '</style>';

		echo '<div class="saboxplugin-wrap" style="max-width:656px;margin:0 auto;width:100%;">'; // start saboxplugin-wrap div

		// author box gravatar
		$avatar_classes = 'saboxplugin-gravatar';
		if ( '1' == $this->options['sab_avatar_hover'] ) {
			$avatar_classes .= ' sab-rotate-img';
		}

		if ( '1' == $this->options['sab_avatar_style'] ) {
			$avatar_classes .= ' sab-round-image';
		}
		echo '<div class="' . $avatar_classes . '">';
		echo get_avatar( 1, 100, 'mystery', '', array( 'force_default' => true ) );

		echo '</div>';

		// author box name
		echo '<div class="saboxplugin-authorname">';
		echo apply_filters( 'sabox_preview_author_html', '<a href="#" class="vcard author"><span class="fn">John Doe</span></a>' );
		echo '</div>';


		// author box description
		echo '<div class="saboxplugin-desc">';
		echo '<div>';
		echo wp_kses_post( 'Sed non elit aliquam, tempor nisl vitae, euismod quam. Nulla et lacus lectus. Nunc sed tincidunt arcu. Nam maximus luctus nunc, in ullamcorper turpis luctus ac. Morbi a leo ut metus mollis facilisis. Integer feugiat dictum dolor id egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus.' );
		echo '</div>';
		echo '</div>';

		echo '<div class="saboxplugin-web' . ( '1' == $this->options['sab_web'] ? ' sab-web-position' : '' ) . '" style="' . ( '1' == $this->options['sab_web'] ? '' : 'display:none;' ) . '">';
		echo '<a href="#">www.machothemes.com</a>';
		echo '</div>';

		// author box clearfix
		echo '<div class="clearfix"></div>';

		$social_links               = apply_filters('sabox_social_icons',Simple_Author_Box_Helper::$social_icons);
		$social_links['user_email'] = '#';

		$extra_class = ' sab-show-simple';
		if ( '1' == $this->options['sab_colored'] ) {
			if ( '1' == $this->options['sab_icons_style'] ) {
				$extra_class = ' sab-show-circle';
			} else {
				$extra_class = ' sab-show-square';
			}
		}

		if ( '1' != $this->options['sab_box_long_shadow'] ) {
			$extra_class .= ' without-long-shadow';
		}

		if ( '1' == $this->options['sab_social_hover'] ) {
			$extra_class .= ' sab-rotate-icons';
		}

		if ( '1' == $this->options['sab_box_thin_border'] ) {
			$extra_class .= ' sab-icons-with-border';
		}

		echo '<div class="saboxplugin-socials sabox-colored' . $extra_class . '" style="' . ( '1' == $this->options['sab_hide_socials'] ? 'display:none;' : '' ) . '">';
		$simple_icons_html = '';
		$circle_icons_html = '';
		$square_icons_html = '';
		$link              = '<a href="#" class="%s">%s</a>';

		foreach ( $social_links as $social_platform => $social_link ) {

			$simple_icons_html .= sprintf( $link, 'saboxplugin-icon-grey', Simple_Author_Box_Social::icon_to_svg( $social_platform, 'simple' ) );
			$circle_icons_html .= sprintf( $link, 'saboxplugin-icon-color', Simple_Author_Box_Social::icon_to_svg( $social_platform, 'circle' ) );
			$square_icons_html .= sprintf( $link, 'saboxplugin-icon-color', Simple_Author_Box_Social::icon_to_svg( $social_platform, 'square' ) );

		}

		echo '<div class="sab-simple-icons">' . $simple_icons_html . '</div>';
		echo '<div class="sab-circle-icons">' . $circle_icons_html . '</div>';
		echo '<div class="sab-square-icons">' . $square_icons_html . '</div>';


		echo '</div>';
		echo '</div>'; // end of saboxplugin-wrap div
		echo '<div class="note"><strong>Note:</strong> By default our Author Box will take the current font family and color from your theme. Basically if you don\'t select a font or a color from the plugin\'s settings the font and color of the Author Box will be different on the front-end than in the previewer.</div>';
	}

	private function generate_inline_css() {

		$padding_top_bottom = Simple_Author_Box_Helper::get_option( 'sab_box_padding_top_bottom' );
		$padding_left_right = Simple_Author_Box_Helper::get_option( 'sab_box_padding_left_right' );
		$sabox_name_size    = Simple_Author_Box_Helper::get_option( 'sab_box_name_size' );
		$sabox_desc_size    = Simple_Author_Box_Helper::get_option( 'sab_box_desc_size' );
		$sabox_icon_size    = Simple_Author_Box_Helper::get_option( 'sab_box_icon_size' );
		$sabox_options      = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );
		$sabox_web_size     = Simple_Author_Box_Helper::get_option( 'sab_box_web_size' );

		$style = '.saboxplugin-wrap{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;box-sizing:border-box;border:1px solid #eee;width:100%;clear:both;display:block;overflow:hidden;word-wrap:break-word;position:relative}.saboxplugin-wrap .saboxplugin-gravatar{float:left;padding:20px}.saboxplugin-wrap .saboxplugin-gravatar img{max-width:100px;height:auto;}.saboxplugin-wrap .saboxplugin-authorname{font-size:18px;line-height:1;margin:20px 0 0 20px;display:block}.saboxplugin-wrap .saboxplugin-authorname a{text-decoration:none}.saboxplugin-wrap .saboxplugin-authorname a:focus{outline:0}.saboxplugin-wrap .saboxplugin-desc{display:block;margin:5px 20px}.saboxplugin-wrap .saboxplugin-desc a{text-decoration:underline}.saboxplugin-wrap .saboxplugin-desc p{margin:5px 0 12px}.saboxplugin-wrap .saboxplugin-web{margin:0 20px 15px;text-align:left}.saboxplugin-wrap .sab-web-position{text-align:right}.saboxplugin-wrap .saboxplugin-web a{color:#ccc;text-decoration:none}.saboxplugin-wrap .saboxplugin-socials{position:relative;display:block;background:#fcfcfc;padding:5px;border-top:1px solid #eee}.saboxplugin-wrap .saboxplugin-socials a svg{width:20px;height:20px}.saboxplugin-wrap .saboxplugin-socials a svg .st2{fill:#fff}.saboxplugin-wrap .saboxplugin-socials a svg .st1{fill:rgba(0,0,0,.3)}.saboxplugin-wrap .saboxplugin-socials a:hover{opacity:.8;-webkit-transition:opacity .4s;-moz-transition:opacity .4s;-o-transition:opacity .4s;transition:opacity .4s;box-shadow:none!important;-webkit-box-shadow:none!important}.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color{box-shadow:none;padding:0;border:0;-webkit-transition:opacity .4s;-moz-transition:opacity .4s;-o-transition:opacity .4s;transition:opacity .4s;display:inline-block;color:#fff;font-size:0;text-decoration:inherit;margin:5px;-webkit-border-radius:0;-moz-border-radius:0;-ms-border-radius:0;-o-border-radius:0;border-radius:0;overflow:hidden}.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey{text-decoration:inherit;box-shadow:none;position:relative;display:-moz-inline-stack;display:inline-block;vertical-align:middle;zoom:1;margin:10px 5px;color:#444}.clearfix:after,.clearfix:before{content:\' \';display:table;line-height:0;clear:both}.ie7 .clearfix{zoom:1}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-twitch{border-color:#38245c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-addthis{border-color:#e91c00}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-behance{border-color:#003eb0}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-delicious{border-color:#06c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-deviantart{border-color:#036824}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-digg{border-color:#00327c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-dribbble{border-color:#ba1655}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-facebook{border-color:#1e2e4f}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-flickr{border-color:#003576}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-github{border-color:#264874}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-google{border-color:#0b51c5}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-googleplus{border-color:#96271a}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-html5{border-color:#902e13}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-instagram{border-color:#1630aa}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-linkedin{border-color:#00344f}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-pinterest{border-color:#5b040e}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-reddit{border-color:#992900}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-rss{border-color:#a43b0a}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-sharethis{border-color:#5d8420}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-skype{border-color:#00658a}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-soundcloud{border-color:#995200}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-spotify{border-color:#0f612c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-stackoverflow{border-color:#a95009}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-steam{border-color:#006388}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-user_email{border-color:#b84e05}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-stumbleUpon{border-color:#9b280e}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-tumblr{border-color:#10151b}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-twitter{border-color:#0967a0}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-vimeo{border-color:#0d7091}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-windows{border-color:#003f71}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-wordpress{border-color:#0f3647}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-yahoo{border-color:#14002d}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-youtube{border-color:#900}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-xing{border-color:#000202}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-mixcloud{border-color:#2475a0}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-vk{border-color:#243549}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-medium{border-color:#00452c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-quora{border-color:#420e00}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-meetup{border-color:#9b181c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-goodreads{border-color:#000}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-snapchat{border-color:#999700}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-500px{border-color:#00557f}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-mastodont{border-color:#185886}.sabox-plus-item{margin-bottom:20px}@media screen and (max-width:480px){.saboxplugin-wrap{text-align:center}.saboxplugin-wrap .saboxplugin-gravatar{float:none;padding:20px 0;text-align:center;margin:0 auto;display:block}.saboxplugin-wrap .saboxplugin-gravatar img{float:none;display:inline-block;display:-moz-inline-stack;vertical-align:middle;zoom:1}.saboxplugin-wrap .saboxplugin-desc{margin:0 10px 20px;text-align:center}.saboxplugin-wrap .saboxplugin-authorname{text-align:center;margin:10px 0 20px}}body .saboxplugin-authorname a,body .saboxplugin-authorname a:hover{box-shadow:none;-webkit-box-shadow:none}a.sab-profile-edit{font-size:16px!important;line-height:1!important}.sab-edit-settings a,a.sab-profile-edit{color:#0073aa!important;box-shadow:none!important;-webkit-box-shadow:none!important}.sab-edit-settings{margin-right:15px;position:absolute;right:0;z-index:2;bottom:10px;line-height:20px}.sab-edit-settings i{margin-left:5px}.saboxplugin-socials{line-height:1!important}.rtl .saboxplugin-wrap .saboxplugin-gravatar{float:right}.rtl .saboxplugin-wrap .saboxplugin-authorname{display:flex;align-items:center}.rtl .saboxplugin-wrap .saboxplugin-authorname .sab-profile-edit{margin-right:10px}.rtl .sab-edit-settings{right:auto;left:0}img.sab-custom-avatar{max-width:75px;}';

		// Border color of Simple Author Box
		if ( '' != $sabox_options['sab_box_border'] ) {
			$style .= '.saboxplugin-wrap {border-color:' . esc_html( $sabox_options['sab_box_border'] ) . ';}';
			$style .= '.saboxplugin-wrap .saboxplugin-socials {border-color:' . esc_html( $sabox_options['sab_box_border'] ) . ';}';
		}
		// Border width of Simple Author Box
		if ( '1' != $sabox_options['sab_box_border_width'] ) {
			$style .= '.saboxplugin-wrap, .saboxplugin-wrap .saboxplugin-socials{ border-width: ' . esc_html( $sabox_options['sab_box_border_width'] ) . 'px; }';
		}
		// Avatar image style
		$style .= '.saboxplugin-wrap .saboxplugin-gravatar.sab-round-image img {-webkit-border-radius:50%;-moz-border-radius:50%;-ms-border-radius:50%;-o-border-radius:50%;border-radius:50%;}';

		// Avatar hover effect
		$style .= '.saboxplugin-wrap .saboxplugin-gravatar.sab-round-image.sab-rotate-img img {-webkit-transition:all .5s ease;-moz-transition:all .5s ease;-o-transition:all .5s ease;transition:all .5s ease;}';
		$style .= '.saboxplugin-wrap .saboxplugin-gravatar.sab-round-image.sab-rotate-img img:hover {-webkit-transform:rotate(45deg);-moz-transform:rotate(45deg);-o-transform:rotate(45deg);-ms-transform:rotate(45deg);transform:rotate(45deg);}';

		// Background color of social icons bar
		if ( '' != $sabox_options['sab_box_icons_back'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials{background-color:' . esc_html( $sabox_options['sab_box_icons_back'] ) . ';}';
		}
		// Background color of author box
		if ( '' != $sabox_options['sab_box_author_back'] ) {
			$style .= '.saboxplugin-wrap {background-color:' . esc_html( $sabox_options['sab_box_author_back'] ) . ';}';
		}
		// Color of author box paragraphs
		if ( '' != $sabox_options['sab_box_author_p_color'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-desc p, .saboxplugin-wrap .saboxplugin-desc  {color:' . esc_html( $sabox_options['sab_box_author_p_color'] ) . ';}';
		}
		// Color of author box paragraphs
		if ( '' != $sabox_options['sab_box_author_a_color'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-desc a, .saboxplugin-wrap .saboxplugin-desc  {color:' . esc_html( $sabox_options['sab_box_author_a_color'] ) . ';}';
		}

		// Author name color
		if ( '' != $sabox_options['sab_box_author_color'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-authorname a,.saboxplugin-wrap .saboxplugin-authorname span {color:' . esc_html( $sabox_options['sab_box_author_color'] ) . ';}';
		}

		// Author web color
		if ( '1' == $sabox_options['sab_web'] && '' != $sabox_options['sab_box_web_color'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-web a {color:' . esc_html( $sabox_options['sab_box_web_color'] ) . ';}';
		}

		// Author name font family
		$sab_box_name_font = Simple_Author_Box_Helper::get_option( 'sab_box_name_font' );
		if ( 'None' != $sab_box_name_font ) {
			$style .= '.saboxplugin-wrap .saboxplugin-authorname {font-family:"' . esc_html( $sab_box_name_font ) . '";}';
		}

		// Author description font family
		$sab_box_desc_font = Simple_Author_Box_Helper::get_option( 'sab_box_desc_font' );
		if ( 'None' != $sab_box_name_font ) {
			$style .= '.saboxplugin-wrap .saboxplugin-desc {font-family:' . esc_html( $sab_box_desc_font ) . ';}';
		}

		// Author web font family
		$sab_box_web_font = Simple_Author_Box_Helper::get_option( 'sab_box_web_font' );
		if ( '1' == $sabox_options['sab_web'] && 'None' != $sab_box_web_font ) {
			$style .= '.saboxplugin-wrap .saboxplugin-web {font-family:"' . esc_html( $sab_box_web_font ) . '";}';
		}

		// Author description font style
		if ( isset( $sabox_options['sab_desc_style'] ) && '1' == $sabox_options['sab_desc_style'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-desc {font-style:italic;}';
		}
		// Margin top & bottom, Padding
		$style .= '.saboxplugin-wrap {padding: ' . absint( $padding_top_bottom ) . 'px ' . absint( $padding_left_right ) . 'px }';
		// Author name text size
		$style .= '.saboxplugin-wrap .saboxplugin-authorname {font-size:' . absint( $sabox_name_size ) . 'px; line-height:' . absint( $sabox_name_size + 7 ) . 'px;}';
		// Author description font size
		$style .= '.saboxplugin-wrap .saboxplugin-desc p, .saboxplugin-wrap .saboxplugin-desc {font-size:' . absint( $sabox_desc_size ) . 'px; line-height:' . absint( $sabox_desc_size + 7 ) . 'px;}';
		// Author website text size
		$style .= '.saboxplugin-wrap .saboxplugin-web {font-size:' . absint( $sabox_web_size ) . 'px;}';

		/* Icons */

		// Color of social icons (for symbols only):
		if ( '' != $sabox_options['sab_box_icons_color'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey {color:' . esc_html( $sabox_options['sab_box_icons_color'] ) . ';}';
		}

		// Rotate
		$style .= '.saboxplugin-wrap .saboxplugin-socials.sab-show-circle.sab-rotate-icons .saboxplugin-icon-color {-webkit-transition: all 0.3s ease-in-out;-moz-transition: all 0.3s ease-in-out;-o-transition: all 0.3s ease-in-out;-ms-transition: all 0.3s ease-in-out;transition: all 0.3s ease-in-out;}.saboxplugin-wrap .saboxplugin-socials.sab-show-circle.sab-rotate-icons .saboxplugin-icon-color:hover {-webkit-transform: rotate(360deg);-moz-transform: rotate(360deg);-o-transform: rotate(360deg);-ms-transform: rotate(360deg);transform: rotate(360deg);}';

		// Thin border
		$style .= '.saboxplugin-wrap .saboxplugin-socials.sab-icons-with-border .saboxplugin-icon-color svg {border-width: 1px;border-style:solid;}';
		$style .= '.saboxplugin-wrap .saboxplugin-socials.sab-show-circle.sab-icons-with-border .saboxplugin-icon-color svg {border-radius:50%}';

		// Long Shadow
		$style .= '.saboxplugin-wrap .saboxplugin-socials.without-long-shadow .saboxplugin-icon-color .st1 {display: none;}';

		// Icons size
		$icon_size    = absint( $sabox_icon_size );
		$icon_size_2x = absint( $sabox_icon_size ) * 2;

		$style .= '.saboxplugin-wrap .saboxplugin-socials a.saboxplugin-icon-grey svg {width:' . absint( $icon_size ) . 'px;height:' . absint( $icon_size ) . 'px;}';
		$style .= '.saboxplugin-wrap .saboxplugin-socials a.saboxplugin-icon-color svg {width:' . absint( $icon_size_2x ) . 'px;height:' . absint( $icon_size_2x ) . 'px;}';
		$style .= '.sab-simple-icons,.sab-circle-icons,.sab-square-icons{display:none;}.sab-show-simple .sab-simple-icons{ display:block; }.sab-show-circle .sab-circle-icons{ display:block; }.sab-show-square .sab-square-icons{ display:block; }';
		$style .= '.saboxplugin-wrap a{cursor:not-allowed;}';

		$style = apply_filters( 'sabox-previewer-css', $style, $sabox_options );

		return $style;

	}
}