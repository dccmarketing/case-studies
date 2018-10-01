<?php

/**
 * Class testing the Taxonomy_Service class.
 * 
 * @package 		CaseStudies
 */

class TestTaxonomyService extends WP_UnitTestCase {

	/**
	 * Configures WordPress for each test.
	 */
	public function setUp() {

		parent::setUp();

		$this->taxService = new \CaseStudies\Admin\Taxonomy_Service();

	} // setUp()

	/**
	 * Removes the testing configuration.
	 */
	public function tearDown() {

		parent::tearDown();

	} // tearDown()

	/**
	 * Asserts TRUE that $this->taxService is an instance of the Taxonomy_Service class.
	 *
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_isTaxonomyServiceObject() {

		$this->assertInstanceOf( 'CaseStudies\Admin\Taxonomy_Service', $this->taxService );

	} // test_isTaxonomyServiceObject()

	/**
	 * Asserts that the wp_loaded action ran greater than 0 times.
	 *
	 * @covers 			CaseStudies\Admin\Taxonomy_Service::hooks()
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_hooks() {

		$this->assertGreaterThan( 0, did_action( 'wp_loaded' ) );
		$this->assertTrue( has_action( 'wp_loaded' ) );

	} // test_hooks()

	/**
	 * Asserts TRUE that the 'service' taxonomy exists.
	 *
	 * @covers 			CaseStudies\Admin\Taxonomy_Service::new_taxonomy_service()
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_newTaxonomyService() {

		$tax_service = $this->taxService->new_taxonomy_service();

		$this->assertTrue( taxonomy_exists( 'service' ) );

	} // test_newTaxonomyService()

	/**
	 * Tests the get_taxonomy_service_options() method.
	 * 
	 * @covers 		CaseStudies\Admin\Taxonomy_Service::get_taxonomy_service_options()
	 * @since 		1.0.0
	 */
	public function test_getTaxonomyServiceOptions() {

		$options = $this->taxService->get_taxonomy_service_options();

		// Make sure $options is an array
		$this->assertTrue( is_array( $options ) );

		// Make sure $options['labels'] is an array
		$this->assertTrue( is_array( $options['labels'] ) );

		// Check for the expected array keys
		$this->assertArrayHasKey( 'hierarchical', $options );
		$this->assertArrayHasKey( 'labels', $options );
		$this->assertArrayHasKey( 'public', $options );
		$this->assertArrayHasKey( 'show_in_rest', $options );

		// Check for the expected values
		$this->assertTrue( $options['public'] );
		$this->assertTrue( $options['show_in_rest'] );

	} // test_getTaxonomyServiceOptions()

} // class