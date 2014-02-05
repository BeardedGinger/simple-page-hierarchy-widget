<?php
/**
 * The queries and output for displaying the page hierarchy
 */

global $post;

$page_id = get_the_ID(); 
$args = array(
	'post_parent' => $page_id,
	'post_type' => 'page'
);

$parents = get_post_ancestors( $page_id );
$children = get_children( $args );
$top_parent = ($parents) ? $parents[count($parents)-1]: $post->ID;


/** 
 * Determine what needs to be displayed for this pages sidebar
 * depending on where it falls within the hierarchy
 */

if ( $parents || $children ) {
	
	$widget_string = $before_widget;
	ob_start();
	
	$widget_page_hierarchy = '<ul>';
	if ( !$parents && $children ) {
		
		// If this is a top-level page 
		$widget_title = '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
		
		foreach( $children as $child ) {
			$widget_page_hierarchy .= '<li><a href="' . get_permalink( $child->ID ) . '">' . get_the_title( $child->ID ) . '</a></li>';
		}
		
	} elseif ( $parents && $children ) {
		
		// If this is a mid-level page with both children and parents
		$widget_title = '<a href="' . get_permalink( $top_parent ) . '">' . get_the_title( $top_parent ) . '</a>';
		
		$args = array(
			'post_parent' => $top_parent,
			'post_type' => 'page'
		);
		
		$children = get_children( $args );
		foreach( $children as $child ) {
			
			// If this is the current page with children, show the children as a submenu
			if( $child->ID == $page_id ) {
				$widget_page_hierarchy .= '<li><a href="' . get_permalink( $child->ID ) . '">' . get_the_title( $child->ID ) . '</a></li>';
				$widget_page_hierarchy .= '<ul class="submenu">';
				
				$args = array(
					'post_parent' => $child->ID
				);
				
				$grandchildren = get_children( $args );
				
				foreach( $grandchildren as $grandchild ) {
					$widget_page_hierarchy .= '<li><a href="' . get_permalink( $grandchild->ID ) . '">' . get_the_title( $grandchild->ID ) . '</a></li>';
				}
				$widget_page_hierarchy .= '</ul>';
				
			} else {
			
				// If this is just a child of the parent, display a normal link
				$widget_page_hierarchy .= '<li><a href="' . get_permalink( $child->ID ) . '">' . get_the_title( $child->ID ) . '</a></li>';
			}
		}
		
	} else {
		
		// If this is a grandchild page... and we don't have any great-grandchildren in this plugin
		$widget_title = '<a href="' . get_permalink( $top_parent ) . '">' . get_the_title( $top_parent ) . '</a>';
		
		$args = array(
			'post_parent' => $top_parent,
			'post_type' => 'page'
		);
		
		$children = get_children( $args );
		foreach( $children as $child ) {
			
			// If this is the current page with children, show the children as a submenu
			if( $child->ID == $post->post_parent ) {
				$widget_page_hierarchy .= '<li><a href="' . get_permalink( $child->ID ) . '">' . get_the_title( $child->ID ) . '</a></li>';
				$widget_page_hierarchy .= '<ul class="submenu">';
				
				$args = array(
					'post_parent' => $child->ID,
					'post_type' => 'page'
				);
				
				$grandchildren = get_children( $args );
				
				foreach( $grandchildren as $grandchild ) {
					$widget_page_hierarchy .= '<li><a href="' . get_permalink( $grandchild->ID ) . '">' . get_the_title( $grandchild->ID ) . '</a></li>';
				}
				$widget_page_hierarchy .= '</ul>';
				
			} else {
			
				// If this is just a child of the parent, display a normal link
				$widget_page_hierarchy .= '<li><a href="' . get_permalink( $child->ID ) . '">' . get_the_title( $child->ID ) . '</a></li>';
			}
		}
		
	}
	
	$widget_page_hierarchy .= '</ul>';
	
	echo $before_title . $widget_title . $after_title;
	echo $widget_page_hierarchy;
	
	$widget_string .= ob_get_clean();
	$widget_string .= $after_widget;
	
	print $widget_string;
}