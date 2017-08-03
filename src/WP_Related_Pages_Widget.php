<?php
Namespace DMG\WP_Related_Pages_Widget;

/*
	Related pages widget class.

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


Use DMG\WP_Widget_Base\WP_Widget_Base;


class WP_Related_Pages_Widget extends WP_Widget_Base
{
	public function __construct()
	{
		// Instantiate the parent object
		parent::__construct( 
			'dmg_related_pages_widget',
			__('DMG Related Page List'), 
			[
				'classname' => 'widget_related_pages', 
				'description' => __( "Lists the child and/or sibling pages of the current page.")
			] 
		);
	}



	public function widget( $args, $instance )
	{
		global $wp_query;

		// Variables to hold page list items
		$page_list = '';
		$children = '';
		$siblings = '';

		// Check post type is hierarchical
		$post_type = get_post_type( $wp_query->post->ID );	

		if( !is_post_type_hierarchical( $post_type ) )
		{
			return;
		}

		if( $instance['show_children'] )
		{
			$children = wp_list_pages("post_type={$post_type}&title_li=&child_of={$wp_query->post->ID}&echo=0&depth={$instance['child_levels']}");
		}

		if( $instance['show_siblings'] and $wp_query->post->post_parent == 0 )
		{
			// Top level page
			$siblings = wp_list_pages("post_type={$post_type}&title_li=&child_of=0&echo=0&depth=1");
		}
		elseif( $instance['show_siblings'] )
		{
			// Lower level page
			$siblings = wp_list_pages("post_type={$post_type}&title_li=&child_of={$wp_query->post->post_parent}&echo=0&depth=1");
		}
		
		// Build the list
		if( !empty( $children ) and !empty( $siblings ) )
		{
			// Find position of end list item tag
			$pos = strpos($siblings, '</li>', strpos($siblings, 'current_page_item') );

			// Insert children before end tag
			$page_list = substr($siblings, 0, $pos) . '<ul class="children">' . $children . '</ul>' . substr($siblings, $pos);
		}
		else
		{
			$page_list = $siblings . $children;
		}

		$args['before_widget'] = $this->addWidgetClass( $args['before_widget'], $instance['widget_class'] );
		
		if (!empty($page_list)) 
		{	
			echo $args['before_widget'];
			echo $this->getTitle( $args, $instance, $this->id_base . '_title' );
			echo '<ul class="' . $instance['list_class'] . '">';
			echo $page_list;
			echo '</ul>';
			echo $args['after_widget'];
		}
		
	}


	
	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title'] 			= $this->sanitizeTitle($new_instance['title']);
		$instance['title_url'] 		= esc_url($new_instance['title_url']);
		$instance['show_title'] 	= $this->sanitizeBoolean($new_instance['show_title']);
		$instance['list_class'] 	= $this->sanitizeCSSClasses($new_instance['list_class']);
		$instance['widget_class'] 	= $this->sanitizeCSSClasses($new_instance['widget_class']);
		$instance['show_siblings'] 	= $this->sanitizeBoolean($new_instance['show_siblings']);
		$instance['show_children'] 	= $this->sanitizeBoolean($new_instance['show_children']);
		$instance['child_levels'] 	= $this->sanitizeInteger($new_instance['child_levels'], 1, null, 1 );

		$this->deleteCacheOptions();

		return $instance;
	}



	public function form( $instance )
	{
		$instance = wp_parse_args( (array) $instance, ['title' => '', 'list_class' => '', 'widget_class' => '', 'show_siblings' => 1, 'show_children' => 1, 'title_url' => '', 'show_title' => 1,'child_levels' => 1] );

		$this->textControl( 'title', 'Title:', $this->sanitizeTitle($instance['title']) );

		$this->booleanControl( 'show_siblings', 'Show siblings', $this->sanitizeBoolean( $instance['show_siblings'] ) );

		$this->booleanControl( 'show_children', 'Show children', $this->sanitizeBoolean( $instance['show_children'] ) );

		$this->openAdvancedSection();

			$this->numberControl( 'child_levels', 'Depth of children to show:', $this->sanitizeInteger($instance['child_levels'], 1, null, 1 ), 1 );

			$this->textControl( 'list_class', 'CSS class(es) applied to list wrapper:', $this->sanitizeCSSClasses( $instance['list_class'] ) );

			$this->textControl( 'widget_class', 'CSS class(es) applied to widget wrapper:', $this->sanitizeCSSClasses( $instance['widget_class'] ) );

			$this->textControl( 'title_url', 'URL for the title (make the title a link):', esc_url( $instance['title_url'] ) );

			$this->booleanControl( 'show_title', 'Show the Title', $this->sanitizeBoolean( $instance['show_title'] ) );

		$this->closeAdvancedSection();
	}
}