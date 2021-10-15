import { PeekaBoo } from './components/site-header';

global.addEventListener( 'DOMContentLoaded', () => {
	// Sticky site header.
	new PeekaBoo( document.querySelector( '.site-header--peekaboo' ) );
} );
