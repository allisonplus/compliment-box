<?php
/**
 * Compliment Box Settings.
 *
 * @since   0.0.0
 * @package Compliment_Box
 */

require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';

/**
 * Compliment Box Settings class.
 *
 * @since 0.0.0
 */
class CB_Settings {
	/**
	 * Parent plugin class.
	 *
	 * @var    Compliment_Box
	 * @since  0.0.0
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $key = 'compliment_box_settings';

	/**
	 * Options page metabox ID.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $metabox_id = 'compliment_box_settings_metabox';

	/**
	 * Options Page title.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $title = '';

	/**
	 * Options Page hook.
	 *
	 * @var string
	 */
	protected $options_page = '';

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

		// Set our title.
		$this->title = esc_attr__( 'Compliment Box Settings', 'compliment-box' );
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {

		// Hook in our actions to the admin.
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
		
	}

	/**
	 * Register our setting to WP.
	 *
	 * @since  0.0.0
	 */
	public function admin_init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page.
	 *
	 * @since  0.0.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page(
			$this->title,
			$this->title,
			'manage_options',
			$this->key,
			array( $this, 'admin_page_display' )
		);

		// Include CMB CSS in the head to avoid FOUC.
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2.
	 *
	 * @since  0.0.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo esc_attr( $this->key ); ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  0.0.0
	 */
	public function add_options_page_metabox() {

		// Add our CMB2 metabox.
		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove.
				'key'   => 'options-page',
				'value' => array( $this->key ),
			),
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