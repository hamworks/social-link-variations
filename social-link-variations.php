<?php
/**
 * Plugin Name: Social Link Variations
 * Description: Add social link block variations.
 * Version: 0.1.1
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
		wp_enqueue_style(
			'social-link-variations-styles',
			plugin_dir_url( __FILE__ ) . '/build/style-index.css',
			array(),
			filemtime( __DIR__ . '/build/style-index.css' )
		);
	}
);


add_filter(
	'render_block',
	/**
	 * Filters the content of a single block.
	 *
	 * @param string $block_content The block content.
	 * @param array $block The full block, including name and attributes.
	 */
	function ( $block_content, $block ) {
		return match ( $block['blockName'] ) {
			'core/social-link' => social_link_render( $block_content, $block ),
			default => $block_content
		};
	},
	10,
	2
);

/**
 * LINE のアイコンをソーシャルアイコンで出力.
 *
 * @param string $block_content The block content.
 * @param array  $block The full block, including name and attributes.
 */
function social_link_render( $block_content, $block ) {
	if ( isset( $block['attrs']['service'] ) && 'line' === $block['attrs']['service'] ) {
		$icon = '
			<svg width="24" height="24" viewBox="0 0 24 24">
				<path d="M13.9336 9.91875V12.777C13.9336 12.8508 13.8773 12.907 13.8035 12.907H13.3465C13.3008 12.907 13.2621 12.8824 13.241 12.8543L11.9297 11.0859V12.7805C11.9297 12.8543 11.8734 12.9105 11.7996 12.9105H11.3426C11.2688 12.9105 11.2125 12.8543 11.2125 12.7805V9.92227C11.2125 9.84844 11.2688 9.79219 11.3426 9.79219H11.7961C11.8348 9.79219 11.8805 9.81328 11.9016 9.84844L13.2129 11.6168V9.92227C13.2129 9.84844 13.2691 9.79219 13.343 9.79219H13.8C13.8738 9.78867 13.9336 9.84844 13.9336 9.91524V9.91875ZM10.6395 9.78867H10.1824C10.1086 9.78867 10.0523 9.84492 10.0523 9.91875V12.777C10.0523 12.8508 10.1086 12.907 10.1824 12.907H10.6395C10.7133 12.907 10.7695 12.8508 10.7695 12.777V9.91875C10.7695 9.85195 10.7133 9.78867 10.6395 9.78867ZM9.53555 12.1828H8.28399V9.91875C8.28399 9.84492 8.22774 9.78867 8.15391 9.78867H7.69688C7.62305 9.78867 7.5668 9.84492 7.5668 9.91875V12.777C7.5668 12.8121 7.57735 12.8402 7.60196 12.8648C7.62657 12.8859 7.65469 12.9 7.68985 12.9H9.525C9.59883 12.9 9.65508 12.8437 9.65508 12.7699V12.3129C9.65508 12.2461 9.59883 12.1828 9.53203 12.1828H9.53555ZM16.3453 9.78867H14.5066C14.4398 9.78867 14.3766 9.84492 14.3766 9.91875V12.777C14.3766 12.8437 14.4328 12.907 14.5066 12.907H16.3418C16.4156 12.907 16.4719 12.8508 16.4719 12.777V12.3164C16.4719 12.2426 16.4156 12.1863 16.3418 12.1863H15.0937V11.7082H16.3418C16.4156 11.7082 16.4719 11.652 16.4719 11.5781V11.1176C16.4719 11.0438 16.4156 10.9875 16.3418 10.9875H15.0937V10.5059H16.3418C16.4156 10.5059 16.4719 10.4496 16.4719 10.3758V9.91875C16.4684 9.85195 16.4121 9.78867 16.3418 9.78867H16.3453ZM21 6.2836V17.7445C20.9965 19.5445 19.5199 21.0035 17.7164 21H6.25547C4.45547 20.9965 2.99649 19.5164 3.00001 17.7164V6.25547C3.00352 4.45547 4.4836 2.99649 6.2836 3.00001H17.7445C19.5445 3.00352 21.0035 4.48008 21 6.2836ZM18.525 11.209C18.525 8.27696 15.5824 5.88985 11.9719 5.88985C8.36133 5.88985 5.41875 8.27696 5.41875 11.209C5.41875 13.8352 7.74961 16.0394 10.8996 16.4578C11.666 16.623 11.5781 16.9043 11.4059 17.9379C11.3777 18.1031 11.2723 18.5848 11.9719 18.293C12.6715 18.0012 15.7441 16.0711 17.1223 14.4891C18.0715 13.4449 18.525 12.3867 18.525 11.216V11.209Z" />
            </svg>';

		$before        = explode( '<svg', $block_content );
		$after         = explode( '</svg>', $before[1] );
		$block_content = $before[0] . $icon . $after[1];

		if ( empty( $block['attrs']['label'] ) ) {
			$block_content = str_replace( __( 'Share Icon' ), 'LINE', $block_content );
		}
	}

	return $block_content;
}
