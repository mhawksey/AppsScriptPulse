/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { InspectorControls } = wp.editor;
const { SelectControl, PanelBody } = wp.components;


/**
 * Inspector controls
 */
export default class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	onAuthorSelect( authorID ) {

		this.props.setAttributes( {
			status: 'loading',
		} );

		this.props.changeAuthor( authorID );
	}

	render() {

		const {
			attributes,
			setAttributes
		} = this.props;

	 	const {
			authorID,
		} = attributes;

		let authors = sabVars.authors;
		authors.forEach(function(author) {
			author.value = author.ID;
			author.label = author.display_name;
		});

		let isEditor = false;
		if( sabVars.currentUserRoles.indexOf("administrator") != -1 || sabVars.currentUserRoles.indexOf("editor") != -1 ) {
			isEditor = true;
		}

		return (
			<Fragment>
				<InspectorControls>
					{ isEditor && (
						<PanelBody title={ __( 'Author Settings' ) } initialOpen={ true }>
							<SelectControl
								label={ __( 'Select author' ) }
								value={ authorID }
								options={ authors }
								onChange={ ( value ) => this.onAuthorSelect( value ) }
							/>
						</PanelBody>
					) }
				</InspectorControls>
			</Fragment>
		);
	}
}