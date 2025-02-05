<?php
/**
 * Plugin Name: Social Link Variations
 * Description: Add inline typography controls to the editor.
 * Version: 0.4.2
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

		wp_enqueue_style(
			'social-link-variations-editor-styles',
			plugin_dir_url( __FILE__ ) . '/build/index.css',
			array(),
			filemtime( __DIR__ . '/build/index.css' )
		);

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
		wp_enqueue_style(
			'social-link-variations-styles',
			plugin_dir_url( __FILE__ ) . '/build/style-index.css',
			array(),
			filemtime( __DIR__ . '/build/style-index.css' )
		);
	}
);
