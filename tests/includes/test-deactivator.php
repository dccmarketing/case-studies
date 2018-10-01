<?php
/**
 * Class testing the Deactivator class.
 *
 * Tests:
 * 	Asserts $this->deactivator is an instance of the Deactivator class.
 *
 * @package 		CaseStudies
 */

class TestDeactivator extends WP_UnitTestCase {

	/**
	 * Configures WordPress for each test.
	 */
	public function setUp() {

		parent::setUp();

		$this->deactivator = new \CaseStudies\Includes\Deactivator();

	} // setUp()

	/**
	 * Removes the testing configuration.
	 */
	public function tearDown() {

		parent::tearDown();

	} // tearDown()

	/**
	 * Asserts TRUE that $this->deactivator is an instance of the Deactivator class.
	 *
	 * @expects 		bool 		TRUE
	 * @since 			1.0.0
	 */
	public function test_isDeactivatorObject() {

		$this->assertInstanceOf( 'CaseStudies\Includes\Deactivator', $this->deactivator );

	} // test_isDeactivatorObject()

} // class
