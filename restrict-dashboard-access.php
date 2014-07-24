<?php

/*
Plugin Name: Restrict Dashboard Access
Version: 1.0
Description: After successful login, redirects user roles with edit post restriction to the site homepage.Hides the front end admin bar for all users and adds a login/logout link to your site primary menu.
Author: Kumar Abhisek
Author URI: http://increasy.com/
Plugin URI: http://increasy.com/
License: GPLv2

 Copyright 2014 Kumar Abhisek (email:meabhi[at]outlook dot com)
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License version 2,
 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 GNU General Public License for more details.
 
 The license for this software can likely be found here:
 http://www.gnu.org/licenses/gpl-2.0.html

*/
   
add_action( 'init', 'rda_block_user_access' );

    function rda_block_user_access() {

            if ( is_admin() && ! current_user_can( 'edit_posts' ) ) {
                    wp_redirect( home_url() );
                    exit;
            }
    } 
add_filter( 'show_admin_bar', 'rda_hide_admin_bar' );

    function rda_hide_admin_bar(){
               remove_action( 'wp_head', '_admin_bar_bump_cb' );
               return false;
    }
add_filter( 'wp_nav_menu_items', 'add_rda_loginout_menu_link', 50, 2 );

    function add_rda_loginout_menu_link( $items, $args ) { 
        if ( is_admin() || $args->theme_location != 'primary' )
           return $items;
           $link = wp_loginout( $redirect = $_SERVER['REQUEST_URI'], $echo = false );
        return $items.= '<li class="menu-item menu-type-link" id="rda-log-in-out-link">'. $link . '</li>'; 
    }