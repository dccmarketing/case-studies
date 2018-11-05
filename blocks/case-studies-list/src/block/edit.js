import classnames from 'classnames';
import he from 'he';
import pickBy from 'lodash/pickBy';
import isUndefined from 'lodash/isUndefined';

const { withSelect } = wp.data;

const Edit = ( { attributes, className, studies } ) => {
	const { perPage } = attributes;
	const listClasses = classnames( className );
	const studiesList = studies && 0 < studies.length ? studies : [];

	if ( ! studiesList || studiesList < perPage ) {
		return (
			<p>There are no studies to display.</p>
		);
	}

	const showStudies = studiesList > perPage ?
		studies.slice( 0, perPage ) :
		studies;
	return (
		<ul className={ listClasses }>
			{
				showStudies.map( ( study, i ) => {
					return (
						<li className="case-study" key={ i }>
							<a className="case-study-link" href={ study.link }>{ he.decode( study.title.rendered ) }</a>
						</li>
					);
				} )
			}
		</ul>
	);
};

export default withSelect( ( select, props ) => {
	const { categories, order, orderBy, perPage } = props.attributes;
	const { getEntityRecords } = select( 'core' );
	const studiesListQuery = pickBy( {
		per_page: perPage,
		order,
		orderby: orderBy,
		service: categories,
	}, ( value ) => ! isUndefined( value ) );

	return {
		studies: getEntityRecords( 'postType', 'casestudy', studiesListQuery ),
	};
} )( Edit );
