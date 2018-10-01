<?php

/**
 * Class testing the CPT_CaseStudy class.
 * 
 * @package 		CaseStudies
 */

class TestCPTCaseStudy extends WP_UnitTestCase {

	/**
	 * Configures WordPress for each test.
	 */
	public function setUp() {

		parent::setUp();

		$this->cptCaseStudy = new \CaseStudies\Admin\CPT_CaseStudy();

	} // setUp()

	/**
	 * Removes the testing configuration.
	 */
	public function tearDown() {

		parent::tearDown();

	} // tearDown()

	/**
	 * Asserts TRUE that $this->cptCaseStudy is an instance of the CPT_CaseStudy class.
	 *
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_isCPTCaseStudyObject() {

		$this->assertInstanceOf( 'CaseStudies\Admin\CPT_CaseStudy', $this->cptCaseStudy );

	} // test_isCPTCaseStudyObject()

	/**
	 * Asserts that the wp_loaded action ran greater than 0 times.
	 *
	 * @covers 			CaseStudies\Admin\CPT_CaseStudy::hooks()
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_hooks() {

		$this->assertGreaterThan( 0, did_action( 'wp_loaded' ) );
		$this->assertTrue( has_action( 'wp_loaded' ) );

	} // test_hooks()

	/**
	 * Asserts TRUE that the 'casestudy' post type exists.
	 *
	 * @covers 			CaseStudies\Admin\CPT_CaseStudy::new_cpt_casestudy()
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_newCPTCaseStudy() {

		$cpt_casestudy = $this->cptCaseStudy->new_cpt_casestudy();

		$this->assertTrue( post_type_exists( 'casestudy' ) );

	} // test_newCPTCaseStudy()

	/**
	 * Tests the get_cpt_casestudy_options() method.
	 * 
	 * @covers 		CaseStudies\Admin\CPT_CaseStudy::get_cpt_casestudy_options()
	 * @since 		1.0.0
	 */
	public function test_getCPTCaseStudyOptions() {

		$options = $this->cptCaseStudy->get_cpt_casestudy_options();

		// Make sure $options is an array
		$this->assertTrue( is_array( $options ) );

		// Make sure $options['labels'] is an array
		$this->assertTrue( is_array( $options['labels'] ) );

		// Check for the expected array keys
		$this->assertArrayHasKey( 'labels', $options );
		$this->assertArrayHasKey( 'menu_icon', $options );
		$this->assertArrayHasKey( 'public', $options );
		$this->assertArrayHasKey( 'show_in_rest', $options );

		// Check for the expected values
		$this->assertEquals( 'dashicons-id-alt', $options['menu_icon'] );
		$this->assertTrue( $options['public'] );
		$this->assertTrue( $options['show_in_rest'] );

	} // test_getCPTCaseStudyOptions()

} // class