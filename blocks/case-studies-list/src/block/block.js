/**
 * BLOCK: case-studies-list
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

import './style.scss';
import './editor.scss';

import Edit from './edit';
import Inspector from './inspector';
import attributes from './attributes.js';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;

/**
 * Register: aa Gutenberg Block.
 *
 * @link 		https://wordpress.org/gutenberg/handbook/block-api/
 * @param 		{string} 		name 			Block name.
 * @param 		{Object} 		settings 		Block settings.
 * @return 		{?WPBlock} 						The block, if it has been successfully
 * 													registered; otherwise `undefined`.
 */
registerBlockType( 'casestudies/case-studies-list-block', {
	title: __( 'Case Studies List' ),
	icon: 'editor-ul',
	category: 'dunn',
	keywords: [
		__( 'Case Studies List' ),
	],
	attributes,
	edit: ( props ) => (
		<Fragment>
			<Inspector { ...props } />
			<Edit { ...props } />
		</Fragment>
	),
	save: () => {
		return null;
	},
} );
