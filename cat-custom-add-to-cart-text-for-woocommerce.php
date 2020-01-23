<?php
/**
 * Plugin Name: Custom Add To Cart Text For WooCommerce
 * Plugin URI: http://www.tychesoftwares.com/store/premium-plugins
 * Description: A plugin which allows you to change the add to cart button text on single product page.
 * Version: 1.0
 * Requires at least: 5.2
 * Requires PHP:4.3
 * Author: Shasvat Shah
 * Author URI: http://www.tychesoftwares.com/
 * Text Domain: cat-addtocart-text
 * License: GPLv2
 * Domain Path: /languages/
 *
 * @package Custom Add To Cart Text For WooCommerce
 */

/**
 * Exit if accessed directly
 */
defined( 'ABSPATH' ) || exit;

/**
 * Main class
 */
class Cat_Custom_Add_To_Cart_Text {

	/**
	 * Constructer
	 */
	public function __construct() {

		$this->atc_define_constants();
		$this->atc_hooks();

	}
	/**
	 * Function for defining constatnts
	 */
	public function atc_define_constants() {
		define( 'ATC_VERSION', '1.0' );
	}

	/**
	 * This function contains all the hooks for the plugin.
	 */
	public function atc_hooks() {

		add_action( 'woocommerce_product_options_advanced', array( $this, 'atc_addtocart_name' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'atc_save_fields' ), 10, 2 );
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'atc_custom_cart_button_text' ), 10, 2 );
	}
	/**
	 * Function for custom field on product page
	 */
	public function atc_addtocart_name() {
		?>

		<div class= 'options_group'>
		<?php
			woocommerce_wp_text_input(
				array(
					'id'          => 'atc_name',
					'value'       => get_post_meta( get_the_ID(), 'atc_name', true ),
					'label'       => __( 'Add To Cart Name', 'cat-addtocart-text' ),
					'placeholder' => '',
					'desc_tip'    => 'true',
					'description' => __( 'Enter Name to show in place of add to cart.', 'cat-addtocart-text' ),
				)
			);
		?>
		</div>
		<?php
	}

	/**
	 * Function to save the cart button text
	 *
	 * @param int    $id ID.
	 * @param object $post Post.
	 */
	public function atc_save_fields( $id, $post ) {

		if ( ! empty( $_POST['atc_name'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			update_post_meta( $id, 'atc_name', sanitize_text_field( wp_unslash( $_POST['atc_name'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
		}
	}

	/**
	 * Function for changing the text of cart button.
	 *
	 * @param string $addtocart Add to cart Text.
	 */
	public function atc_custom_cart_button_text( $addtocart ) {

		$addtocart = get_post_meta( get_the_ID(), 'atc_name', true );
		if ( '' !== $addtocart ) {
			return $addtocart;
		}
		return $addtocart;
	}
}

new Cat_Custom_Add_To_Cart_Text();
