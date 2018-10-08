<?php

/**
 * Defines the methods for working with WP_Query.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 *
 * @package		CaseStudies\Includes
 */

namespace CaseStudies\Includes;

class Query {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {} // __construct()

	/**
	 * Returns a cache name based on the attributes.
	 *
	 * @param 	array 		$args 			The WP_Query args
	 * @param   string 		$cache 			Optional cache name
	 * @return 	string 						The cache name
	 */
	public function get_cache_name( $args, $cache = '' ) {

		$return = 'case_study_list';

		if ( ! empty( $cache ) ) {

			$return = 'case_study_' . $cache . '_list';

		}

		if ( ! empty( $args['service'] ) ) {

			$return = 'case_study';
			
			if ( ! empty( $cache ) ) {

				$return .= '_' . $cache;

			}

			$return .= '_' . $args['service'] . '_list';

		}

		return $return;

	} // get_cache_name()

	/**
	 * Returns a post object of posts.
	 *
	 * Check for cache first, if it exists, returns that.
	 * If not, it queries for the posts,
	 * If the result is an error, it returns the error message.
	 * If not, it caches the results for five minutes and returns the list.
	 *
	 * @param 	array 		$params 			An array of optional parameters
	 * @param 	string 		$cache 				String to create a new cache of posts
	 *
	 * @return 	object 		A post object
	 */
	public function query( $params = array(), $cache = '' ) {

		$return 	= '';
		$cache_name = $this->get_cache_name( $params, $cache );
		$cachedList = wp_cache_get( $cache_name, 'case_study_list' );

		if ( false !== $cachedList ) { return $cachedList; }

		$defaults 							= array();
		$defaults['no_found_rows']			= true;
		$defaults['order'] 					= 'ASC';
		$defaults['orderby'] 				= 'date';
		$defaults['post_type'] 				= 'casestudy';
		$defaults['post_status'] 			= 'publish';
		$defaults['posts_per_page'] 		= 100;
		$defaults['update_post_term_cache'] = false;

		if ( ! empty( $params['service'] ) ) {

			$defaults['tax_query'][0]['field'] 		= 'slug';
			$defaults['tax_query'][0]['taxonomy'] 	= 'service';
			$defaults['tax_query'][0]['terms'] 		= $params['service'];

		}

		$args 	= wp_parse_args( $params, $defaults );
		$query 	= new \WP_Query( $args );

		if ( is_wp_error( $query ) && empty( $query ) ) {

			return __( 'No case studies were found.', 'case-studies' );

		}

		wp_cache_set( $cache_name, $query, 'case_study_list', 5 * MINUTE_IN_SECONDS );

		return $query;

	} // query()

} // class
