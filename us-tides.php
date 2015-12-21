<?php // (C) Copyright Bobbing Wide 2011,2012


/*
Plugin Name: US tides - heights and times
Plugin URI: http://www.oik-plugins.com/oik-plugins/us-tides
Description: shortcode for US tide times and heights [us_tides]
Version: 0.1
Author: bobbingwide
Author URI: http://www.bobbingwide.com
License: GPL2

    Copyright 2011,2012 Bobbing Wide (email : herb@bobbingwide.com )

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





