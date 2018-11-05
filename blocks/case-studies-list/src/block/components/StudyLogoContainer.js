import PropTypes from 'prop-types';

import StudyLogo from './StudyLogo';

const { Component } = wp.element;

class StudyLogoContainer extends Component {
	state = {
		featuredImage: {},
		error: '',
	};
	componentDidMount() {
		if ( this.props.study._links[ 'wp:featuredmedia' ] ) {
			this.fetchFeaturedMedia();
		}
	}
	async fetchFeaturedMedia() {
		const fetchUrl = this.props.study._links[ 'wp:featuredmedia' ][ 0 ].href;
		try {
			const response = await window.fetch( fetchUrl );
			const featuredImage = await response.json();
			this.setState( { featuredImage } );
		} catch ( error ) {
			this.setState( {
				error: 'Something did not work correclty...',
			} );
		}
	}
	render() {
		const { featuredImage } = this.state;
		return (
			<StudyLogo logo={ featuredImage } />
		);
	}
}

StudyLogoContainer.propTypes = {
	study: PropTypes.object.isRequired,
};

export default StudyLogoContainer;
