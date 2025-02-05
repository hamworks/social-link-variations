<?php
/**
 * Plugin Name: Social Link Variations
 * Description: Add social link block variations.
 * Version: 0.0.1
 * Author: HAMWORKS
 * License: GPL-2.0+
 * GitHub Plugin URI: https://github.com/hamworks/social-link-variations
 * Release Asset: true
 *
 * @package social-link-variations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'enqueue_block_editor_assets',
	function () {
		$asset_file = include __DIR__ . '/build/index.asset.php';
		wp_enqueue_script(
			'social-link-variations',
			plugin_dir_url( __FILE__ ) . '/build/index.js',
			$asset_file['dependencies'],
			filemtime( __DIR__ . '/build/index.js' ),
			true
		);
	}
);

add_action(
	'enqueue_block_assets',
	function () {
	}
);
