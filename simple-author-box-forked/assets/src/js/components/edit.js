/**
 * Internal dependencies
 */
import Inspector from './inspector';
import SAB_Social_Icon from '../utils/social-icon';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { Spinner } = wp.components;

/**
 * Block edit function
 */
export default class Edit extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	renderSocialIcon( url, iconName ) {

		let sabColor;

	 	if ( '1' == sabVars.sab_colored ) {
			sabColor = 'saboxplugin-icon-color';
		} else {
			sabColor = 'saboxplugin-icon-grey';
		}

		let type = 'simple';
		if ( '1' == sabVars.sab_colored ) {
			if ( '1' == sabVars.sab_icons_style ) {
				type = 'circle';
			} else {
				type = 'square';
			}
		}

		let social_icon = new SAB_Social_Icon();

		return [
			<a href={ url } target="_blank" class={ sabColor }>
				{ social_icon.icon_to_svg( iconName, type ) }
			</a>
		];

	}

	changeAuthor( authorID ) {
		jQuery.ajax({
			type: "POST",
			data : { action: "sab_get_author", author_ID: authorID, nonce: sabVars.nonce },
			url : sabVars.ajaxURL,
			success: ( result ) => {

				if( result.success == false ) {
					this.props.setAttributes( {
						status: 'error',
					} );
					return;
				}

				let author = JSON.parse(result);

				this.props.setAttributes( {
					authorID: author.ID,
					avatar: author.avatar,
					profile_image: author['sabox-profile-image'],
					display_name: author.data.display_name,
					description: author.description,
					user_url: author.data.user_url,
					social_links: author.sabox_social_links,
					status: 'ready'
				} );
			}
		});
	}

	generateInlineCSS() {
		let css = '';

		// Border color of Simple Author Box
		if ( '' != sabVars.sab_box_border ) {
			css += '.saboxplugin-wrap {border-color:' + sabVars.sab_box_border + ';}';
			css += '.saboxplugin-wrap .saboxplugin-socials {border-color:' + sabVars.sab_box_border + ';}';
		}
		// Border width of Simple Author Box
		if ( '1' != sabVars.sab_box_border_width ) {
			css += '.saboxplugin-wrap, .saboxplugin-wrap .saboxplugin-socials{ border-width: ' + sabVars.sab_box_border_width + 'px; }';
		}

		// Avatar image style
		if ( '0' != sabVars.sab_avatar_style ) {
			css += '.saboxplugin-wrap .saboxplugin-gravatar img {-webkit-border-radius:50%;-moz-border-radius:50%;-ms-border-radius:50%;-o-border-radius:50%;border-radius:50%;}';
		}

		// Social icons style
		if ( '0' != sabVars.sab_colored && '0' != sabVars.sab_icons_style ) {
			css += '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color {-webkit-border-radius:50%;-moz-border-radius:50%;-ms-border-radius:50%;-o-border-radius:50%;border-radius:50%;}';
		}

		// Long Shadow
		if ( '1' == sabVars.sab_colored && '1' != sabVars.sab_box_long_shadow ) {
			css += '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color .st1 {display: none;}';
		}

		// Thin border
		if ( '1' == sabVars.sab_colored && '1' == sabVars.sab_box_thin_border ) {
			let style = 'border-width: 1px;border-style:solid;';
			if ( '1' == sabVars.sab_icons_style ) {
				style += 'border-radius:50%';
			}
			css += '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color svg {' + style + '}';
		}

		// Background color of social icons bar
		if ( '' != sabVars.sab_box_icons_back ) {
			css += '.saboxplugin-wrap .saboxplugin-socials{background-color:' + sabVars.sab_box_icons_back + ';}';
		}

		// Background color of author box
		if ( '' != sabVars.sab_box_author_back ) {
			css += '.saboxplugin-wrap {background-color:' + sabVars.sab_box_author_back + ';}';
		}

		// Color of author box paragraphs
		if ( '' != sabVars.sab_box_author_p_color ) {
			css += '.saboxplugin-wrap .saboxplugin-desc  {color:' + sabVars.sab_box_author_p_color + ';}';
		}

		// Color of author box links
		if ( '' != sabVars.sab_box_author_a_color ) {
			css += '.saboxplugin-wrap .saboxplugin-desc a  {color:' + sabVars.sab_box_author_a_color + ';}';
		}

		// Author name color
		if ( '' != sabVars.sab_box_author_color ) {
			css += '.saboxplugin-wrap .saboxplugin-authorname a {color:' + sabVars.sab_box_author_color + ';}';
		}

		// Author web color
		if ( '1' == sabVars.sab_web && '' != sabVars.sab_box_web_color ) {
			css += '.saboxplugin-wrap .saboxplugin-web a {color:' + sabVars.sab_box_web_color + ';}';
		}

		// Author name font family
		if ( 'None' != sabVars.sab_box_name_font ) {
			css += '.saboxplugin-wrap .saboxplugin-authorname {font-family:"' + sabVars.sab_box_name_font + '";}';
		}

		// Author description font family
		if ( 'None' != sabVars.sab_box_desc_font ) {
			css += '.saboxplugin-wrap .saboxplugin-desc {font-family:' + sabVars.sab_box_desc_font + ';}';
		}

		// Author web font family
		if ( '1' == sabVars.sab_web && 'None' != sabVars.sab_box_web_font ) {
			css += '.saboxplugin-wrap .saboxplugin-web {font-family:"' + sabVars.sab_box_web_font + '";}';
		}

	 	// Author description font style
		if ( '1' == sabVars.sab_desc_style ) {
			css += '.saboxplugin-wrap .saboxplugin-desc {font-style:italic;}';
		}

		// Margin top & bottom, Padding
		if ( '' != sabVars.padding_top_bottom ) {
			css += '.saboxplugin-wrap {padding-top: ' + sabVars.padding_top_bottom + 'px; padding-bottom:' + sabVars.padding_top_bottom + 'px; }';
		}
		if ( '' != sabVars.padding_left_right ) {
			css += '.saboxplugin-wrap {padding-left: ' + sabVars.padding_left_right + 'px; padding-right:' + sabVars.padding_left_right + 'px; }';
		}
		if ( '' != sabVars.top_margin ) {
			css += '.saboxplugin-wrap {margin-top: ' + sabVars.top_margin + 'px; }';
		}
		if ( '' != sabVars.bottom_margin ) {
			css += '.saboxplugin-wrap {margin-bottom: ' + sabVars.bottom_margin + 'px; }';
		}

		// Author name text size
		css += '.saboxplugin-wrap .saboxplugin-authorname {font-size:' + sabVars.sabox_name_size + 'px; line-height:' + ( parseInt ( sabVars.sabox_name_size ) + 7 ) + 'px;}';

		// Author description font size
		css += '.saboxplugin-wrap .saboxplugin-desc p, .saboxplugin-wrap .saboxplugin-desc {font-size:' + sabVars.sabox_desc_size + 'px !important; line-height:'  + ( parseInt ( sabVars.sabox_desc_size ) + 7 ) + 'px !important;}';

		// Author website text size
		css += '.saboxplugin-wrap .saboxplugin-web {font-size:' + sabVars.sabox_web_size + 'px;}';

		// Icons size
		let icon_size = parseInt( sabVars.sabox_icon_size );
		if ( '1' == sabVars.sab_colored ) {
			icon_size *= 2;
		}
		css += '.saboxplugin-wrap .saboxplugin-socials a svg {width:' + icon_size + 'px;height:' + icon_size + 'px;}';


		return css;
	}

	loadCustomFonts(){

		let sab_subset;
		if ( 'none' != sabVars.sab_box_subset ) {
			sab_subset = '&amp;subset=' + sabVars.sab_box_subset;
		} else {
			sab_subset = '&amp;subset=latin';
		}

		let google_fonts = [];

		if ( 'None' != sabVars.sab_box_name_font ) {
			google_fonts.push( sabVars.sab_box_name_font.replace(' ', '+') );
		}

		if ( 'None' != sabVars.sab_box_desc_font ) {
			google_fonts.push( sabVars.sab_box_desc_font.replace(' ', '+') );
		}

		if ( 'None' != sabVars.sab_box_web_font ) {
			google_fonts.push( sabVars.sab_box_web_font.replace(' ', '+') );
		}

		function onlyUnique(value, index, self) {
			return self.indexOf(value) === index;
		}
		google_fonts = google_fonts.filter( onlyUnique );

		if ( google_fonts.length > 0 ) {

			google_fonts.forEach(function(entry,index) {
				google_fonts[index] = entry + ':400,700,400italic,700italic';
			});

			return <link href={ 'https://fonts.googleapis.com/css?family=' + google_fonts.join('|') + sab_subset } rel="stylesheet"/>

		}

	}

	componentDidMount() {
		this.changeAuthor( this.props.attributes.authorID == 0 ? sabVars.currentUserID : this.props.attributes.authorID );
	}

	render() {

 		const {
			attributes,
			isSelected,
		} = this.props;

 		const {
			authorID,
			display_name,
			avatar,
			profile_image,
			description,
			user_url,
			social_links,
			status,
		} = attributes;

	 	if( status == 'loading' ) {
			return <div class="saboxplugin-wrap saboxplugin-wrap--loading"><Spinner/></div>
		}

		if( status == 'error' ) {
			return [
				<Fragment>
					{ isSelected && (
						<Inspector
							changeAuthor = { ( authorID ) => this.changeAuthor( authorID ) }
							{ ...this.props }
						/>
					) }

					<div class="saboxplugin-wrap saboxplugin-wrap--error">{ __( 'Author not found' ) }</div>
				</Fragment>
			];
		}

		return [
			<Fragment>
				{ isSelected && (
					<Inspector
						changeAuthor = { ( authorID ) => this.changeAuthor( authorID ) }
						{ ...this.props }
					/>
				) }

				<div class="saboxplugin-wrap">

					<div class="saboxplugin-gravatar">
						<img src={ ! profile_image ? avatar : profile_image } height="100" width="100"/>
					</div>

					<div class="saboxplugin-authorname">
						<a href="#" class="vcard author" rel="author" itemprop="url">
							<span class="fn" itemprop="name">{ display_name }</span>
						</a>
					</div>

					<div class="saboxplugin-desc" dangerouslySetInnerHTML={{ __html: description }}></div>

					{ sabVars.sab_web == '1' && user_url != '' && (
						<div class="saboxplugin-web">
							<a href="#">{ user_url }</a>
						</div>
					) }

					<div class="clearfix"></div>

					{ social_links.length == 0 && sabVars.currentUserID == authorID && (
						<a target="_blank" href={ sabVars.adminURL + 'profile.php?#sabox-social-table' } >{ __( 'Add Social Links' ) }</a>
					) }

					{ sabVars.sab_hide_socials == 0 && ! jQuery.isEmptyObject( social_links ) && (
						<div class="saboxplugin-socials">
							{ Object.keys(social_links).map( (key) => {
								return this.renderSocialIcon( social_links[key], key );
							})}
						</div>
					) }

				</div>

				<style dangerouslySetInnerHTML={{ __html: this.generateInlineCSS() }} />
				{ this.loadCustomFonts() }

			</Fragment>
		];
	}
}
