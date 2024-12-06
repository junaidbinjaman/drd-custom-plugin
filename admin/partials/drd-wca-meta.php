<?php
/**
 * Wholesale customer meta box
 *
 * This file contains the code for wholesale customer meta box.
 * This file contains codestar framework's code for meta box
 *
 * The wac stands for wholesale customer application
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Drd
 * @subpackage Drd/admin/drd-wac-meta.php
 */

// Control core classes for avoid errors.
if ( class_exists( 'CSF' ) ) {

	//
	// Set a unique slug-like ID.
	$prefix = 'wac_meta_fields';

	//
	// Create a metabox.
	CSF::createMetabox(
		$prefix,
		array(
			'title'     => 'Wholesale Application Meta Fields',
			'post_type' => 'wholesaleapplication',
		)
	);

	//
	// Create a section.
	CSF::createSection(
		$prefix,
		array(
			'fields' => array(

				array(
					'id'    => 'first_name',
					'type'  => 'text',
					'title' => __( 'First Name', 'drd' ),
				),
				array(
					'id'    => 'last_name',
					'type'  => 'text',
					'title' => __( 'Last Name', 'drd' ),
				),
				array(
					'id'    => 'email',
					'type'  => 'text',
					'title' => __( 'Email', 'drd' ),
				),
				array(
					'id'    => 'phone',
					'type'  => 'text',
					'title' => __( 'Phone', 'drd' ),
				),
				array(
					'type'    => 'subheading',
					'content' => __( 'Billing Address', 'drd' ),
				),
				array(
					'id'    => 'billing_country',
					'type'  => 'text',
					'title' => __( 'Country', 'drd' ),
				),
				array(
					'id'    => 'billing_address_line_1',
					'type'  => 'text',
					'title' => __( 'Address Line 1', 'drd' ),
				),
				array(
					'id'    => 'billing_address_line_2',
					'type'  => 'text',
					'title' => __( 'Address Line 2', 'drd' ),
				),
				array(
					'id'    => 'billing_city',
					'type'  => 'text',
					'title' => __( 'City', 'drd' ),
				),
				array(
					'id'    => 'billing_postal_code',
					'type'  => 'text',
					'title' => __( 'Postal Code', 'drd' ),
				),
				array(
					'type'    => 'subheading',
					'content' => __( 'Shipping Address', 'drd' ),
				),
				array(
					'id'    => 'shipping_country',
					'type'  => 'text',
					'title' => __( 'Country', 'drd' ),
				),
				array(
					'id'    => 'shipping_address_line_1',
					'type'  => 'text',
					'title' => __( 'Address Line 1', 'drd' ),
				),
				array(
					'id'    => 'shipping_address_line_2',
					'type'  => 'text',
					'title' => __( 'Address Line 2', 'drd' ),
				),
				array(
					'id'    => 'shipping_city',
					'type'  => 'text',
					'title' => __( 'City', 'drd' ),
				),
				array(
					'id'    => 'shipping_postal_code',
					'type'  => 'text',
					'title' => __( 'Postal Code', 'drd' ),
				),
				array(
					'id'    => 'sellers_type',
					'type'  => 'text',
					'title' => __( 'Seller\'s Type', 'drd' ),
				),
				array(
					'id'    => 'practitioner_type',
					'type'  => 'text',
					'title' => __( 'Practitioner Type', 'drd' ),
				),
				array(
					'id'    => 'title',
					'type'  => 'text',
					'title' => __( 'Title', 'drd' ),
				),
				array(
					'id'    => 'website',
					'type'  => 'text',
					'title' => __( 'Title', 'drd' ),
				),
				array(
					'id'    => 'article',
					'type'  => 'textarea',
					'title' => __( 'Tell us about your practice', 'drd' ),
				),
				array(
					'id'    => 'notes',
					'type'  => 'textarea',
					'title' => __( 'Notes', 'drd' ),
				),
				array(
					'type'     => 'callback',
					'function' => 'drd_wca_action_button_callback',
				),
			),
		)
	);
}

/**
 * Action button callback function.
 *
 * The function shows the action buttons.
 * The existing button set doesn't fullfil our need.
 * That;s why we are using a custom callback to print the button
 *
 * @return void
 */
function drd_wca_action_button_callback() {
	?>
	<a href="#" class="drd-application-approval-btn button button-primary">Approve</a>
	<a href="#" class="drd-application-rejection-btn button button-primary">Reject</a>
	<?php
}
