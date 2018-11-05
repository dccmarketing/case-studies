const { __ } = wp.i18n;
const { InspectorControls } = wp.editor;
const {
	PanelBody,
	QueryControls,
} = wp.components;
const { withSelect } = wp.data;

const Inspector = ( { attributes, categoriesList, setAttributes } ) => {
	const { categories, orderBy, order, perPage } = attributes;
	return (
		<InspectorControls key="inspector">
			<PanelBody initialOpen={ true } title={ __( 'List Display Options' ) }>
				<QueryControls
					{ ...{ order, orderBy } }
					numberOfItems={ perPage }
					categoriesList={ categoriesList }
					selectedCategoryId={ categories }
					onOrderChange={ ( newOrder ) => setAttributes( { order: newOrder } ) }
					onOrderByChange={ ( newOrderBy ) => setAttributes( { orderBy: newOrderBy } ) }
					onCategoryChange={ ( value ) => setAttributes( { categories: '' !== value ? value : undefined } ) }
					onNumberOfItemsChange={ ( newPerPage ) => setAttributes( { perPage: newPerPage } ) }
				/>
			</PanelBody>
		</InspectorControls>
	);
};

//export default Inspector;

export default withSelect( ( select ) => {
	const { getEntityRecords } = select( 'core' );
	const serviceListQuery = {
		per_page: 100,
	};
	return {
		categoriesList: getEntityRecords( 'taxonomy', 'service', serviceListQuery ),
	};
} )( Inspector );
