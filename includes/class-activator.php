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
	 * Registers CPTs, taxomomies, and plugin settings, then flushes rewrite rules.
	 *
	 * @hooked 		register_activation_hook
	 * @since 		1.0.0
	 */
	public static function activate() {

		$cpt = new Admin\CPT_CaseStudy();
		$tax = new Admin\Taxonomy_Service();

		$cpt->new_cpt_casestudy();
		$tax->new_taxonomy_service();
		$cpt->flush_rewrites();

	} // activate()

} // class
