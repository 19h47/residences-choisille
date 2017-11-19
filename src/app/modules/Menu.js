import App from './app';

const $body = $('body');


class Menu {
	constructor() {
		this.is_open = $body.hasClass('menu--is-open');
	}


	/**
	 * Menu.setupEvents
	 */
	setupEvents() {
		$(document)
			.on('click.menu', '.js-toggle-menu-button', this.toggle.bind(this))
			// .on('click.menu', '.js-toggle-menu-backdrop', this.toggle.bind(this))
			.on('keydown.menu', (e) => {
				if (e.which === 27) {
					this.close();
				}
			});
	}


	/**
	 * Menu.toggle
	 */
	toggle() {
		if (this.is_open) {
			return this.close();
		}

		return this.open();
	}


	/**
	 * Menu.open
	 */
	open() {
		if (this.is_open) {
			return;
		}

		this.is_open = true;


		$body
			.addClass('menu--is-open')
			.trigger('open.menu');

		// When menu is open, disable scroll
		App.disableScroll();
	}


	/**
	 * Menu.close
	 */
	close() {
		if (!this.is_open) {
			return;
		}

		this.is_open = false;

		$body
			.removeClass('menu--is-open')
			.trigger('close.menu');

		// When menu is closed, enable scroll
		App.enableScroll();
	}
}


export default Menu;
