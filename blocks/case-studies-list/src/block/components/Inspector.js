const { __ } = wp.i18n;
const { Component } = wp.element;
const { InspectorControls } = wp.editor;
const {
	PanelBody,
	QueryControls,
	ToggleControl,
} = wp.components;
const { withSelect } = wp.data;

class Inspector extends Component {
	/**
	 * Sets any toggle attribute.
	 *
	 * @param {string} attribute The attribute to toggle.
	 * @return {void}
	 */
	toggleAttribute = ( attribute ) => {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}
	render() {
		const { attributes, categoriesList, setAttributes } = this.props;
		const { categories, orderBy, order, perPage, showLogo } = attributes;
		return (
			<InspectorControls key="inspector">
				<PanelBody initialOpen={ true } title={ __( 'List Display Options' ) }>
					<QueryControls
						{ ...{ order, orderBy } }
						numberOfItems={ perPage }
						categoriesList={ categoriesList }
						selectedCategoryId={ categories }
						onOrderChange={ this.toggleAttribute( 'order' ) }
						onOrderByChange={ this.toggleAttribute( 'orderBy' ) }
						onCategoryChange={ ( value ) => setAttributes( { categories: '' !== value ? value : undefined } ) }
						onNumberOfItemsChange={ this.toggleAttribute( 'perPage' ) }
					/>
					<ToggleControl
						label={ __( 'Show Logo' ) }
						checked={ !! showLogo }
						onChange={ this.toggleAttribute( 'showLogo' ) }
					/>
				</PanelBody>
			</InspectorControls>
		);
	}
}

export default withSelect( ( select ) => {
	const { getEntityRecords } = select( 'core' );
	const serviceListQuery = {
		per_page: 100,
	};
	return {
		categoriesList: getEntityRecords( 'taxonomy', 'service', serviceListQuery ),
	};
} )( Inspector );
