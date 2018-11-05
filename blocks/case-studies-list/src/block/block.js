/**
 * BLOCK: case-studies-list
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

import './style.scss';
import './editor.scss';

import Edit from './components/Edit';
import Inspector from './components/Inspector';
import Controls from './components/Controls';
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
	icon: 'list-view',
	category: 'common',
	keywords: [
		__( 'Case Studies List' ),
	],
	attributes,
	edit: ( props ) => (
		<Fragment>
			<Inspector
				attributes={ props.attributes }
				setAttributes={ props.setAttributes }
			/>
			<Controls
				listLayout={ props.attributes.listLayout }
				setAttributes={ props.setAttributes }
			/>
			<Edit
				attributes={ props.attributes }
				className={ props.className }
			/>
		</Fragment>
	),
	save: () => {
		return null;
	},
} );
