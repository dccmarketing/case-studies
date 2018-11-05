import PropTypes from 'prop-types';

const StudyLogo = ( { logo } ) => {
	return (
		<img alt={ logo.alt_text } className="study-logo" src={ logo.source_url } />
	);
};

StudyLogo.propTypes = {
	logo: PropTypes.object.isRequired,
};

export default StudyLogo;
