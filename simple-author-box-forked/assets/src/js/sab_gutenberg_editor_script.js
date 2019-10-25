import Edit from './components/edit';

import icons from './utils/icons';

const { registerBlockType } = wp.blocks;


class SAB_Gutenberg  {

	constructor() {
		this.registerBlock();
	}

	registerBlock() {

		/**
		 * Block attributes
		 */
		const blockAttributes = {
			authorID: {
				type: 'integer',
				default: 0,
			},
			display_name: {
				type: 'string',
				default: '',
			},
			avatar: {
				type: 'string',
				default: '',
			},
			profile_image: {
				type: 'string',
				default: '',
			},
			description: {
				type: 'string',
				default: '',
			},
			user_url: {
				type: 'string',
				default: '',
			},
			social_links: {
				type: 'array',
				default: '',
			},
			status: {
				type: 'string',
				default: 'loading',
			},
		};

		registerBlockType( 'simple-author-box/sab', {
			title: 'Simple Author Box',
			icon: icons.author,
			category: 'common',
			supports: {
				customClassName: false,
			},
			attributes: blockAttributes,
			edit: Edit,
			save() {
				// Rendering in PHP
				return null;
			},
		} );

	}


}

window.sab = new SAB_Gutenberg();
