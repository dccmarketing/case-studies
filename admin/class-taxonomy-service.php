<?php

namespace CaseStudies\Admin;

class Taxonomy_Service {

	/**
	 * Constructor.
	 */
	public function __construct() {} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 * 
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'wp_loaded', array( $this, 'new_taxonomy_service' ) );
		add_action( 'after_switch_theme', array( $this, 'flush_rewrites' ) );

	} // hooks()

	/**
	 * Flushes the rewrite rules.
	 * 
	 * @hooked 		after_switch_theme
	 * @since 		1.0.0
	 * @uses 		new_taxonomy_service
	 * @uses 		flush_rewrite_rules
	 */
	public function flush_rewrites() {

		$this->new_taxonomy_service();

		flush_rewrite_rules();

	} // flush_rewrites()

	/**
	 * Returns the options for the taxonomy.
	 * 
	 * @since 		1.0.0
	 * @return 		array 		The taxonomy options.
	 */
	public function get_taxonomy_service_options() {

		$opts = array();

		$opts['hierarchical']							= TRUE;
		$opts['public']									= TRUE;
		$opts['show_in_rest'] 							= TRUE;

		$opts['labels']['add_new_item'] 				= esc_html__( 'Add New Service', 'case-studies' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( 'Add or remove services', 'case-studies' );
		$opts['labels']['all_items'] 					= esc_html__( 'Services', 'case-studies' );
		$opts['labels']['back_to_items'] 				= esc_html__( 'Back to services', 'case-studies' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( 'Choose from most used services', 'case-studies' );
		$opts['labels']['edit_item'] 					= esc_html__( 'Edit Service' , 'case-studies');
		$opts['labels']['items_list_navigation'] 		= esc_html__( 'Services list navigation', 'case-studies' );
		$opts['labels']['items_list'] 					= esc_html__( 'Services list', 'case-studies' );
		$opts['labels']['menu_name'] 					= esc_html__( 'Services', 'case-studies' );
		$opts['labels']['name'] 						= esc_html__( 'Services', 'case-studies' );
		$opts['labels']['new_item_name'] 				= esc_html__( 'New Service Name', 'case-studies' );
		$opts['labels']['no_terms'] 					= esc_html__( 'No services', 'case-studies' );
		$opts['labels']['not_found'] 					= esc_html__( 'No Services Found', 'case-studies' );
		$opts['labels']['parent_item'] 					= esc_html__( 'Parent Service', 'case-studies' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( 'Parent Service:', 'case-studies' );
		$opts['labels']['popular_items'] 				= esc_html__( 'Popular Services', 'case-studies' );
		$opts['labels']['search_items'] 				= esc_html__( 'Search Services', 'case-studies' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( 'Separate services with commas', 'case-studies' );
		$opts['labels']['singular_name'] 				= esc_html__( 'Service', 'case-studies' );
		$opts['labels']['update_item'] 					= esc_html__( 'Update Service', 'case-studies' );
		$opts['labels']['view_item'] 					= esc_html__( 'View Service', 'case-studies' );

		/**
		 * The casestudies_taxonomy_service_options filter.
		 * 
		 * @var 		array 		$opts 		The taxonomy options.
		 */
		$options = apply_filters( 'casestudies_taxonomy_service_options', $opts );

		if ( is_array( $options ) ) {

			return $options;

		}

		return FALSE;

	} // get_taxonomy_service_options()

	/**
	 * Creates a new taxonomy for a custom post type.
	 * 
	 * @hooked 		wp_loaded
	 * @since 		1.0.0
	 * @uses 		get_taxonomy_service_options
	 * @uses 		register_taxonomy
	 */
	public function new_taxonomy_service() {

		$opts = $this->get_taxonomy_service_options();

		register_taxonomy( 'service', 'casestudy', $opts );

	} // new_taxonomy_service()

} // class