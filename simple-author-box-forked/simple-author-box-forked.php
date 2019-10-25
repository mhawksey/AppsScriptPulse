<?php
/**
* Plugin Name: 				Simple Author Box - Forked
* Description: 				Adds a responsive author box with social icons on your posts.
* Version: 					2.3.2
* Author: 					MachoThemes
* Author URI: 				https://www.machothemes.com/
* Requires: 				4.6 or higher
* License: 					GPLv3 or later
* License URI:       		http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 			5.6
*
* Copyright 2014-2017		Tiguan				office@tiguandesign.com		
* Copyright 2017-2019 		MachoThemes 		office@machothemes.com
*
* Original Plugin URI: 		https://tiguan.com/simple-author-box/
* Original Author URI: 		https://tiguan.com
* Original Author: 			https://profiles.wordpress.org/tiguan/
*
* NOTE:
* Tiguan transferred ownership rights on: 09/22/2017 06:38:44 PM when ownership was handed over to MachoThemes
* The MachoThemes ownership period started on: 09/22/2017 06:38:45 PM
* SVN commit proof of ownership transferral: https://plugins.trac.wordpress.org/changeset/1734457/simple-author-box
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 3, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'SIMPLE_AUTHOR_BOX_PATH', plugin_dir_path( __FILE__ ) );
define( 'SIMPLE_AUTHOR_BOX_ASSETS', plugins_url( '/assets/', __FILE__ ) );
define( 'SIMPLE_AUTHOR_BOX_SLUG', plugin_basename( __FILE__ ) );
define( 'SIMPLE_AUTHOR_BOX_VERSION', '2.3.2' );
define( 'SIMPLE_AUTHOR_SCRIPT_DEBUG', false );

require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box.php';

Simple_Author_Box::get_instance();

function sab_check_for_review() {
	if ( ! is_admin() ) {
		return;
	}
	require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-sab-review.php';

	SAB_Review::get_instance( array(
		'slug' => 'simple-author-box',
	) );
}

sab_check_for_review();
