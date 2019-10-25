<?php

class Simple_Author_Box_Admin_Page {

	private $tab;
	private $options;
	private $sections;
	private $views_path;

	function __construct() {
		$this->views_path = SIMPLE_AUTHOR_BOX_PATH . 'inc/admin/';

		$default_sections = array(
			'general-options'       => array(
				'label' => __( 'Settings', 'saboxplugin' ),
			),
			'appearance-options'    => array(
				'label' => __( 'Appearance', 'saboxplugin' ),
			),
			'color-options'         => array(
				'label' => __( 'Colors', 'saboxplugin' ),
			),
			'typography-options'    => array(
				'label' => __( 'Typography', 'saboxplugin' ),
			),
			'miscellaneous-options' => array(
				'label' => __( 'Misc', 'saboxplugin' ),
			),
			'upgrade-pro'           => array(
				'label' => esc_html__( 'Upgrade', 'saboxplugin' ),
				'link'  => admin_url( 'admin.php?page=sab-upgrade' ),
				'class' => 'upgrade-pro',
			),
		);

		$settings = array(
			'general-options'       => array(
				'sab_autoinsert'     => array(
					'label'       => __( 'Manually insert the Simple Author Box', 'saboxplugin' ),
					'description' => __( 'When turned ON, the author box will no longer be automatically added to your post. You\'ll need to manually add it using shortcodes or a PHP function.', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),
				'plugin_code'        => array(
					'label'     => __( 'If you want to manually insert the Simple Author Box in your template file (single post view), you can use the following code snippet', 'saboxplugin' ),
					'type'      => 'readonly',
					'value'     => '&lt;?php if ( function_exists( \'wpsabox_author_box\' ) ) echo wpsabox_author_box(); ?&gt;',
					'condition' => 'sab_autoinsert',
				),
				'plugin_shortcode'   => array(
					'label'     => __( 'If you want to manually insert the Simple Author Box in your post content, you can use the following shortcode', 'saboxplugin' ),
					'type'      => 'readonly',
					'value'     => '[simple-author-box]',
					'condition' => 'sab_autoinsert',
				),
				'sab_no_description' => array(
					'label'       => __( 'Hide the author box if author description is empty', 'saboxplugin' ),
					'description' => __( 'When turned ON, the author box will not appear for users without a description', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),
				'sab_email'        => array(
					'label'       => __( 'Show author email', 'saboxplugin' ),
					'description' => __( 'When turned ON, the plugin will add an email option next to the social icons.', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),
				'sab_link_target'  => array(
					'label'       => __( 'Open social icon links in a new tab', 'saboxplugin' ),
					'description' => __( 'When turned ON, the author’s social links will open in a new tab.', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),
				'sab_hide_socials' => array(
					'label'       => __( 'Hide the social icons on author box', 'saboxplugin' ),
					'description' => __( 'When turned ON, the author’s social icons will be hidden.', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),
				'sab_hide_on_archive' => array(
					'label'       => __( 'Hide the author box on archives', 'saboxplugin' ),
					'description' => __( 'When turned ON, the author box will be removed on archives.', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),
			),
			'appearance-options'    => array(
				'sab_box_margin_top'         => array(
					'label'       => __( 'Top margin of author box', 'saboxplugin' ),
					'description' => __( 'Choose how much space to add above the author box', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 0,
						'max'       => 100,
						'increment' => 1,
					),
					'default'     => '0',
				),
				'sab_box_margin_bottom'      => array(
					'label'       => __( 'Bottom margin of author box', 'saboxplugin' ),
					'description' => __( 'Choose how much space to add below the author box', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 0,
						'max'       => 100,
						'increment' => 1,
					),
					'default'     => '0',
				),
				'sab_box_padding_top_bottom' => array(
					'label'       => __( 'Padding top and bottom of author box', 'saboxplugin' ),
					'description' => __( 'This controls the padding top & bottom of the author box', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 0,
						'max'       => 100,
						'increment' => 1,
					),
					'default'     => '0',
				),
				'sab_box_padding_left_right' => array(
					'label'       => __( 'Padding left and right of author box', 'saboxplugin' ),
					'description' => __( 'This controls the padding left & right of the author box', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 0,
						'max'       => 100,
						'increment' => 1,
					),
					'default'     => '0',
				),
				'sab_box_border_width'       => array(
					'label'       => __( 'Border Width', 'saboxplugin' ),
					'description' => __( 'This controls the border width of the author box', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 0,
						'max'       => 100,
						'increment' => 1,
					),
					'default'     => '1',
					'group'       => 'saboxplugin_options',
				),
				'sab_avatar_style'           => array(
					'label'       => __( 'Author avatar image style', 'saboxplugin' ),
					'description' => __( 'Change the shape of the author’s avatar image', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => array(
						0 => __( 'Square', 'saboxplugin' ),
						1 => __( 'Circle', 'saboxplugin' ),
					),
					'default'     => '0',
					'group'       => 'saboxplugin_options',
				),
				'sab_avatar_hover'           => array(
					'label'       => __( 'Rotate effect on author avatar hover', 'saboxplugin' ),
					'description' => __( 'When turned ON, this adds a rotate effect when hovering over the author\'s avatar', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
					'condition'   => 'sab_avatar_style',
				),
				'sab_web'                    => array(
					'label'       => __( 'Show author website', 'saboxplugin' ),
					'description' => __( 'When turned ON, the box will include the author\'s website', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),

				'sab_web_target' => array(
					'label'       => __( 'Open author website link in a new tab', 'saboxplugin' ),
					'description' => __( 'If you check this the author\'s link will open in a new tab', 'saboxplugin' ),
					'type'        => 'toggle',
					'condition'   => 'sab_web',
					'group'       => 'saboxplugin_options',
				),
				'sab_web_rel'    => array(
					'label'       => __( 'Add "nofollow" attribute on author website link', 'saboxplugin' ),
					'description' => __( 'Toggling this to ON will make the author website have the no-follow parameter added.', 'saboxplugin' ),
					'type'        => 'toggle',
					'condition'   => 'sab_web',
					'group'       => 'saboxplugin_options',
				),

				'sab_web_position'    => array(
					'label'       => __( 'Author website position', 'saboxplugin' ),
					'description' => __( 'Select where you want to show the website ( left or right )', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => array(
						0 => __( 'Left', 'saboxplugin' ),
						1 => __( 'Right', 'saboxplugin' ),
					),
					'default'     => '0',
					'condition'   => 'sab_web',
					'group'       => 'saboxplugin_options',
				),
				'sab_colored'         => array(
					'label'       => __( 'Social icons type', 'saboxplugin' ),
					'description' => __( 'Colored background adds a background behind the social icon symbol', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => array(
						0 => __( 'Symbols', 'saboxplugin' ),
						1 => __( 'Colored', 'saboxplugin' ),
					),
					'default'     => '0',
					'group'       => 'saboxplugin_options',
				),
				'sab_icons_style'     => array(
					'label'       => __( 'Social icons style', 'saboxplugin' ),
					'description' => __( 'Select the shape of social icons\' container', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => array(
						0 => __( 'Squares', 'saboxplugin' ),
						1 => __( 'Circle', 'saboxplugin' ),
					),
					'default'     => '0',
					'condition'   => 'sab_colored',
					'group'       => 'saboxplugin_options',
				),
				'sab_social_hover'    => array(
					'label'       => __( 'Rotate effect on social icons hover (works only for circle icons)', 'saboxplugin' ),
					'description' => __( 'Add a rotate effect when you hover on social icons hover', 'saboxplugin' ),
					'type'        => 'toggle',
					'condition'   => 'sab_colored',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_long_shadow' => array(
					'label'       => __( 'Use flat long shadow effect', 'saboxplugin' ),
					'description' => __( 'Check this if you want a flat shadow for social icons', 'saboxplugin' ),
					'type'        => 'toggle',
					'condition'   => 'sab_colored',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_thin_border' => array(
					'label'       => __( 'Show a thin border on colored social icons', 'saboxplugin' ),
					'description' => __( 'Add a border to social icons container.', 'saboxplugin' ),
					'type'        => 'toggle',
					'condition'   => 'sab_colored',
					'group'       => 'saboxplugin_options',
				),
			),
			'color-options'         => array(
				'sab_box_author_color'   => array(
					'label'       => __( 'Author name color', 'saboxplugin' ),
					'description' => __( 'Select the color for author\'s name text', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_web_color'      => array(
					'label'       => __( 'Author website link color', 'saboxplugin' ),
					'description' => __( 'Select the color for author\'s website link', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
					'condition'   => 'sab_web',
				),
				'sab_box_border'         => array(
					'label'       => __( 'Border color', 'saboxplugin' ),
					'description' => __( 'Select the color for author box border', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_icons_back'     => array(
					'label'       => __( 'Background color of social icons bar', 'saboxplugin' ),
					'description' => __( 'Select the color for the social icons bar background', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_author_back'    => array(
					'label'       => __( 'Background color of author box', 'saboxplugin' ),
					'description' => __( 'Select the color for the author box background', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_author_p_color' => array(
					'label'       => __( 'Color of author box paragraphs', 'saboxplugin' ),
					'description' => __( 'Select the color for the author box paragraphs', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_author_a_color' => array(
					'label'       => __( 'Color of author box links', 'saboxplugin' ),
					'description' => __( 'Select the color for the author box links', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
				),
				'sab_box_icons_color'    => array(
					'label'       => __( 'Social icons color (for symbols only)', 'saboxplugin' ),
					'description' => __( 'Select the color for social icons when using the symbols only social icon type', 'saboxplugin' ),
					'type'        => 'color',
					'group'       => 'saboxplugin_options',
				),
			),
			'typography-options'    => array(
				'sab_box_subset'    => array(
					'label'       => __( 'Google font characters subset', 'saboxplugin' ),
					'description' => __( 'Note - Some Google Fonts do not support particular subsets', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => Simple_Author_Box_Helper::get_google_font_subsets(),
					'default'     => 'none',
				),
				'sab_box_name_font' => array(
					'label'       => __( 'Author name font family', 'saboxplugin' ),
					'description' => __( 'Select the font family for the author\'s name', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => Simple_Author_Box_Helper::get_google_fonts(),
					'default'     => 'None',
				),
				'sab_box_web_font'  => array(
					'label'       => __( 'Author website font family', 'saboxplugin' ),
					'description' => __( 'Select the font family for the author\'s website', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => Simple_Author_Box_Helper::get_google_fonts(),
					'default'     => 'None',
					'condition'   => 'sab_web',
				),
				'sab_box_desc_font' => array(
					'label'       => __( 'Author description font family', 'saboxplugin' ),
					'description' => __( 'Select the font family for the author\'s description', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => Simple_Author_Box_Helper::get_google_fonts(),
					'default'     => 'None',
				),
				'sab_box_name_size' => array(
					'label'       => __( 'Author name font size', 'saboxplugin' ),
					'description' => __( 'Default font size for author name is 18px.', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 10,
						'max'       => 50,
						'increment' => 1,
					),
					'default'     => '18',
				),
				'sab_box_web_size'  => array(
					'label'       => __( 'Author website font size', 'saboxplugin' ),
					'description' => __( 'Default font size for author website is 14px.', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 10,
						'max'       => 50,
						'increment' => 1,
					),
					'default'     => '14',
					'condition'   => 'sab_web',
				),
				'sab_box_desc_size' => array(
					'label'       => __( 'Author description font size', 'saboxplugin' ),
					'description' => __( 'Default font size for author description is 14px.', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 10,
						'max'       => 50,
						'increment' => 1,
					),
					'default'     => '14',
				),
				'sab_box_icon_size' => array(
					'label'       => __( 'Size of social icons', 'saboxplugin' ),
					'description' => __( 'Default font size for social icons is 18px.', 'saboxplugin' ),
					'type'        => 'slider',
					'choices'     => array(
						'min'       => 10,
						'max'       => 50,
						'increment' => 1,
					),
					'default'     => '18',
				),
				'sab_desc_style'    => array(
					'label'       => __( 'Author description font style', 'saboxplugin' ),
					'description' => __( 'Select the font style for the author\'s description', 'saboxplugin' ),
					'type'        => 'select',
					'choices'     => array(
						0 => __( 'Normal', 'saboxplugin' ),
						1 => __( 'Italic', 'saboxplugin' ),
					),
					'default'     => '0',
					'group'       => 'saboxplugin_options',
				),
			),
			'miscellaneous-options' => array(
				'sab_footer_inline_style' => array(
					'label'       => __( 'Load generated inline style to footer', 'saboxplugin' ),
					'description' => __( 'This option is useful ONLY if you run a plugin that optimizes your CSS delivery or moves your stylesheets to the footer, to get a higher score on speed testing services. However, the plugin style is loaded only on single post and single page.', 'saboxplugin' ),
					'type'        => 'toggle',
					'group'       => 'saboxplugin_options',
				),
			),
		);

		$this->settings = apply_filters( 'sabox_admin_settings', $settings );
		$this->sections = apply_filters( 'sabox_admin_sections', $default_sections );

		$this->get_all_options();

		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'admin_init', array( $this, 'save_settings' ) );
	}

	private function get_all_options() {

		$this->options = Simple_Author_Box_Helper::get_option( 'saboxplugin_options' );

		$sab_box_margin_top = Simple_Author_Box_Helper::get_option( 'sab_box_margin_top' );
		if ( $sab_box_margin_top ) {
			$this->options['sab_box_margin_top'] = $sab_box_margin_top;
		}

		$sab_box_margin_bottom = Simple_Author_Box_Helper::get_option( 'sab_box_margin_bottom' );
		if ( $sab_box_margin_bottom ) {
			$this->options['sab_box_margin_bottom'] = $sab_box_margin_bottom;
		}

		$sab_box_icon_size = Simple_Author_Box_Helper::get_option( 'sab_box_icon_size' );
		if ( $sab_box_icon_size ) {
			$this->options['sab_box_icon_size'] = $sab_box_icon_size;
		}

		$sab_box_author_font_size = Simple_Author_Box_Helper::get_option( 'sab_box_name_size' );
		if ( $sab_box_author_font_size ) {
			$this->options['sab_box_name_size'] = $sab_box_author_font_size;
		}

		$sab_box_web_size = Simple_Author_Box_Helper::get_option( 'sab_box_web_size' );
		if ( $sab_box_web_size ) {
			$this->options['sab_box_web_size'] = $sab_box_web_size;
		}

		$sab_box_name_font = Simple_Author_Box_Helper::get_option( 'sab_box_name_font' );
		if ( $sab_box_name_font ) {
			$this->options['sab_box_name_font'] = $sab_box_name_font;
		}

		$sab_box_subset = Simple_Author_Box_Helper::get_option( 'sab_box_subset' );
		if ( $sab_box_subset ) {
			$this->options['sab_box_subset'] = $sab_box_subset;
		}

		$sab_box_desc_font = Simple_Author_Box_Helper::get_option( 'sab_box_desc_font' );
		if ( $sab_box_desc_font ) {
			$this->options['sab_box_desc_font'] = $sab_box_desc_font;
		}

		$sab_box_web_font = Simple_Author_Box_Helper::get_option( 'sab_box_web_font' );
		if ( $sab_box_web_font ) {
			$this->options['sab_box_web_font'] = $sab_box_web_font;
		}

		$sab_box_desc_size = Simple_Author_Box_Helper::get_option( 'sab_box_desc_size' );
		if ( $sab_box_desc_size ) {
			$this->options['sab_box_desc_size'] = $sab_box_desc_size;
		}

		$this->options['sab_box_padding_top_bottom'] = Simple_Author_Box_Helper::get_option( 'sab_box_padding_top_bottom' );
		$this->options['sab_box_padding_left_right'] = Simple_Author_Box_Helper::get_option( 'sab_box_padding_left_right' );

	}

	public function menu_page() {
		add_menu_page( __( 'Simple Author Box', 'saboxplugin' ), __( 'Simple Author', 'saboxplugin' ), 'manage_options', 'simple-author-box-options', array(
			$this,
			'setting_page',
		), SIMPLE_AUTHOR_BOX_ASSETS . 'img/sab-icon.png' );

		$show_upsell = apply_filters( 'sabox_show_upsell', true );

		if ( $show_upsell ) {
			add_submenu_page( 'simple-author-box-options', __( 'Upgrade to PRO', 'saboxplugin' ), __( 'Upgrade', 'saboxplugin' ), 'manage_options', 'sab-upgrade', array(
				$this,
				'render_pro_page',
			) );
		}

	}

	public function setting_page() {
		?>

        <div class="masthead">
            <div class="wrap sabox-wrap">
                <div class="sabox-masthead-left">
                    <h1 class="wp-heading-inline">
						<?php
						/* Translators: Welcome Screen Title. */
						echo esc_html( apply_filters( 'sabox_show_pro_title', __( 'Simple Author Box', 'saboxplugin' ) ) );
						?>
                    </h1>

                </div>

                <div class="sabox-masthead-right">
                    <a target="_blank"
                       href="https://www.machothemes.com/support/?utm_source=sab&utm_medium=about-page&utm_campaign=support-button"><?php _e( 'Support', 'saboxplugin' ); ?>
                        &nbsp; &nbsp;<i class="dashicons dashicons-sos"></i>
                    </a>
                </div>
                <div class="wp-clearfix"></div>
            </div>
        </div><!--/.masthead-->

        <div class="sabox-wrap">
            <div class="sabox-preview">
                <div class="sabox-preview-topbar">
                    <a href="<?php echo get_edit_user_link(); ?>#your-profile" class="button button-secondary"
                       target="_blank"><i
                                class="dashicons dashicons-edit"></i><?php echo esc_html__( 'Edit Author Profile', 'saboxplugin' ); ?>
                    </a>
                    <a href="<?php echo get_edit_user_link(); ?>#sabox-custom-profile-image"
                       class="button button-secondary" target="_blank"><i
                                class="dashicons dashicons-admin-users"></i><?php echo esc_html__( 'Change Author Avatar', 'saboxplugin' ); ?>
                    </a>
                    <a href="<?php echo get_edit_user_link(); ?>#sabox-social-table" class="button button-secondary"
                       target="_blank"><i
                                class="dashicons dashicons-networking"></i><?php echo esc_html__( 'Add/Edit Social Media Icons', 'saboxplugin' ); ?>
                    </a>
                </div><!--/.sabox-preview-topbar-->
				<?php do_action( 'sab_admin_preview' ) ?>
            </div>
            <h2 class="epfw-tab-wrapper nav-tab-wrapper wp-clearfix">
				<?php foreach ( $this->sections as $id => $section ) { ?>
					<?php
					$class = 'epfw-tab nav-tab';

					if ( isset( $section['link'] ) ) {
						$url   = $section['link'];
						$class .= ' epfw-tab-link';
					} else {
						$url = '#' . $id;
					}

					if ( isset( $section['class'] ) ) {
						$class .= ' ' . $section['class'];
					}

					?>
                    <a class="<?php echo esc_attr( $class ); ?>"
                       href="<?php echo esc_url( $url ); ?>"><?php echo wp_kses_post( $section['label'] ); ?></a>
				<?php } ?>
            </h2>

            <form method="post" id="sabox-container">
				<?php

				wp_nonce_field( 'sabox-plugin-settings', 'sabox_plugin_settings_page' );

				foreach ( $this->settings as $tab_name => $fields ) {
					echo '<div class="epfw-turn-into-tab" id="' . esc_attr( $tab_name ) . '-tab">';
					echo '<table class="form-table sabox-table">';
					foreach ( $fields as $field_name => $field ) {
						$this->generate_setting_field( $field_name, $field );
					}
					echo '</table>';
					echo '</div>';
				}

				echo '<div class="textright">';
				submit_button( esc_html__( 'Save Settings', 'saboxplugin' ), 'button button-primary button-hero', '', false );
				echo '</div>';

				?>
            </form>

        </div>

        <span class="sabox-version">
				<?php echo _e( 'Version: ', 'saboxplugin' ) . esc_html( apply_filters( 'sabox_show_pro_version', SIMPLE_AUTHOR_BOX_VERSION ) ); ?>

				<?php

				$show_changelog = apply_filters( 'sabox_show_changelog', true );

				if ( $show_changelog ) {
					echo '&nbsp; &middot; &nbsp;';
					echo '<a target="_blank" href="https://github.com/MachoThemes/simple-author-box/blob/master/readme.txt">' . __( 'Changelog', 'saboxplugin' ) . '</a>';
				}
				?>
			</span>

		<?php
	}

	public function save_settings() {

		if ( isset( $_POST['sabox_plugin_settings_page'] ) && wp_verify_nonce( $_POST['sabox_plugin_settings_page'], 'sabox-plugin-settings' ) ) {
			$settings = isset( $_POST['sabox-settings'] ) ? $_POST['sabox-settings'] : array();
			$groups   = array();

			foreach ( $this->settings as $tab => $setting_fields ) {
				foreach ( $setting_fields as $key => $setting ) {
					if ( isset( $setting['group'] ) ) {

						if ( ! isset( $groups[ $setting['group'] ] ) ) {
							$groups[ $setting['group'] ] = get_option( $setting['group'], array() );
						}

						if ( ! isset( $settings[ $setting['group'] ][ $key ] ) && isset( $groups[ $setting['group'] ][ $key ] ) ) {
							$groups[ $setting['group'] ][ $key ] = '0';
						}

						if ( isset( $settings[ $setting['group'] ][ $key ] ) ) {
							$groups[ $setting['group'] ][ $key ] = $this->sanitize_fields( $setting, $settings[ $setting['group'] ][ $key ] );
						}
					} else {

						$current_value = get_option( $key );
						if ( isset( $settings[ $key ] ) ) {
							$value = $this->sanitize_fields( $setting, $settings[ $key ] );
							if ( $current_value != $value ) {
								update_option( $key, $value );
							}
						}
					}
				}
			}

			foreach ( $groups as $key => $values ) {
				update_option( $key, $values );
			}

			do_action( 'sabox_save_settings' );

			Simple_Author_Box_Helper::reset_options();
			$this->get_all_options();

		}

	}

	private function sanitize_fields( $setting, $value ) {
		$default_sanitizers = array(
			'toggle' => 'absint',
			'slider' => 'absint',
			'color'  => 'sanitize_hex_color',
		);

		if ( isset( $setting['sanitize'] ) && function_exists( $setting['sanitize'] ) ) {
			$value = call_user_func( $setting['sanitize'], $value );
		} elseif ( isset( $default_sanitizers[ $setting['type'] ] ) && function_exists( $default_sanitizers[ $setting['type'] ] ) ) {
			$value = call_user_func( $default_sanitizers[ $setting['type'] ], $value );
		} elseif ( 'select' == $setting['type'] ) {
			if ( isset( $setting['choices'][ $value ] ) ) {
				$value = $value;
			} else {
				$value = $setting['default'];
			}
		} elseif ( 'multiplecheckbox' == $setting['type'] ) {
			foreach ( $value as $key ) {
				if ( ! isset( $setting['choices'][ $key ] ) ) {
					unset( $value[ $key ] );
				}
			}
		} else {
			$value = sanitize_text_field( $value );
		}

		return $value;

	}

	private function generate_admin_url( $id ) {
		$url = 'admin.php?page=simple-author-box-options&tab=%1$s';

		return admin_url( sprintf( $url, $id ) );
	}

	private function generate_admin_path( $id ) {
		return $this->views_path . $id . '.php';
	}

	private function generate_setting_field( $field_name, $field ) {
		$class = '';
		$name  = 'sabox-settings[';
		if ( isset( $field['group'] ) ) {
			$name .= $field['group'] . '][' . esc_attr( $field_name ) . ']';
		} else {
			$name .= esc_attr( $field_name ) . ']';
		}
		if ( isset( $field['condition'] ) ) {
			$class = 'show_if_' . $field['condition'] . ' hide';
		}
		echo '<tr valign="top" class="' . esc_attr( $class ) . '">';
		echo '<th scope="row">';
		if ( isset( $field['description'] ) ) {
			echo '<span class="epfw-tooltip tooltip-right" data-tooltip="' . esc_html( $field['description'] ) . '"><i class="dashicons dashicons-info"></i></span>';
		}
		echo esc_html( $field['label'] );
		echo '</th>';
		echo '<td>';
		switch ( $field['type'] ) {
			case 'toggle':
				$value = isset( $this->options[ $field_name ] ) ? $this->options[ $field_name ] : '0';
				echo '<div class="checkbox_switch">';
				echo '<div class="onoffswitch">';
				echo '<input type="checkbox" id="' . esc_attr( $field_name ) . '" name="' . esc_attr( $name ) . '" class="onoffswitch-checkbox saboxfield" ' . checked( 1, $value, false ) . ' value="1">';
				echo '<label class="onoffswitch-label" for="' . esc_attr( $field_name ) . '"></label>';
				echo '</div>';
				echo '</div>';
				break;
			case 'select':
				$value = isset( $this->options[ $field_name ] ) ? $this->options[ $field_name ] : $field['default'];
				echo '<select id="' . esc_attr( $field_name ) . '" name="' . esc_attr( $name ) . '" class="saboxfield">';
				foreach ( $field['choices'] as $key => $choice ) {
					echo '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $value, false ) . '>' . esc_html( $choice ) . '</option>';
				}
				echo '</select>';
				break;
			case 'textarea':
				$value = isset( $this->options[ $field_name ] ) ? $this->options[ $field_name ] : $field['default'];
				echo '<textarea rows="3" cols="50"  id="' . esc_attr( $field_name ) . '" value="' . esc_attr( $value ) . '" name="' . esc_attr( $name ) . '" class="saboxfield">' . $value . '</textarea>';
				break;
			case 'readonly':
				echo '<textarea clas="regular-text" rows="3" cols="50" onclick="this.focus();this.select();" readonly="readonly">' . esc_attr( $field['value'] ) . '</textarea>';
				break;
			case 'slider':
				$value = isset( $this->options[ $field_name ] ) ? $this->options[ $field_name ] : $field['default'];
				echo '<div class="sabox-slider-container slider-container">';
				echo '<input type="text" id="' . esc_attr( $field_name ) . '" class="saboxfield" name="' . esc_attr( $name ) . '" data-min="' . absint( $field['choices']['min'] ) . '" data-max="' . absint( $field['choices']['max'] ) . '" data-step="' . absint( $field['choices']['increment'] ) . '" value="' . esc_attr( $value ) . 'px">';
				echo '<div class="sabox-slider"></div>';
				echo '</div>';
				break;
			case 'color':
				$value = isset( $this->options[ $field_name ] ) ? $this->options[ $field_name ] : '';
				echo '<div class="sabox-colorpicker">';
				echo '<input id="' . esc_attr( $field_name ) . '" class="saboxfield sabox-color" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
				echo '</div>';
				break;
			case 'multiplecheckbox':
				echo '<div class="sabox-multicheckbox">';
				if ( ! isset( $field['choices'] ) && isset( $field['handle'] ) && is_array( $field['handle'] ) ) {
					if ( class_exists( $field['handle'][0] ) ) {
						$class            = $field['handle'][0];
						$method           = $field['handle'][1];
						$field['choices'] = $class::$method();
					}
				}

				if ( ! isset( $field['default'] ) ) {
					$field['default'] = array_keys( $field['choices'] );
				}

				$values = isset( $this->options[ $field_name ] ) ? $this->options[ $field_name ] : $field['default'];

				if ( is_array( $values ) ) {
					$checked = $values;
				} else {
					$checked = array();
				}

				foreach ( $field['choices'] as $key => $choice ) {
					echo '<div>';
					echo '<input id="' . $key . '-' . $field_name . '" type="checkbox" value="' . $key . '" ' . checked( 1, in_array( $key, $checked ), false ) . ' name="' . esc_attr( $name ) . '[]"><label for="' . $key . '-' . $field_name . '" class="checkbox-label">' . $choice . '</label>';
					echo '</div>';
				}
				echo '</div>';
				break;
			case 'radio-group':
				echo '<div class="sabox-radio-group">';
				echo '<fieldset>';
				foreach ( $field['choices'] as $key => $choice ) {
					echo '<input type="radio" id="' . esc_attr( $field_name . '_' . $key ) . '" name="' . esc_attr( $name ) . '" class="saboxfield" ' . checked( $key, $this->options[ $field_name ], false ) . ' value="' . esc_attr( $key ) . '">';
					echo '<label for="' . esc_attr( $field_name . '_' . $key ) . '">' . esc_attr( $choice ) . '</label>';
				}
				echo '</fieldset>';
				echo '</div>';
				break;
			default:
				do_action( "sabox_field_{$field['type']}_output", $field_name, $field );
				break;
		}
		echo '</td>';
		echo '</tr>';
	}

	public function render_pro_page() {

		$features = array(
			'slider-options'   => array(
				'label'   => esc_html__( 'Typography control', 'saboxplugin' ),
				'sub'     => esc_html__( 'Control Simple Author Box\'s typography. ', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-yes"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'woocommerce'      => array(
				'label'   => esc_html__( 'Appearance control', 'saboxplugin' ),
				'sub'     => esc_html__( 'Manage the looks of your Author Box. Color controls, margins, paddings, pre-defined color layouts & more.', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-yes"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'reorder-sections' => array(
				'label'   => esc_html__( 'Visible on desired post types', 'saboxplugin' ),
				'sub'     => esc_html__( 'Select the post types where you want the author box to show up.', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'custom-colors'    => array(
				'label'   => esc_html__( 'Author name link control', 'saboxplugin' ),
				'sub'     => esc_html__( 'Control how author name links behave. Open in new tab, add nofollow parameter.', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'typography'       => array(
				'label'   => esc_html__( 'Color controls', 'saboxplugin' ),
				'sub'     => esc_html__( 'Customize the look of your author box. Make it yours!', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-yes"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),

			'features'          => array(
				'label'   => esc_html__( 'Pre-defined color schemes', 'saboxplugin' ),
				'sub'     => esc_html__( 'Easily change your author box\'s  looks with one of the included professionally designed pre-defined color schemes.', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'portfolio'         => array(
				'label'   => esc_html__( 'Author title', 'saboxplugin' ),
				'sub'     => '',
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'services'          => array(
				'label'   => esc_html__( 'Guest authors', 'saboxplugin' ),
				'sub'     => esc_html__( 'Easily assign post to guest authors. Make blogging & contributing easier.', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'team'              => array(
				'label'   => esc_html__( 'Post co-authors', 'saboxplugin' ),
				'sub'     => esc_html__( 'Working on a bigger piece with more colleagues? Get everyone\'s name listed without an issue.', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'testimonials'      => array(
				'label'   => esc_html__( 'Popular authors widget', 'saboxplugin' ),
				'sub'     => esc_html__( 'Showcase your most popular authors. Give back to the people who contribute to your blog.', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'clients'           => array(
				'label'   => esc_html__( 'Authors widget', 'saboxplugin' ),
				'sub'     => '',
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'dedicated-support' => array(
				'label'   => esc_html__( 'Dedicated Support Team', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-yes"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'security-updates'  => array(
				'label'   => esc_html__( 'Critical security updates ', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-yes"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),

			'featured-updates' => array(
				'label'   => esc_html__( 'Future feature updates ', 'saboxplugin' ),
				'sab'     => '<span class="dashicons dashicons-no-alt"></span>',
				'sab-pro' => '<span class="dashicons dashicons-yes"></span></i>',
			),
		);

		?>

        <div class="wrap about-wrap simple-author-box-wrap">
            <h1><?php echo esc_html__( 'Why you should be upgrading', 'saboxplugin' ); ?></h1>
            <p class="about-text"><?php echo esc_html__( 'Introducing one of the best author box systems ever made for WordPress. Simple Author Box is an exquisite WordPress Author Box plugin perfectly fit for any needs. We\'ve outlined the PRO features below.', 'saboxplugin' ); ?></p>
            <div class="wp-badge"></div>
            <h2 class="nav-tab-wrapper wp-clearfix">
                <a href="<?php echo admin_url( 'admin.php?page=sab-upgrade' ); ?>"
                   class="nav-tab nav-tab-active"><?php echo esc_html__( 'Comparison Table: Lite vs PRO', 'saboxplugin' ); ?></a>
            </h2>
            <div class="featured-section features">
                <table class="free-pro-table">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?php _e( 'Free', 'saboxplugin' ); ?></th>
                        <th><?php _e( 'PRO', 'saboxplugin' ); ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ( $features as $feature ) : ?>
                        <tr>
                            <td class="feature">
                                <h3><?php echo $feature['label']; ?></h3>
								<?php if ( isset( $feature['sub'] ) ) : ?>
                                    <p><?php echo $feature['sub']; ?></p>
								<?php endif ?>
                            </td>
                            <td class="sab-feature">
								<?php echo $feature['sab']; ?>
                            </td>
                            <td class="sab-pro-feature">
								<?php echo $feature['sab-pro']; ?>
                            </td>
                        </tr>
					<?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td colspan="2" class="text-right">
                            <a href="//www.machothemes.com/plugin/simple-author-box-pro?utm_source=sab&utm_medium=about-page&utm_campaign=upsell"
                               target="_blank" class="button button-primary button-hero">
                                <span class="dashicons dashicons-cart"></span>
								<?php _e( 'Get The Pro Version Now!', 'saboxplugin' ); ?>
                            </a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
		<?php
	}
}
