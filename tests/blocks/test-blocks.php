<?php
/**
 * Class testing the Blocks class.
 *
 * @package 		CaseStudies
 */

class TestBlocks extends WP_UnitTestCase {

	/**
	 * Configures WordPress for each test.
	 */
	public function setUp() {

		parent::setUp();

		$this->blocks = new \CaseStudies\Blocks\Blocks();

	} // setUp()

	/**
	 * Removes the testing configuration.
	 */
	public function tearDown() {

		parent::tearDown();

	} // tearDown()

	/**
	 * Asserts TRUE that $this->blocks is an instance of the Blocks class.
	 *
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_isBlocksObject() {

		$this->assertInstanceOf( 'CaseStudies\Blocks\Blocks', $this->blocks );

	} // test_isBlocksObject()

	/**
	 * Asserts that the wp_loaded action ran greater than 0 times.
	 *
	 * @covers 			CaseStudies\Blocks\Blocks::hooks()
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_hooks() {

		$this->assertGreaterThan( 0, did_action( 'wp_loaded' ) );
		$this->assertTrue( has_action( 'wp_loaded' ) );

	} // test_hooks()

	/**
	 * Asserts get_blocks returns an array with the expected entries.
	 *
	 * @covers 			CaseStudies\Blocks\Blocks::get_blocks()
	 * @since 			1.0.0
	 */
	public function test_getBlocks() {

		$expected 	= array();
		$expected[] = 'case-studies-list';
		$result 	= $this->blocks->get_blocks();

		$this->assertInternalType( 'array', $result );
		$this->assertEquals( $expected, $result );

		foreach ( $expected as $key => $value ) {

			$this->assertArrayHasKey( $key, $result );
			$this->assertEquals( $value, $result[$key] );

		}

	} // test_getBlocks()

	/**
	 * Asserts render_case_studies_list_block returns the expected results.
	 * 
	 * @covers 		CaseStudies\Blocks\Blocks::render_case_studies_list_block()
	 * @since 		1.0.0
	 */
	public function test_render_case_studies_list_block() {

		$attributes 			= array();
		$attributes['perPage'] 	= 10;
		$expected 				= null;
		$result 				= $this->blocks->render_case_studies_list_block( $attributes );

		$this->assertEquals( $expected, $result );

	} // test_render_case_studies_list_block()

	/**
	 * Asserts enqueue_block_assets enqueues the expected scripts and stylesheets.
	 * 
	 * @covers 		enqueue_block_assets
	 * @since 		1.0.0
	 */
	public function test_enqueue_all_scripts() {

		$this->blocks->enqueue_block_assets();
		$this->assertTrue( wp_script_is( 'case-studies-list-block-all-scripts' ) );
		$this->assertTrue( wp_style_is( 'case-studies-list-block-all-css' ) );

	} // test_enqueue_all_scripts()

	/**
	 * Asserts enqueue_block_editor_assets enqueues the expected scripts and stylesheets.
	 * 
	 * @covers 		enqueue_block_editor_assets
	 * @since 		1.0.0
	 */
	public function test_enqueue_editor_scripts() {

		$this->blocks->enqueue_block_editor_assets();
		//$this->assertTrue( wp_script_is( 'case-studies-list-block-all-scripts' ) );
		$this->assertTrue( wp_style_is( 'case-studies-list-block-editor-css' ) );

	} // test_enqueue_editor_scripts()

} // class
