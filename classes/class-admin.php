<?php
/**
 * Init admin functions.
 *
 * @package wp-gutenberg-site-options
 */

declare( strict_types = 1 );

namespace WP_GSO;

final class Admin {

	/**
	 * Static method to initialize the class
	 */
	public static function init() {
		static $instance = null;

		if (null === $instance) {
				$instance = new self();
		}
		return $instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->_setup_hooks();
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	private function _setup_hooks(): void {
		add_action( 'admin_menu', [ $this, 'register_options_page' ] );
	}

	public function register_options_page() {
		$page_hook_suffix = add_options_page(
			__( 'Site Options', 'wp-gutenberg-site-options' ),
			__( 'Site Options', 'wp-gutenberg-site-options' ),
			'manage_options',
			'wp-gutenberg-site-options-settings',
			[ $this, 'options_page_callback' ]
		);

		add_action(
			"admin_print_scripts-{$page_hook_suffix}",
			[ $this, 'add_options_assets']
		);
	}

  /**
   * Handle the markup output for our React app to mount.
   */
	public function options_page_callback(): void {
		echo wp_kses(
      '<div id="wp-gutenberg-site-options"></div>',
			[ 'div' => [ 'class' => [], 'id' => [] ] ]
		);
	}

  /**
   * Handle all of the assets for the site options js.
   */
	public function add_options_assets(): void {
    // Path to your assets file.
    $assets_file_path = WP_GSO_DIR . '/build/index.asset.php';
    $dependencies     = [];
    $hash             = [];

    // Check if the file exists.
    // @todo: this could be a helper function.
    if ( file_exists( $assets_file_path ) ) {
        // Include the file and get its contents.
        $asset_data = include $assets_file_path;

        // Check if 'dependencies' key exists.
        if ( isset( $asset_data['dependencies'] ) ) {
            $dependencies = $asset_data['dependencies'];
        }

        // Check if the 'version' key exists.
        if ( isset( $asset_data['version'] ) ) {
            $hash = $asset_data['version'];
        }
    }

		wp_enqueue_script(
			'wp-gutenberg-site-options',
			WP_GSO_BUILD_PATH . '/build/index.js',
			$dependencies,
			$hash,
			[
				'strategy' => 'async',
				'in_footer' => true
			]
		);

    wp_enqueue_style(
			'wp-gutenberg-site-options',
			WP_GSO_BUILD_PATH . '/build/index.css',
			[],
			$hash
		);

    // Enqueue the core block editor styles.
    wp_enqueue_style( 'wp-edit-blocks' );
	}
}
