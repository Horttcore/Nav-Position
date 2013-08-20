<?php
/*
Plugin Name: Nav Position
Plugin URL:
Description:
Version: 0.2
Author: Ralf Hortt
Author URL: http://horttcore.de/
*/



/**
 * Security, checks if WordPress is running
 **/
if ( !function_exists( 'add_action' ) ) :
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
endif;



/**
*  Plugin
*/
class Nav_Position
{



	/**
	 * Constructor
	 *
	 **/
	function __construct()
	{
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_print_scripts-post.php', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_print_styles-post.php', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_ajax_save_nav_position', array( $this, 'save_nav_position') );
	}



	/**
	 * Add meta boxes
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function add_meta_boxes()
	{
		add_meta_box( 'position' ,__( 'Position', 'nav-position' ), array( $this, 'meta_box_position' ), 'page', 'advanced', 'high' );
	}



	/**
	 * Enqueue Javascript
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function enqueue_scripts()
	{
		wp_register_script( 'nav-position', plugins_url( 'javascript/nav-position.js' , __FILE__ ), array('jquery') );
	}



	/**
	 * Enqueue CSS
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function enqueue_styles()
	{
		wp_enqueue_style( 'nav-position', plugins_url( 'css/nav-position.css' , __FILE__ ) );
	}



	/**
	 * Position of the nav
	 *
	 * @access public
	 * @param obj $post Post
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function meta_box_position( $post )
	{
		wp_enqueue_script( 'nav-position' );
		$nav_position = get_post_meta( $post->ID, '_nav-position', TRUE );
		if ( defined( 'Nav_Position_Image' ) AND defined( 'Nav_Position_Image_Width' ) AND defined( 'Nav_Position_Image_Height' ) )
			$style = 'style="' . apply_filters( 'nav-position-style', 'background-image:url(' . Nav_Position_Image . '); width: ' . Nav_Position_Image_Width . '; height: ' . Nav_Position_Image_Height . '"' );
		?>
		<div class="nav-position-viewport">

			<div class="nav-position-background" <?php echo $style ?> >

				<div class="nav-position-title" style="left:<?php echo $nav_position['left'] ?>px; top: <?php echo $nav_position['top'] ?>px">
					<?php echo apply_filters( 'the_title', $post->post_title ) ?>
				</div>

			</div>

		</div>
		<?php
	}



	/**
	 * Save nav position
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function save_nav_position()
	{
		if ( $_POST['post_id'] && $_POST['left'] && $_POST['top'] ) :

			update_post_meta( $_POST['post_id'], '_nav-position', array( 'left' => $_POST['left'], 'top' => $_POST['top'] ) );

			die( $_POST['left'] . ':' . $_POST['top']);

		else :

			die( __('No Coordinates', 'nav-position' ) );

		endif;
	}



}

new Nav_Position;