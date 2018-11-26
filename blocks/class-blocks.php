<?php

/**
 * Defines all the functionality related to blocks.
 * 
 * @link 			https://www.dunncompany.com
 * @since 			1.0.0
 * @package 		CaseStudies\Blocks
 * @author 			Slushman <chris@slushman.com>
 */

namespace CaseStudies\Blocks;
use CaseStudies\Includes as Inc;

class Blocks {

	/**
	 * Instance of Inc\Query.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		Inc\Query
	 */
	private $query = '';

	/**
	 * Constructor.
	 * 
	 * @param 		Inc\Query 		$query 		Instance of Query.
	 */
	public function __construct( Inc\Query $query ) {

		$this->query = $query;

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 * 
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'wp_loaded', 					array( $this, 'register_dynamic_blocks' ) );
		add_action( 'enqueue_block_assets', 		array( $this, 'enqueue_block_assets' ) );
		add_action( 'enqueue_block_editor_assets', 	array( $this, 'enqueue_block_editor_assets' ) );

	} // hooks()

	/**
	 * Registers the shared scripts and styles for the blocks.
	 * 
	 * @exits 		If $blocks is empty or not an array.
	 * @hooked 		enqueue_block_assets
	 * @since 		1.0.0
	 * @uses 		get_blocks
	 */
	public function enqueue_block_assets() {

		$blocks = $this->get_blocks();

		if ( empty( $blocks ) || ! is_array( $blocks ) ) { return; }

		foreach ( $blocks as $block ) {
			wp_enqueue_style(
				$block . '-block-all-css',
				plugin_dir_url( __FILE__ ) . $block . '/dist/blocks.style.build.css', dirname( __FILE__ ), 
				array( 'wp-blocks' )
			);
		}

	} // enqueue_block_assets()

	/**
	 * Registers the scripts and styles for the editor blocks.
	 * 
	 * @exits 		If $blocks is empty or not an array.
	 * @hooked 		enqueue_block_editor_assets
	 * @since 		1.0.0
	 * @uses 		get_blocks
	 */
	public function enqueue_block_editor_assets() {

		$blocks = $this->get_blocks();

		if ( empty( $blocks ) || ! is_array( $blocks ) ) { return; }

		foreach ( $blocks as $block ) {
			wp_enqueue_script(
				$block . '-block-scripts',
				plugin_dir_url( __FILE__ ) . $block . '/dist/blocks.build.js', dirname( __FILE__ ),
				plugin_dir_url( __FILE__ ) . 'dist/blocks.build.js',
				array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api', 'wp-data', 'wp-date', 'wp-utils' )
			);
			wp_enqueue_style(
				$block . '-block-editor-css',
				plugin_dir_url( __FILE__ ) . $block . '/dist/blocks.editor.build.css', dirname( __FILE__ ),
				array( 'wp-blocks' )
			);
		}

	} // enqueue_block_editor_assets()

	/**
	 * Returns an array of the block slugs.
	 * 
	 * @since 		1.0.0
	 * @return 		array 		Array of block slugs.
	 */
	public function get_blocks() {

		$blocks = array();

		$blocks[] = 'case-studies-list';

		return $blocks;

	} // get_blocks()

	/**
	 * Registers blocks for dynamic content.
	 * 
	 * @exits 		If the register_block_type function doesn't exist.
	 * @hooked 		register_dynamic_blocks
	 * @since 		1.0.0
	 * @uses 		case_studies_list_block_render
	 */
	public function register_dynamic_blocks() {

		if ( ! function_exists( 'register_block_type' ) ) { return; }

		register_block_type( 'casestudies/case-studies-list-block', array(
			'attributes' => array(
				'categories' => array(
					'type' => 'string',
				),
				'listLayout' => array(
					'type' => 'string',
					'default' => 'list',
				),
				'perPage' => array(
					'type' => 'number',
					'default' => 10,
				),
				'order' => array(
					'type' => 'string',
					'default' => 'desc',
				),
				'orderBy' => array(
					'type' => 'string',
					'default' => 'date',
				),
				'showLogo' => array(
					'type' => 'boolean',
					'default' => false,
				),
			),
			'render_callback' => array( $this, 'render_case_studies_list_block' )
		) );

	} // register_dynamic_blocks()

	/**
	 * Renders the dynamic content for the case-studies-list block output.
	 * 
	 * @since 		1.0.0
	 * @param 		array 		$attributes 		The block attributes.
	 * @return 		mixed 							The HTML markup for the block.
	 */
	public function render_case_studies_list_block( $attributes ) {

		//print_r( $attributes );

		$args['order'] 			= $attributes['order'];
		$args['orderby'] 		= $attributes['orderBy'];
		$args['posts_per_page'] = $attributes['perPage'];

		if ( ! empty( $attributes['categories'] ) ) {

			$args['tax_query'][0]['taxonomy'] 	= 'service';
			$args['tax_query'][0]['field'] 		= 'id';
			$args['tax_query'][0]['terms'] 		= $attributes['categories'];

		}

		$studies = $this->query->query( $args );

		if ( 0 <= $studies->post_count && empty( $studies->posts ) ) { return; }

		$listClasses = array();
		$listClasses[] = 'case-study-list';

		if ( 'grid' === $attributes['listLayout'] ) {

			$listClasses[] = 'is-grid';

		}

		$markup = '';

		$markup .= '<ul class="' . implode( ' ', $listClasses ) . '">';

			foreach ( $studies->posts as $study ) :

				$markup .= '<li class="case-study">';
				$markup .= '<a href="';
				$markup .= esc_url( get_permalink( $study ) );
				$markup .= '">';

				if ( 'grid' === $attributes['listLayout'] && $attributes['showLogo'] ) :

					$markup .= $this->maybe_get_featured_image( $study->ID, $attributes['showLogo'] );

				endif;

				$markup .= esc_html( $study->post_title ); 
				$markup .= '</a></li>';

			endforeach;

		$markup .= '</ul>';

		return $markup;

	} // render_case_studies_list_block()

	/**
	 * Returns the featured image markup, if available.
	 * 
	 * @since 		1.0.0
	 * @param 		int 		$studyID 		The case study post object ID.
	 * @param 		bool 		$showLogo 		The block attribute showLogo.
	 * @return 		mixed 						The featured image markup.
	 */
	public function maybe_get_featured_image( $studyID, $showLogo ) {

		if ( ! $showLogo ) { return; }
		if ( ! has_post_thumbnail( $studyID ) ) { return; }

		return get_the_post_thumbnail( $studyID, 'full' );

	} // maybe_get_featured_image()

} // class