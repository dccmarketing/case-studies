import classnames from 'classnames';
import he from 'he';
import { isUndefined, pickBy } from 'lodash';

const { withSelect } = wp.data;

const Edit = props => {
	const listClasses = classnames( props.className );
	const studies = props.studies && 0 < props.studies.length ? props.studies : [];
	const showStudies = studies.length > props.attributes.perPage ?
		studies.slice( 0, props.attributes.perPage ) :
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
	const { perPage, order, orderBy, categories } = props.attributes;
	const { getEntityRecords } = select( 'core' );
	const studiesListQuery = pickBy( {
		per_page: perPage,
		order,
		orderby: orderBy,
		categories,
	}, ( value ) => ! isUndefined( value ) );
	return {
		studies: getEntityRecords( 'postType', 'casestudy', studiesListQuery ),
	};
} )( Edit );
