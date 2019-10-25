<?php

/**
 *
 */
class Simple_Author_Box_Helper {

	public static $fonts = array();
	public static $options = array();

	public static $social_icons = array(
		'addthis'       => 'Add This',
		'behance'       => 'Behance',
		'delicious'     => 'Delicious',
		'deviantart'    => 'Deviantart',
		'digg'          => 'Digg',
		'dribbble'      => 'Dribbble',
		'facebook'      => 'Facebook',
		'whatsapp'      => 'WhatsApp',
		'flickr'        => 'Flickr',
		'github'        => 'Github',
		'google'        => 'Google',
		'googleplus'    => 'Google Plus',
		'html5'         => 'Html5',
		'instagram'     => 'Instagram',
		'linkedin'      => 'Linkedin',
		'pinterest'     => 'Pinterest',
		'reddit'        => 'Reddit',
		'rss'           => 'Rss',
		'sharethis'     => 'Sharethis',
		'skype'         => 'Skype',
		'soundcloud'    => 'Soundcloud',
		'spotify'       => 'Spotify',
		'stackoverflow' => 'Stackoverflow',
		'steam'         => 'Steam',
		'stumbleUpon'   => 'StumbleUpon',
		'tumblr'        => 'Tumblr',
		'twitter'       => 'Twitter',
		'vimeo'         => 'Vimeo',
		'windows'       => 'Windows',
		'wordpress'     => 'WordPress',
		'yahoo'         => 'Yahoo',
		'youtube'       => 'Youtube',
		'xing'          => 'Xing',
		'mixcloud'      => 'MixCloud',
		'goodreads'     => 'Goodreads',
		'twitch'        => 'Twitch',
		'vk'            => 'VK',
		'medium'        => 'Medium',
		'quora'         => 'Quora',
		'meetup'        => 'Meetup',
		'user_email'    => 'Email',
		'snapchat'      => 'Snapchat',
		'500px'         => '500px',
		'mastodont'     => 'Mastodon',
		'telegram'      => 'Telegram',
	);

	public static function get_sabox_social_icon( $url, $icon_name ) {

		$options = self::get_option( 'saboxplugin_options' );

		if ( '0' != $options['sab_link_target'] && 'user_email' != $icon_name ) {
			$sabox_blank = '_blank';
		} else {
			$sabox_blank = '_self';
		}

		if ( '1' == $options['sab_colored'] ) {
			$sab_color = 'saboxplugin-icon-color';
		} else {
			$sab_color = 'saboxplugin-icon-grey';
		}

		$type = 'simple';
		if ( '1' == $options['sab_colored'] ) {
			if ( '1' == $options['sab_icons_style'] ) {
				$type = 'circle';
			}else{
				$type = 'square';
			}
		}

		$url = ('skype' != $icon_name) ? esc_url($url) : esc_attr($url);

		$svg_icon = Simple_Author_Box_Social::icon_to_svg( $icon_name, $type );
		return '<a target="' . esc_attr( $sabox_blank ) . '" href="' .  $url . '" rel="nofollow" class="' . esc_attr( $sab_color ) . '">' . $svg_icon . '</span></a>';

	}

	public static function get_user_social_links( $userd_id, $show_email = false ) {

		$social_icons = apply_filters( 'sabox_social_icons', Simple_Author_Box_Helper::$social_icons );
		$social_links = get_user_meta( $userd_id, 'sabox_social_links', true );

		if ( ! is_array( $social_links ) ) {
			$social_links = array();
		}

		if ( $show_email ) {
			$social_links['user_email'] = get_the_author_meta( 'user_email', $userd_id );
		}

		return $social_links;

	}

	public static function get_google_font_subsets() {
		return array(
			'none'         => 'None',
			'latin'        => 'Latin',
			'latin-ext'    => 'Latin Extended',
			'cyrillic'     => 'Cyrillic',
			'cyrillic-ext' => 'Cyrillic Extended',
			'devanagari'   => 'Devanagari',
			'greek'        => 'Greek',
			'greek-ext'    => 'Greek Extended',
			'vietnamese'   => 'Vietnamese',
			'khmer'        => 'Khmer',
		);
	}

	public static function get_google_fonts() {
		$fonts = array(
			'None',
			'ABeeZee',
			'Abel',
			'Abril Fatface',
			'Aclonica',
			'Acme',
			'Actor',
			'Adamina',
			'Advent Pro',
			'Aguafina Script',
			'Akronim',
			'Aladin',
			'Aldrich',
			'Alef',
			'Alegreya',
			'Alegreya SC',
			'Alegreya Sans',
			'Alegreya Sans SC',
			'Alex Brush',
			'Alfa Slab One',
			'Alice',
			'Alike',
			'Alike Angular',
			'Allan',
			'Allerta',
			'Allerta Stencil',
			'Allura',
			'Almendra',
			'Almendra Display',
			'Almendra SC',
			'Amarante',
			'Amaranth',
			'Amatic SC',
			'Amethysta',
			'Anaheim',
			'Andada',
			'Andika',
			'Angkor',
			'Annie Use Your Telescope',
			'Anonymous Pro',
			'Antic',
			'Antic Didone',
			'Antic Slab',
			'Anton',
			'Arapey',
			'Arbutus',
			'Arbutus Slab',
			'Architects Daughter',
			'Archivo Black',
			'Archivo Narrow',
			'Arimo',
			'Arizonia',
			'Armata',
			'Artifika',
			'Arvo',
			'Asap',
			'Asset',
			'Astloch',
			'Asul',
			'Atomic Age',
			'Aubrey',
			'Audiowide',
			'Autour One',
			'Average',
			'Average Sans',
			'Averia Gruesa Libre',
			'Averia Libre',
			'Averia Sans Libre',
			'Averia Serif Libre',
			'Bad Script',
			'Balthazar',
			'Bangers',
			'Basic',
			'Battambang',
			'Baumans',
			'Bayon',
			'Belgrano',
			'Belleza',
			'BenchNine',
			'Bentham',
			'Berkshire Swash',
			'Bevan',
			'Bigelow Rules',
			'Bigshot One',
			'Bilbo',
			'Bilbo Swash Caps',
			'Bitter',
			'Black Ops One',
			'Bokor',
			'Bonbon',
			'Boogaloo',
			'Bowlby One',
			'Bowlby One SC',
			'Brawler',
			'Bree Serif',
			'Bubblegum Sans',
			'Bubbler One',
			'Buda',
			'Buenard',
			'Butcherman',
			'Butterfly Kids',
			'Cabin',
			'Cabin Condensed',
			'Cabin Sketch',
			'Caesar Dressing',
			'Cagliostro',
			'Calligraffitti',
			'Cambo',
			'Candal',
			'Cantarell',
			'Cantata One',
			'Cantora One',
			'Capriola',
			'Cardo',
			'Carme',
			'Carrois Gothic',
			'Carrois Gothic SC',
			'Carter One',
			'Caudex',
			'Cedarville Cursive',
			'Ceviche One',
			'Changa One',
			'Chango',
			'Chau Philomene One',
			'Chela One',
			'Chelsea Market',
			'Chenla',
			'Cherry Cream Soda',
			'Cherry Swash',
			'Chewy',
			'Chicle',
			'Chivo',
			'Cinzel',
			'Cinzel Decorative',
			'Clicker Script',
			'Coda',
			'Coda Caption',
			'Codystar',
			'Combo',
			'Comfortaa',
			'Coming Soon',
			'Concert One',
			'Condiment',
			'Content',
			'Contrail One',
			'Convergence',
			'Cookie',
			'Copse',
			'Corben',
			'Courgette',
			'Cousine',
			'Coustard',
			'Covered By Your Grace',
			'Crafty Girls',
			'Creepster',
			'Crete Round',
			'Crimson Text',
			'Croissant One',
			'Crushed',
			'Cuprum',
			'Cutive',
			'Cutive Mono',
			'Damion',
			'Dancing Script',
			'Dangrek',
			'Dawning of a New Day',
			'Days One',
			'Delius',
			'Delius Swash Caps',
			'Delius Unicase',
			'Della Respira',
			'Denk One',
			'Devonshire',
			'Didact Gothic',
			'Diplomata',
			'Diplomata SC',
			'Domine',
			'Donegal One',
			'Doppio One',
			'Dorsa',
			'Dosis',
			'Dr Sugiyama',
			'Droid Sans',
			'Droid Sans Mono',
			'Droid Serif',
			'Duru Sans',
			'Dynalight',
			'EB Garamond',
			'Eagle Lake',
			'Eater',
			'Economica',
			'Ek Mukta',
			'Electrolize',
			'Elsie',
			'Elsie Swash Caps',
			'Emblema One',
			'Emilys Candy',
			'Engagement',
			'Englebert',
			'Enriqueta',
			'Erica One',
			'Esteban',
			'Euphoria Script',
			'Ewert',
			'Exo',
			'Exo 2',
			'Expletus Sans',
			'Fanwood Text',
			'Fascinate',
			'Fascinate Inline',
			'Faster One',
			'Fasthand',
			'Fauna One',
			'Federant',
			'Federo',
			'Felipa',
			'Fenix',
			'Finger Paint',
			'Fira Mono',
			'Fira Sans',
			'Fjalla One',
			'Fjord One',
			'Flamenco',
			'Flavors',
			'Fondamento',
			'Fontdiner Swanky',
			'Forum',
			'Francois One',
			'Freckle Face',
			'Fredericka the Great',
			'Fredoka One',
			'Freehand',
			'Fresca',
			'Frijole',
			'Fruktur',
			'Fugaz One',
			'GFS Didot',
			'GFS Neohellenic',
			'Gabriela',
			'Gafata',
			'Galdeano',
			'Galindo',
			'Gentium Basic',
			'Gentium Book Basic',
			'Geo',
			'Geostar',
			'Geostar Fill',
			'Germania One',
			'Gilda Display',
			'Give You Glory',
			'Glass Antiqua',
			'Glegoo',
			'Gloria Hallelujah',
			'Goblin One',
			'Gochi Hand',
			'Gorditas',
			'Goudy Bookletter 1911',
			'Graduate',
			'Grand Hotel',
			'Gravitas One',
			'Great Vibes',
			'Griffy',
			'Gruppo',
			'Gudea',
			'Habibi',
			'Hammersmith One',
			'Hanalei',
			'Hanalei Fill',
			'Handlee',
			'Hanuman',
			'Happy Monkey',
			'Headland One',
			'Henny Penny',
			'Herr Von Muellerhoff',
			'Hind',
			'Holtwood One SC',
			'Homemade Apple',
			'Homenaje',
			'IM Fell DW Pica',
			'IM Fell DW Pica SC',
			'IM Fell Double Pica',
			'IM Fell Double Pica SC',
			'IM Fell English',
			'IM Fell English SC',
			'IM Fell French Canon',
			'IM Fell French Canon SC',
			'IM Fell Great Primer',
			'IM Fell Great Primer SC',
			'Iceberg',
			'Iceland',
			'Imprima',
			'Inconsolata',
			'Inder',
			'Indie Flower',
			'Inika',
			'Irish Grover',
			'Istok Web',
			'Italiana',
			'Italianno',
			'Jacques Francois',
			'Jacques Francois Shadow',
			'Jim Nightshade',
			'Jockey One',
			'Jolly Lodger',
			'Josefin Sans',
			'Josefin Slab',
			'Joti One',
			'Judson',
			'Julee',
			'Julius Sans One',
			'Junge',
			'Jura',
			'Just Another Hand',
			'Just Me Again Down Here',
			'Kalam',
			'Kameron',
			'Kantumruy',
			'Karla',
			'Karma',
			'Kaushan Script',
			'Kavoon',
			'Kdam Thmor',
			'Keania One',
			'Kelly Slab',
			'Kenia',
			'Khmer',
			'Kite One',
			'Knewave',
			'Kotta One',
			'Koulen',
			'Kranky',
			'Kreon',
			'Kristi',
			'Krona One',
			'La Belle Aurore',
			'Lancelot',
			'Lato',
			'League Script',
			'Leckerli One',
			'Ledger',
			'Lekton',
			'Lemon',
			'Libre Baskerville',
			'Life Savers',
			'Lilita One',
			'Lily Script One',
			'Limelight',
			'Linden Hill',
			'Lobster',
			'Lobster Two',
			'Londrina Outline',
			'Londrina Shadow',
			'Londrina Sketch',
			'Londrina Solid',
			'Lora',
			'Love Ya Like A Sister',
			'Loved by the King',
			'Lovers Quarrel',
			'Luckiest Guy',
			'Lusitana',
			'Lustria',
			'Macondo',
			'Macondo Swash Caps',
			'Magra',
			'Maiden Orange',
			'Mako',
			'Marcellus',
			'Marcellus SC',
			'Marck Script',
			'Margarine',
			'Marko One',
			'Marmelad',
			'Marvel',
			'Mate',
			'Mate SC',
			'Maven Pro',
			'McLaren',
			'Meddon',
			'MedievalSharp',
			'Medula One',
			'Megrim',
			'Meie Script',
			'Merienda',
			'Merienda One',
			'Merriweather',
			'Merriweather Sans',
			'Metal',
			'Metal Mania',
			'Metamorphous',
			'Metrophobic',
			'Michroma',
			'Milonga',
			'Miltonian',
			'Miltonian Tattoo',
			'Miniver',
			'Miss Fajardose',
			'Modern Antiqua',
			'Molengo',
			'Molle',
			'Monda',
			'Monofett',
			'Monoton',
			'Monsieur La Doulaise',
			'Montaga',
			'Montez',
			'Montserrat',
			'Montserrat Alternates',
			'Montserrat Subrayada',
			'Moul',
			'Moulpali',
			'Mountains of Christmas',
			'Mouse Memoirs',
			'Mr Bedfort',
			'Mr Dafoe',
			'Mr De Haviland',
			'Mrs Saint Delafield',
			'Mrs Sheppards',
			'Muli',
			'Mystery Quest',
			'Neucha',
			'Neuton',
			'New Rocker',
			'News Cycle',
			'Niconne',
			'Nixie One',
			'Nobile',
			'Nokora',
			'Norican',
			'Nosifer',
			'Nothing You Could Do',
			'Noticia Text',
			'Noto Sans',
			'Noto Serif',
			'Nova Cut',
			'Nova Flat',
			'Nova Mono',
			'Nova Oval',
			'Nova Round',
			'Nova Script',
			'Nova Slim',
			'Nova Square',
			'Numans',
			'Nunito',
			'Odor Mean Chey',
			'Offside',
			'Old Standard TT',
			'Oldenburg',
			'Oleo Script',
			'Oleo Script Swash Caps',
			'Open Sans',
			'Open Sans Condensed',
			'Oranienbaum',
			'Orbitron',
			'Oregano',
			'Orienta',
			'Original Surfer',
			'Oswald',
			'Over the Rainbow',
			'Overlock',
			'Overlock SC',
			'Ovo',
			'Oxygen',
			'Oxygen Mono',
			'PT Mono',
			'PT Sans',
			'PT Sans Caption',
			'PT Sans Narrow',
			'PT Serif',
			'PT Serif Caption',
			'Pacifico',
			'Paprika',
			'Parisienne',
			'Passero One',
			'Passion One',
			'Pathway Gothic One',
			'Patrick Hand',
			'Patrick Hand SC',
			'Patua One',
			'Paytone One',
			'Peralta',
			'Permanent Marker',
			'Petit Formal Script',
			'Petrona',
			'Philosopher',
			'Piedra',
			'Pinyon Script',
			'Pirata One',
			'Plaster',
			'Play',
			'Playball',
			'Playfair Display',
			'Playfair Display SC',
			'Podkova',
			'Poiret One',
			'Poller One',
			'Poly',
			'Pompiere',
			'Pontano Sans',
			'Port Lligat Sans',
			'Port Lligat Slab',
			'Prata',
			'Preahvihear',
			'Press Start 2P',
			'Princess Sofia',
			'Prociono',
			'Prosto One',
			'Puritan',
			'Purple Purse',
			'Quando',
			'Quantico',
			'Quattrocento',
			'Quattrocento Sans',
			'Questrial',
			'Quicksand',
			'Quintessential',
			'Qwigley',
			'Racing Sans One',
			'Radley',
			'Rajdhani',
			'Raleway',
			'Raleway Dots',
			'Rambla',
			'Rammetto One',
			'Ranchers',
			'Rancho',
			'Rationale',
			'Redressed',
			'Reenie Beanie',
			'Revalia',
			'Ribeye',
			'Ribeye Marrow',
			'Righteous',
			'Risque',
			'Roboto',
			'Roboto Condensed',
			'Roboto Slab',
			'Rochester',
			'Rock Salt',
			'Rokkitt',
			'Romanesco',
			'Ropa Sans',
			'Rosario',
			'Rosarivo',
			'Rouge Script',
			'Rubik Mono One',
			'Rubik One',
			'Ruda',
			'Rufina',
			'Ruge Boogie',
			'Ruluko',
			'Rum Raisin',
			'Ruslan Display',
			'Russo One',
			'Ruthie',
			'Rye',
			'Sacramento',
			'Sail',
			'Salsa',
			'Sanchez',
			'Sancreek',
			'Sansita One',
			'Sarina',
			'Satisfy',
			'Scada',
			'Schoolbell',
			'Seaweed Script',
			'Sevillana',
			'Seymour One',
			'Shadows Into Light',
			'Shadows Into Light Two',
			'Shanti',
			'Share',
			'Share Tech',
			'Share Tech Mono',
			'Shojumaru',
			'Short Stack',
			'Siemreap',
			'Sigmar One',
			'Signika',
			'Signika Negative',
			'Simonetta',
			'Sintony',
			'Sirin Stencil',
			'Six Caps',
			'Skranji',
			'Slabo 13px',
			'Slabo 27px',
			'Slackey',
			'Smokum',
			'Smythe',
			'Sniglet',
			'Snippet',
			'Snowburst One',
			'Sofadi One',
			'Sofia',
			'Sonsie One',
			'Sorts Mill Goudy',
			'Source Code Pro',
			'Source Sans Pro',
			'Source Serif Pro',
			'Special Elite',
			'Spicy Rice',
			'Spinnaker',
			'Spirax',
			'Squada One',
			'Stalemate',
			'Stalinist One',
			'Stardos Stencil',
			'Stint Ultra Condensed',
			'Stint Ultra Expanded',
			'Stoke',
			'Strait',
			'Sue Ellen Francisco',
			'Sunshiney',
			'Supermercado One',
			'Suwannaphum',
			'Swanky and Moo Moo',
			'Syncopate',
			'Tangerine',
			'Taprom',
			'Tauri',
			'Teko',
			'Telex',
			'Tenor Sans',
			'Text Me One',
			'The Girl Next Door',
			'Tienne',
			'Tinos',
			'Titan One',
			'Titillium Web',
			'Trade Winds',
			'Trocchi',
			'Trochut',
			'Trykker',
			'Tulpen One',
			'Ubuntu',
			'Ubuntu Condensed',
			'Ubuntu Mono',
			'Ultra',
			'Uncial Antiqua',
			'Underdog',
			'Unica One',
			'UnifrakturCook',
			'UnifrakturMaguntia',
			'Unkempt',
			'Unlock',
			'Unna',
			'VT323',
			'Vampiro One',
			'Varela',
			'Varela Round',
			'Vast Shadow',
			'Vibur',
			'Vidaloka',
			'Viga',
			'Voces',
			'Volkhov',
			'Vollkorn',
			'Voltaire',
			'Waiting for the Sunrise',
			'Wallpoet',
			'Walter Turncoat',
			'Warnes',
			'Wellfleet',
			'Wendy One',
			'Wire One',
			'Yanone Kaffeesatz',
			'Yellowtail',
			'Yeseva One',
			'Yesteryear',
			'Zeyada',
		);

		if ( empty( Simple_Author_Box_Helper::$fonts ) ) {
			foreach ( $fonts as $font ) {
				Simple_Author_Box_Helper::$fonts[ $font ] = $font;
			}
		}

		return Simple_Author_Box_Helper::$fonts;

	}

	public static function get_custom_post_type() {
		$post_types = get_post_types(
			array(
				'publicly_queryable' => true,
				'_builtin'           => false,
			)
		);

		$post_types['post'] = __( 'Post', 'saboxplugin' );
		$post_types['page'] = __( 'Page', 'saboxplugin' );

		return $post_types;
	}

	public static function get_template( $template_name = 'template-sab.php' ) {

		$template = '';

		if ( ! $template ) {
			$template = locate_template( array( 'sab/' . $template_name ) );
		}

		if ( ! $template && file_exists( SIMPLE_AUTHOR_BOX_PATH . 'template/' . $template_name ) ) {
			$template = SIMPLE_AUTHOR_BOX_PATH . 'template/' . $template_name;
		}

		if ( ! $template ) {
			$template = SIMPLE_AUTHOR_BOX_PATH . 'template/template-sab.php';
		}

		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters( 'sabox_get_template_part', $template, $template_name );
		if ( $template ) {
			return $template;
		}

	}

	public static function reset_options() {
		self::$options = array();
	}

	public static function get_option( $key, $force = false ) {

		$defaults = apply_filters( 'sab_box_options_defaults', array(
			'saboxplugin_options' => array(
		        'sab_autoinsert'         => '0',
		        'sab_no_description'     => '0',
		        'sab_email'              => '0',
		        'sab_link_target'        => '0',
		        'sab_hide_socials'       => '0',
		        'sab_hide_on_archive'    => '0',
		        'sab_box_border_width'   => '1',
		        'sab_avatar_style'       => '0',
		        'sab_avatar_hover'       => '0',
		        'sab_web'                => '0',
		        'sab_web_target'         => '0',
		        'sab_web_rel'            => '0',
		        'sab_web_position'       => '0',
		        'sab_colored'            => '0',
		        'sab_icons_style'        => '0',
		        'sab_social_hover'       => '0',
		        'sab_box_long_shadow'    => '0',
		        'sab_box_thin_border'    => '0',
		        'sab_box_author_color'   => '0',
		        'sab_box_web_color'      => '0',
		        'sab_box_border'         => '',
		        'sab_box_icons_back'     => '',
		        'sab_box_author_back'    => '',
		        'sab_box_author_p_color' => '',
		        'sab_box_author_a_color' => '0',
		        'sab_box_icons_color'    => '0',
                'sab_footer_inline_style' => '0',
		    ),
		    'sab_box_margin_top'         => '0',
		    'sab_box_margin_bottom'      => '0',
		    'sab_box_padding_top_bottom' => '0',
		    'sab_box_padding_left_right' => '0',
		    'sab_box_subset'             => 'none',
		    'sab_box_name_font'          => 'None',
		    'sab_box_web_font'           => 'None',
		    'sab_box_desc_font'          => 'None',
		    'sab_box_name_size'          => '18',
		    'sab_box_web_size'           => '14',
		    'sab_box_desc_size'          => '14',
		    'sab_box_icon_size'          => '18',
		    'sab_desc_style'             => '0',
		    
		) );

		if ( 'saboxplugin_options' == $key ) {

			if ( ! isset( self::$options['saboxplugin_options'] ) ) {
				self::$options['saboxplugin_options'] = get_option( 'saboxplugin_options', array() );
			}

			return wp_parse_args( self::$options['saboxplugin_options'], $defaults['saboxplugin_options'] );

		} else {

			if ( isset( self::$options[ $key ] ) ) {

				return self::$options[ $key ];

			}else{

				$option = get_option( $key, false );
				if ( false === $option && isset( $defaults[ $key ] ) ) {
					return $defaults[ $key ];
				} elseif ( false !== $option ) {
					self::$options[ $key ] = $option;
					return self::$options[ $key ];
				}

			}

		}

		return false;

	}

	public static function generate_inline_css() {

		$padding_top_bottom  = self::get_option( 'sab_box_padding_top_bottom' );
		$padding_left_right  = self::get_option( 'sab_box_padding_left_right' );
		$sabox_top_margin    = self::get_option( 'sab_box_margin_top' );
		$sabox_bottom_margin = self::get_option( 'sab_box_margin_bottom' );
		$sabox_name_size     = self::get_option( 'sab_box_name_size' );
		$sabox_desc_size     = self::get_option( 'sab_box_desc_size' );
		$sabox_icon_size     = self::get_option( 'sab_box_icon_size' );
		$sabox_options       = self::get_option( 'saboxplugin_options' );
		$sabox_web_size      = self::get_option( 'sab_box_web_size' );

		$style = '.saboxplugin-wrap{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;box-sizing:border-box;border:1px solid #eee;width:100%;clear:both;display:block;overflow:hidden;word-wrap:break-word;position:relative}.saboxplugin-wrap .saboxplugin-gravatar{float:left;padding:20px}.saboxplugin-wrap .saboxplugin-gravatar img{max-width:100px;height:auto;border-radius:0;}.saboxplugin-wrap .saboxplugin-authorname{font-size:18px;line-height:1;margin:20px 0 0 20px;display:block}.saboxplugin-wrap .saboxplugin-authorname a{text-decoration:none}.saboxplugin-wrap .saboxplugin-authorname a:focus{outline:0}.saboxplugin-wrap .saboxplugin-desc{display:block;margin:5px 20px}.saboxplugin-wrap .saboxplugin-desc a{text-decoration:underline}.saboxplugin-wrap .saboxplugin-desc p{margin:5px 0 12px}.saboxplugin-wrap .saboxplugin-web{margin:0 20px 15px;text-align:left}.saboxplugin-wrap .sab-web-position{text-align:right}.saboxplugin-wrap .saboxplugin-web a{color:#ccc;text-decoration:none}.saboxplugin-wrap .saboxplugin-socials{position:relative;display:block;background:#fcfcfc;padding:5px;border-top:1px solid #eee}.saboxplugin-wrap .saboxplugin-socials a svg{width:20px;height:20px}.saboxplugin-wrap .saboxplugin-socials a svg .st2{fill:#fff}.saboxplugin-wrap .saboxplugin-socials a svg .st1{fill:rgba(0,0,0,.3)}.saboxplugin-wrap .saboxplugin-socials a:hover{opacity:.8;-webkit-transition:opacity .4s;-moz-transition:opacity .4s;-o-transition:opacity .4s;transition:opacity .4s;box-shadow:none!important;-webkit-box-shadow:none!important}.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color{box-shadow:none;padding:0;border:0;-webkit-transition:opacity .4s;-moz-transition:opacity .4s;-o-transition:opacity .4s;transition:opacity .4s;display:inline-block;color:#fff;font-size:0;text-decoration:inherit;margin:5px;-webkit-border-radius:0;-moz-border-radius:0;-ms-border-radius:0;-o-border-radius:0;border-radius:0;overflow:hidden}.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey{text-decoration:inherit;box-shadow:none;position:relative;display:-moz-inline-stack;display:inline-block;vertical-align:middle;zoom:1;margin:10px 5px;color:#444}.clearfix:after,.clearfix:before{content:\' \';display:table;line-height:0;clear:both}.ie7 .clearfix{zoom:1}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-twitch{border-color:#38245c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-addthis{border-color:#e91c00}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-behance{border-color:#003eb0}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-delicious{border-color:#06c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-deviantart{border-color:#036824}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-digg{border-color:#00327c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-dribbble{border-color:#ba1655}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-facebook{border-color:#1e2e4f}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-flickr{border-color:#003576}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-github{border-color:#264874}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-google{border-color:#0b51c5}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-googleplus{border-color:#96271a}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-html5{border-color:#902e13}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-instagram{border-color:#1630aa}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-linkedin{border-color:#00344f}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-pinterest{border-color:#5b040e}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-reddit{border-color:#992900}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-rss{border-color:#a43b0a}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-sharethis{border-color:#5d8420}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-skype{border-color:#00658a}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-soundcloud{border-color:#995200}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-spotify{border-color:#0f612c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-stackoverflow{border-color:#a95009}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-steam{border-color:#006388}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-user_email{border-color:#b84e05}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-stumbleUpon{border-color:#9b280e}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-tumblr{border-color:#10151b}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-twitter{border-color:#0967a0}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-vimeo{border-color:#0d7091}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-windows{border-color:#003f71}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-whatsapp{border-color:#003f71}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-wordpress{border-color:#0f3647}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-yahoo{border-color:#14002d}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-youtube{border-color:#900}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-xing{border-color:#000202}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-mixcloud{border-color:#2475a0}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-vk{border-color:#243549}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-medium{border-color:#00452c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-quora{border-color:#420e00}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-meetup{border-color:#9b181c}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-goodreads{border-color:#000}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-snapchat{border-color:#999700}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-500px{border-color:#00557f}.saboxplugin-socials.sabox-colored .saboxplugin-icon-color .sab-mastodont{border-color:#185886}.sabox-plus-item{margin-bottom:20px}@media screen and (max-width:480px){.saboxplugin-wrap{text-align:center}.saboxplugin-wrap .saboxplugin-gravatar{float:none;padding:20px 0;text-align:center;margin:0 auto;display:block}.saboxplugin-wrap .saboxplugin-gravatar img{float:none;display:inline-block;display:-moz-inline-stack;vertical-align:middle;zoom:1}.saboxplugin-wrap .saboxplugin-desc{margin:0 10px 20px;text-align:center}.saboxplugin-wrap .saboxplugin-authorname{text-align:center;margin:10px 0 20px}}body .saboxplugin-authorname a,body .saboxplugin-authorname a:hover{box-shadow:none;-webkit-box-shadow:none}a.sab-profile-edit{font-size:16px!important;line-height:1!important}.sab-edit-settings a,a.sab-profile-edit{color:#0073aa!important;box-shadow:none!important;-webkit-box-shadow:none!important}.sab-edit-settings{margin-right:15px;position:absolute;right:0;z-index:2;bottom:10px;line-height:20px}.sab-edit-settings i{margin-left:5px}.saboxplugin-socials{line-height:1!important}.rtl .saboxplugin-wrap .saboxplugin-gravatar{float:right}.rtl .saboxplugin-wrap .saboxplugin-authorname{display:flex;align-items:center}.rtl .saboxplugin-wrap .saboxplugin-authorname .sab-profile-edit{margin-right:10px}.rtl .sab-edit-settings{right:auto;left:0}img.sab-custom-avatar{max-width:75px;}';

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
		if ( '0' != $sabox_options['sab_avatar_style'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-gravatar img {-webkit-border-radius:50%;-moz-border-radius:50%;-ms-border-radius:50%;-o-border-radius:50%;border-radius:50%;}';
		}
		// Social icons style
		if ( '0' != $sabox_options['sab_colored'] && '0' != $sabox_options['sab_icons_style'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color {-webkit-border-radius:50%;-moz-border-radius:50%;-ms-border-radius:50%;-o-border-radius:50%;border-radius:50%;}';
		}
		// Long Shadow
		if ( '1' == $sabox_options['sab_colored'] && '1' != $sabox_options['sab_box_long_shadow'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color .st1 {display: none;}';
		}
		// Avatar hover effect
		if ( '0' != $sabox_options['sab_avatar_style'] && '1' == $sabox_options['sab_avatar_hover'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-gravatar img {-webkit-transition:all .5s ease;-moz-transition:all .5s ease;-o-transition:all .5s ease;transition:all .5s ease;}';
			$style .= '.saboxplugin-wrap .saboxplugin-gravatar img:hover {-webkit-transform:rotate(45deg);-moz-transform:rotate(45deg);-o-transform:rotate(45deg);-ms-transform:rotate(45deg);transform:rotate(45deg);}';
		}
		// Social icons hover effect
		if ( '1' == $sabox_options['sab_icons_style'] && '1' == $sabox_options['sab_social_hover'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color {-webkit-transition: all 0.3s ease-in-out;-moz-transition: all 0.3s ease-in-out;-o-transition: all 0.3s ease-in-out;-ms-transition: all 0.3s ease-in-out;transition: all 0.3s ease-in-out;}.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color:hover,.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey:hover {-webkit-transform: rotate(360deg);-moz-transform: rotate(360deg);-o-transform: rotate(360deg);-ms-transform: rotate(360deg);transform: rotate(360deg);}';
		}
		// Thin border
		if ( '1' == $sabox_options['sab_colored'] && '1' == $sabox_options['sab_box_thin_border'] ) {
			$css = 'border-width: 1px;border-style:solid;';
			if ( '1' == $sabox_options['sab_icons_style'] ) {
				$css .= 'border-radius:50%';
			}
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color svg {' . $css . '}';
		}
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
			$style .= '.saboxplugin-wrap .saboxplugin-desc p, .saboxplugin-wrap .saboxplugin-desc  {color:' . esc_html( $sabox_options['sab_box_author_p_color'] ) . ' !important;}';
		}
		// Color of author box paragraphs
		if ( '' != $sabox_options['sab_box_author_a_color'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-desc a, .saboxplugin-wrap .saboxplugin-desc  {color:' . esc_html( $sabox_options['sab_box_author_a_color'] ) . ' !important;}';
		}
		// Color of social icons (for symbols only):
		if ( '' != $sabox_options['sab_box_icons_color'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey {color:' . esc_html( $sabox_options['sab_box_icons_color'] ) . ';}';
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
		$sab_box_name_font = self::get_option( 'sab_box_name_font' );
		if ( 'None' != $sab_box_name_font ) {
			$style           .= '.saboxplugin-wrap .saboxplugin-authorname {font-family:"' . esc_html( $sab_box_name_font ) . '";}';
		}

		// Author description font family
		$sab_box_desc_font = self::get_option( 'sab_box_desc_font' );
		if ( 'None' != $sab_box_name_font ) {
			$style           .= '.saboxplugin-wrap .saboxplugin-desc {font-family:' . esc_html( $sab_box_desc_font ) . ';}';
		}

		// Author web font family
		$sab_box_web_font = self::get_option( 'sab_box_web_font' );
		if ( '1' == $sabox_options['sab_web'] && 'None' != $sab_box_web_font ) {
			$style          .= '.saboxplugin-wrap .saboxplugin-web {font-family:"' . esc_html( $sab_box_web_font ) . '";}';
		}

		// Author description font style
		if ( isset( $sabox_options['sab_desc_style'] ) && '1' == $sabox_options['sab_desc_style'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-desc {font-style:italic;}';
		}
		// Margin top & bottom, Padding
		$style .= '.saboxplugin-wrap {margin-top:' . absint( $sabox_top_margin ) . 'px; margin-bottom:' . absint( $sabox_bottom_margin ) . 'px; padding: ' . absint( $padding_top_bottom ) . 'px ' . absint( $padding_left_right ) . 'px }';
		// Author name text size
		$style .= '.saboxplugin-wrap .saboxplugin-authorname {font-size:' . absint( $sabox_name_size ) . 'px; line-height:' . absint( $sabox_name_size + 7 ) . 'px;}';
		// Author description font size
		$style .= '.saboxplugin-wrap .saboxplugin-desc p, .saboxplugin-wrap .saboxplugin-desc {font-size:' . absint( $sabox_desc_size ) . 'px !important; line-height:' . absint( $sabox_desc_size + 7 ) . 'px !important;}';
		// Author website text size
		$style .= '.saboxplugin-wrap .saboxplugin-web {font-size:' . absint( $sabox_web_size ) . 'px;}';
		// Icons size
		$icon_size = absint( $sabox_icon_size );
		if ( '1' == $sabox_options['sab_colored'] ) {
			$icon_size = $icon_size * 2;
		}
		$style .= '.saboxplugin-wrap .saboxplugin-socials a svg {width:' . absint( $icon_size ) . 'px;height:' . absint( $icon_size ) . 'px;}';

		return apply_filters( 'sabox_inline_css', $style );
	}
}