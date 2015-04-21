<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.imajize.com
 * @since      1.0.0
 *
 * @package    Imajize
 * @subpackage Imajize/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Imajize
 * @subpackage Imajize/public
 * @author     Jasper Michalczik <support@imajize.com>
 */
class Imajize_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Imajize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Imajize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/imajize-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Imajize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Imajize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/imajize-public.js', array( 'jquery' ), $this->version, false );

	}
  
  /**
   * Get the spin view URL for the current page
   */
  public function set_spin_view_url() {
    
    global $post;
    
    $post_id = isset( $post->ID ) ? $post->ID : 0;
    
    $spin_view_url = get_post_meta( $post_id, '_spin_view_url', true );
    
    $this->spin_view_url = empty( $spin_view_url ) ? false : $spin_view_url;
    
  }

  /**
   * Set a spin viewer instead of featured image in the single product
   *
   * @param $html
   * @return mixed
   */
  public function set_featured_spin_view( $html ) {
    
    global $post, $woocommerce;
    
    if ( ! $this->spin_view_url ) return $html;
    
    // Evaluate size
    if ( function_exists( 'wc_get_image_size' ) ) {
      $size	= wc_get_image_size('shop_single');
    } else {
      $size	= $woocommerce->get_image_size('shop_single');
    }
    
    $width  = $size['width'];
    $height = $size['height'];
    $ratio = ($width / $height);
    
    ob_start();
    
    $spin_view_url = $this->spin_view_url
    
    ?>
    
    <div style="padding: <?php echo $ratio * 100 ?>% 0 0 0; width: 100%; position: relative;"
         class="woocommerce-main-image">
      <iframe src="<?php echo $spin_view_url; ?>"
              id="imajize_<?php echo $spin_view_url; ?>"
              frameborder="0"
              scrolling="no"
              style="background-color: transparent; position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
              allowfullscreen>
      </iframe>
    </div>
    
    <?php
    
    $html = ob_get_clean();
    
    return $html;
    
  }
  
}
