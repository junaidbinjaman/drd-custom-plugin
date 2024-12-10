<?php
/**
 * Elementor form custom action that insert a new post on successful submission.
 *
 * The codes in this file creates a new custom action for elementor form.
 * The action insert a new post on successful form submission.
 *
 * @link https://junaidbinjaman.com
 * @since 1.0.0
 *
 * @package Drd
 * @subpackage Drd/admin/elementor-form-action/insert-new-port.php
 */

/**
 * Elementor form New Post action.
 *
 * Custom Elementor form action which insert a new post on the successful submission.
 *
 * @since 1.0.0
 */
class New_Post_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {

	/**
	 * Get action name.
	 *
	 * Retrieve New Post action name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_name(): string {
		return 'drd_new_post';
	}

	/**
	 * Get action label.
	 *
	 * Retrieve New Post action label.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Create New Post', 'elementor-forms-sendy-action' );
	}

	/**
	 * Register action controls.
	 *
	 * Add input fields to allow the user to customize the action settings.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Widget_Base $widget The widget to accept action settings .
	 */
	public function register_settings_section( $widget ): void {

		$widget->start_controls_section(
			'section_dynamic_fields',
			array(
				'label'     => esc_html__( 'Dynamic Meta Fields', 'drd' ),
				'condition' => array(
					'submit_actions' => $this->get_name(),
				),
			)
		);

		// Select the custom post type.
		$widget->add_control(
			'selected_post_type',
			array(
				'label'   => esc_html__( 'Select Post Type', 'drd' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => get_post_types( null, 'names' ),
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Run action.
	 *
	 * Runs the Sendy action after form submission.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record  $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ): void {

		$settings = $record->get( 'form_settings' );

		// Make sure that there is a Sendy installation URL.
		if ( empty( $settings['sendy_url'] ) ) {
			return;
		}

		// Make sure that there is a Sendy list ID.
		if ( empty( $settings['sendy_list'] ) ) {
			return;
		}

		// Make sure that there is a Sendy email field ID (required by Sendy to subscribe users).
		if ( empty( $settings['sendy_email_field'] ) ) {
			return;
		}

		// Get submitted form data.
		$raw_fields = $record->get( 'fields' );

		// Normalize form data.
		$fields = array();
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		// Make sure the user entered an email (required by Sendy to subscribe users).
		if ( empty( $fields[ $settings['sendy_email_field'] ] ) ) {
			return;
		}

		// Request data based on the param list at https://sendy.co/api
		$sendy_data = array(
			'email'     => $fields[ $settings['sendy_email_field'] ],
			'list'      => $settings['sendy_list'],
			'ipaddress' => \ElementorPro\Core\Utils::get_client_ip(),
			'referrer'  => isset( $_POST['referrer'] ) ? $_POST['referrer'] : '',
		);

		// Add name if field is mapped.
		if ( empty( $fields[ $settings['sendy_name_field'] ] ) ) {
			$sendy_data['name'] = $fields[ $settings['sendy_name_field'] ];
		}

		// Send the request.
		wp_remote_post(
			$settings['sendy_url'] . 'subscribe',
			array(
				'body' => $sendy_data,
			)
		);
	}

	/**
	 * On export.
	 *
	 * Clears Sendy form settings/fields when exporting.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param array $element
	 */
	public function on_export( $element ): array {

		unset(
			$element['sendy_url'],
			$element['sendy_list'],
			$element['sendy_email_field'],
			$element['sendy_name_field']
		);

		return $element;
	}
}
