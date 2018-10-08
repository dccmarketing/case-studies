<?php
/**
 * Class testing the Query class.
 *
 * Tests:
 * 	Asserts $this->query is an instance of the Query class.
 *
 * @package 		CaseStudies
 */

class TestQuery extends WP_UnitTestCase {

	/**
	 * Configures WordPress for each test.
	 */
	public function setUp() {

		parent::setUp();

		$this->query = new \CaseStudies\Includes\Query();

	} // setUp()

	/**
	 * Removes the testing configuration.
	 */
	public function tearDown() {

		parent::tearDown();

	} // tearDown()

	/**
	 * Asserts TRUE that $this->query is an instance of the Query class.
	 *
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_isQueryObject() {

		$this->assertInstanceOf( 'CaseStudies\Includes\Query', $this->query );

	} // test_isQueryObject()

	/**
	 * Asserts the results from get_cache_name() are expected.
	 * 
	 * @covers 			CaseStudies\Includes\Query::get_cache_name()
	 * @since 			1.0.0
	 */
	public function test_getCacheNameReturns() {

		$expected 	= 'case_study_list';
		$params 	= array();
		$cache  	= '';
		$result 	= $this->query->get_cache_name( $params, $cache );

		$this->assertEquals( $expected, $result );

		$expected 	= 'case_study_test_list';
		$params 	= array();
		$cache  	= 'test';
		$result 	= $this->query->get_cache_name( $params, $cache );

		$this->assertEquals( $expected, $result );

		$expected 			= 'case_study_test_yeppers_list';
		$params 			= array();
		$params['service'] 	= 'yeppers';
		$cache  			= 'test';
		$result 			= $this->query->get_cache_name( $params, $cache );

		$this->assertEquals( $expected, $result );

		$expected 			= 'case_study_yeppers_list';
		$params 			= array();
		$params['service'] 	= 'yeppers';
		$cache  			= '';
		$result 			= $this->query->get_cache_name( $params, $cache );

		$this->assertEquals( $expected, $result );

	} // test_getCacheNameReturns()

	/**
	 * Asserts the result from query() is a WP_Query object.
	 * 
	 * Further testing requires creating a bunch of posts
	 * to query against.
	 * 
	 * @covers 			CaseStudies\Includes\Query::query()
	 * @expects 		WP_Query
	 * @since 			1.0.0
	 */
	public function test_queryReturnsWPQueryObject() {

		// Test result is a WP_Query object.
		$args 			= array();
		$cache 			= '';
		$result 		= $this->query->query( $args, $cache );
		$expected 		= '';

		$this->assertInstanceOf( '\WP_Query', $result );

	} // test_queryReturnsWPQueryObject()

} // class
