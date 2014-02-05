<?php
/**
 * Plugin Name: Simple Page Hierarchy Widget
 * Plugin URI: http://joshmallard.com
 * Description: Adds a simple page hierarchy widget. If it doesn't do what you want out of the box, this plugin isn't for you. 
 * Version: 1.0.3
 * Author: Josh Mallard
 * Author URI: http://joshmallard.com
 * Text Domain: simple-page-hierarchy
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class GB_Page_Hierarchy_Widget extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// Widget information
		parent::__construct(
			'gb-simple-page-hierarchy',
			__( 'Simple Page Hierarchy', 'simple-page-hierarchy' ),
			array(
				'classname'  => 'gb-page-hierarchy-widget',
				'description' => __( 'Adds a page hierarchy list to the sidebar. If it&apos;s not what you want out of the box, this plugin isn&apos;t for you.', 'simple-page-hierarchy' )
			)
		);

	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {
		
		extract( $args, EXTR_SKIP );

		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		load_plugin_textdomain( 'simple-page-hierarchy', false, plugin_dir_path( __FILE__ ) . 'lang/' );

	} // end widget_textdomain

} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("GB_Page_Hierarchy_Widget");' ) );
