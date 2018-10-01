<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 			1.0.0
 * @package 		CaseStudies\Includes
 * @author 		Slushman <chris@slushman.com>
 */

namespace CaseStudies\Includes;
use \CaseStudies\Admin as Admin;

class Activator {

	/**
	 * Registers CPTs, taxomomies, and plugin settings, then flushes rewrite rules
	 *
	 * @since 		1.0.0
	 */
	public static function activate() {

		// $cpt = new Admin\CPT_Employee();

		// $cpt->new_cpt_employee();
		// $cpt->flush_rewrites();

	} // activate()

} // class
