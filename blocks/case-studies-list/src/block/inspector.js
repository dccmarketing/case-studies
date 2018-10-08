/**
 * WordPress dependencies
 */
import { isUndefined, pickBy } from 'lodash';

const { __ } = wp.i18n;
const { InspectorControls } = wp.editor;
const {
	PanelBody,
	QueryControls,
} = wp.components;
const { withSelect } = wp.data;

const Inspector = ( props ) => {
	const { setAttributes, categoriesList } = props;
	const { perPage, orderBy, order, categories } = props.attributes;
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

export default withSelect( ( select, props ) => {
	const { perPage, order, orderBy, categories } = props.attributes;
	const { getEntityRecords } = select( 'core' );
	const studiesListQuery = pickBy( {
		per_page: perPage,
		order,
		orderby: orderBy,
		categories,
	}, ( value ) => ! isUndefined( value ) );
	const servicesListQuery = {
		per_page: 100,
	};
	return {
		studies: getEntityRecords( 'postType', 'casestudy', studiesListQuery ),
		categoriesList: getEntityRecords( 'taxonomy', 'service', servicesListQuery ),
	};
} )( Inspector );
