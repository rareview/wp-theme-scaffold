/**
 * Class for PeekaBoo header
 */
class PeekaBoo {
	/**
	 * Establish our blueprint.
	 *
	 * @param {Element} headerEl Element to target.
	 */
	constructor( headerEl ) {
		this.headerEl = headerEl;

		// Bail early.
		if ( ! this.headerEl || typeof this.headerEl !== 'object' ) {
			return;
		}

		const body = document.body;
		const scrollUp = 'scroll-up';
		const scrollDown = 'scroll-down';
		let lastScroll = 0;
		let { height: headerOffset } = this.headerEl.getBoundingClientRect();
		const notification = document.querySelector( '.site-notification' );
		const wpAdminBar = document.getElementById( 'wpadminbar' );

		// If we have a notification then let's account for it.
		if ( notification ) {
			const { height: notificationHeight } = notification.getBoundingClientRect();
			headerOffset = headerOffset + notificationHeight;
		}

		// If the WP Admin Bar is there, then let's account for it.
		if ( wpAdminBar ) {
			const { height: wpAdminBarHeight } = wpAdminBar.getBoundingClientRect();
			headerOffset = headerOffset + wpAdminBarHeight;
		}

		global.addEventListener( 'scroll', () => {
			const currentScroll = window.pageYOffset;

			if ( currentScroll <= headerOffset ) {
				body.classList.remove( scrollUp );
				this.headerEl.classList.remove( 'is-sticky' );
				return;
			}

			if ( currentScroll > lastScroll && ! body.classList.contains( scrollDown ) ) {
				// down
				body.classList.remove( scrollUp );
				body.classList.add( scrollDown );
				this.headerEl.classList.add( 'is-sticky' );
			} else if (
				currentScroll < lastScroll &&
				body.classList.contains( scrollDown )
			) {
				// up
				body.classList.remove( scrollDown );
				body.classList.add( scrollUp );
				this.headerEl.classList.add( 'is-sticky' );
			}
			lastScroll = currentScroll;
		} );
	}
}

export default PeekaBoo;