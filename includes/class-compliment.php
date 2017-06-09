<?php
/**
 * Compliment Box Compliment.
 *
 * @since   0.0.0
 * @package Compliment_Box
 */

require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';

/**
 * Compliment Box Compliment.
 *
 * @since 0.0.0
 */
class CB_Compliment {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   Compliment_Box
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  Compliment_Box $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Options page metabox ID.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $metabox_id = 'compliment_box_settings_metabox';

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {

		// Add submenu page.
		add_action( 'admin_menu', array( $this, 'add_menu' ) );

		// Init CMB2.
		add_action( 'cmb2_admin_init', array( $this, 'add_metabox' ) );
	}

	/** Add submenu page to Users. **/
	public function add_menu() {
		add_submenu_page(
			'users.php',
			'Compliment Box Settings',
			'Compliment Box',
			'manage_options',
			$this->key,
			array( $this, 'settings_display' )
		);
	}

	/**
	 * Settings page markup.
	 */
	public function settings_display() {
		?>
		<div class="wrap <?php echo esc_attr( $this->key ); ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php

	}

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function add_metabox() {

		// Add our CMB2 metabox.
		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
		) );

		// Add your fields here.
		$cmb->add_field( array(
			'name'    => __( 'Test Text', 'compliment-box' ),
			'desc'    => __( 'field description (optional)', 'compliment-box' ),
			'id'      => 'test_text', // No prefix needed.
			'type'    => 'text',
			'default' => __( 'Default Text', 'compliment-box' ),
		) );

	}

}
