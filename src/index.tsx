import { registerBlockVariation } from '@wordpress/blocks';
import { LineIcon } from './icons/line';

registerBlockVariation( 'core/social-link', {
	name: 'line',
	title: 'LINE',
	icon: LineIcon,
	attributes: { service: 'line' },
} );
