<?php 
/*
Plugin Name: US tides - heights and times
Plugin URI: http://www.oik-plugins.com/oik-plugins/us-tides
Description: shortcode for US tide times and heights [us_tides]
Version: 0.2.0120
Author: bobbingwide
Author URI: http://www.bobbingwide.com
License: GPL2

    Copyright 2012,2013 Bobbing Wide (email : herb@bobbingwide.com )

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
add_action( "oik_loaded", "us_tides_init" );
add_action( "oik_admin_menu", "us_tides_admin_menu" );

/**
 *  
 */
function us_tides_admin_menu() {
  oik_register_plugin_server( __FILE__ );
}

function us_tides_init() {
  bw_add_shortcode( 'us_tides', 'us_tides', oik_path( "shortcodes/us-tides.php", "us-tides"), false );
}

add_action( "admin_notices", "us_tides_activation" );
/**
*/ 
function us_tides_activation() {
  static $plugin_basename = null;
  if ( !$plugin_basename ) {
    $plugin_basename = plugin_basename(__FILE__);
    add_action( "after_plugin_row_" . $plugin_basename, __FUNCTION__ );   
    require_once( "admin/oik-activation.php" );
  }  
  $depends = "oik:1.17";
  oik_plugin_lazy_activation( __FILE__, $depends, "oik_plugin_plugin_inactive" );
}






