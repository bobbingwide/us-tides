<?php 
/*
Plugin Name: US tides - heights and times
Plugin URI: http://www.oik-plugins.com/oik-plugins/us-tides
Description: shortcode for US tide times and heights [us_tides]
Version: 0.3.0
Author: bobbingwide
Author URI: http://www.oik-plugins.com/author/bobbingwide
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

    Copyright 2012-2015 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/
us_tides_loaded();

/**
 * Function to invoke when US-tides is loaded
 */
function us_tides_loaded() {
	add_action( "oik_add_shortcodes", "us_tides_init" );
	add_action( "oik_admin_menu", "us_tides_admin_menu" );
	add_action( "admin_notices", "us_tides_activation" );
}

/**
 * Implement "oik_admin_menu" for US-tides
 *
 */
function us_tides_admin_menu() {
  oik_register_plugin_server( __FILE__ );
}

/**
 * Implement "oik_add_shortcodes" for US-tides
 */
function us_tides_init() {
  bw_add_shortcode( 'us_tides', 'us_tides', oik_path( "shortcodes/us-tides.php", "us-tides"), false );
}

/**
 * Implement "admin_notices" for US-tides
 *
 */ 
function us_tides_activation() {
  static $plugin_basename = null;
  if ( !$plugin_basename ) {
    $plugin_basename = plugin_basename(__FILE__);
    add_action( "after_plugin_row_" . $plugin_basename, __FUNCTION__ );   
    require_once( "admin/oik-activation.php" );
  }  
  $depends = "oik:2.5";
  oik_plugin_lazy_activation( __FILE__, $depends, "oik_plugin_plugin_inactive" );
}






