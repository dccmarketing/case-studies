<?php

/**
 * Class defining functionality for the custom post type 'casestudy'.
 * 
 * @link 			https://www.dunncompany.com
 * @since 			1.0.0
 * @package 		CaseStudies\Admin
 * @author 			Slushman <chris@slushman.com>
 */

namespace CaseStudies\Admin;

class CPT_CaseStudy {

	/**
	 * Constructor.
	 */
	public function __construct() {} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 */
	public function hooks() {

		add_action( 'wp_loaded', array( $this, 'new_cpt_casestudy' ) );
		add_action( 'after_switch_themes', array( $this, 'flush_rewrites' ) );

	} // hooks()

	/**
	 * Flushes the rewrite rules.
	 * 
	 * @hooked 		after_switch_theme
	 * @since 		1.0.0
	 * @uses 		new_cpt_casestudy
	 */
	public function flush_rewrites() {

		$this->new_cpt_casestudy();

		flush_rewrite_rules();

	} // flush_rewrites()

	/**
	 * Returns the optiosn for the casestudy post type.
	 * 
	 * @since 		1.0.0
	 * @return 		array 		The casestudy post type options array.
	 */
	public function get_cpt_casestudy_options() {

		$opts = array();

		$opts['menu_icon']								= 'dashicons-id-alt';
		$opts['public']									= TRUE;
		$opts['show_in_rest'] 							= TRUE;
		$opts['supports'] 								= array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' );
		$opts['template'] 								= array(
			array( 'core/paragraph' ),
			array( 'core/heading', array( 'content' => __( 'Challenges', 'case-studies' ), 'level' => 2 ) ),
			array( 'core/paragraph' ),
			array( 'core/heading', array( 'content' => __( 'Solution', 'case-studies' ), 'level' => 2 ) ),
			array( 'core/paragraph' ),
			array( 'core/heading', array( 'content' => __( 'Construction Phasing', 'case-studies' ), 'level' => 2 ) ),
			array( 'core/list', array( 'ordered' => true ) ),
			array( 'core/heading', array( 'content' => __( 'Results', 'case-studies' ), 'level' => 2 ) ),
			array( 'core/list' ),
		);

		$opts['labels']['add_new']						= esc_html__( 'Add New Case Study', 'case-studies' );
		$opts['labels']['add_new_item']					= esc_html__( 'Add New Case Study', 'case-studies' );
		$opts['labels']['all_items']					= esc_html__( 'Case Studies', 'case-studies' );
		$opts['labels']['archives']						= esc_html__( 'Case Study Archives', 'case-studies' );
		$opts['labels']['attributes']					= esc_html__( 'Case Study Attributes', 'case-studies' );
		$opts['labels']['edit_item']					= esc_html__( 'Edit Case Study' , 'case-studies');
		$opts['labels']['filter_items_list']			= esc_html__( 'Filter case studies list', 'case-studies' );
		$opts['labels']['insert_into_item']				= esc_html__( 'Insert into case studies', 'case-studies' );
		$opts['labels']['items_list']					= esc_html__( 'Case Studies list', 'case-studies' );
		$opts['labels']['items_list_navigation']		= esc_html__( 'Case Studies list navigation', 'case-studies' );
		$opts['labels']['menu_name']					= esc_html__( 'Case Studies', 'case-studies' );
		$opts['labels']['name']							= esc_html__( 'Case Studies', 'case-studies' );
		$opts['labels']['name_admin_bar']				= esc_html__( 'Case Study', 'case-studies' );
		$opts['labels']['new_item']						= esc_html__( 'New Case Study', 'case-studies' );
		$opts['labels']['not_found']					= esc_html__( 'No case studies found', 'case-studies' );
		$opts['labels']['not_found_in_trash']			= esc_html__( 'No case studies found in trash', 'case-studies' );
		$opts['labels']['parent_item_colon']			= esc_html__( 'Parent Case Studies: ', 'case-studies' );
		$opts['labels']['search_items']					= esc_html__( 'Search Case Studies', 'case-studies' );
		$opts['labels']['singular_name']				= esc_html__( 'Uploaded to this employee', 'case-studies' );
		$opts['labels']['uploaded_to_this_item']		= esc_html__( 'All Case Studies', 'case-studies' );
		$opts['labels']['view_item']					= esc_html__( 'View Case Study', 'case-studies' );
		$opts['labels']['view_items']					= esc_html__( 'View Case Studies', 'case-studies' );

		/**
		 * The casestudies_cpt_casestudy_options filter.
		 * 
		 * @var 		array 		$options 		The CPT options.
		 */
		$options = apply_filters( 'casestudies_cpt_casestudy_options', $opts );

		if ( is_array( $options ) ) {

			return $options;

		}

		return FALSE;

	} // get_cpt_casestudy_options()

	/**
	 * Creates a new custom post type.
	 * 
	 * @hooked 		wp_loaded
	 * @since 		1.0.0
	 * @uses 		register_post_type
	 * @uses 		get_cpt_casestudy_options
	 */
	public function new_cpt_casestudy() {

		$opts = $this->get_cpt_casestudy_options();

		register_post_type( 'casestudy', $opts );

	} // new_cpt_casestudy()

} // class