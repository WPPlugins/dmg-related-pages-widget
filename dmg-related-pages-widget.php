<?php
/*
Plugin Name: DMG Related Pages Widget
Plugin URI: http://dancoded.com/wordpress-plugins/related-pages-widget/
Description: A simple widget that displays a list of pages related to the current page. You can choose to show either siblings pages, child pages or both, and set how many levels of child pages to show.
Version: 1.1.1
Author: Dan Gifford
Author URI: http://dancoded.com/


    Copyright (C) 2016  Dan Gifford

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



/*
	Prevent direct access
 */
if( !defined( 'ABSPATH' ) ) { exit; }



/*
    Requires
 */
if( !class_exists('DMG\\WP_Widget_Base\\WP_Widget_Base') )
{
    require_once 'vendor/DMG/WP_Widget_Base/src/WP_Widget_Base.php';
}

require_once 'src/WP_Related_Pages_Widget.php';



/*
	Register widget
 */
add_action( 'widgets_init', function() { register_widget( 'DMG\\WP_Related_Pages_Widget\\WP_Related_Pages_Widget' ); } );