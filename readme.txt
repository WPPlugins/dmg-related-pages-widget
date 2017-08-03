=== DMG Related Pages Widget ===
Contributors: dancoded
Tags: page widget, menu, css, list pages, related pages
Donate link: http://dancoded.com/wordpress-plugins/
Requires at least: 3.1
Tested up to: 4.6
Stable tag: 1.1.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/

Widget that displays a list of pages related to the current page in your sidebar. Advanced options allow you to control which pages are shown, add CSS classes & make the title link.

== Description ==
A simple widget that displays a list of pages related to the current page. 

You can choose to show either siblings pages (on the same level), child pages or both, and set how many levels of child pages to show.

You can also enter class(es) to be applied to the widget wrapper or the list (ul element).

If the widget is on a page that is not hierarchical, or if there are no related pages, nothing is displayed.

A hook is available to filter the title: `dmg_related_pages_widget_title`.

For example, to change the title on a single page or post, you could add this to your functions.php file:


`function myTitleFilter( $title )
{
	if( is_singular() )
	{
		return "<strong>$title</strong>";
	}
	else
	{
		return $title;		
	}
}
add_filter( 'dmg_related_pages_widget_title' , 'myTitleFilter');`

More information about this plugin can be found at <http://dancoded.com/wordpress-plugins/related-pages-widget/>.

== Adding CSS Class(es) ==

Enter strings, either space or comma seperated, which will be applied as CSS classes to the widget wrapper and/or the list wrapper. These classes are sanitized using the `sanitize_html_class()` function built in to Wordpress.

== Make the Title a link ==

Enter a valid URL to make the title a link.

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/dmg-related-pages-widget` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' page in the WordPress admin area
1. Drag onto any active sidebar on the 'Appearance > Widgets' page

== Changelog ==
= 1.1.1 =
Corrected typo readme.txt
= 1.1 = 
Added Title URL field to make title a link

Tidied up readme

Tested in WP 4.6

= 1.0.2 = 
Corrected Title!

= 1.0.1 = 
Added screenshot

= 1.0 =
* Initial version