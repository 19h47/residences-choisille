const $body = $('body');


class Home {
	constructor() {
		this.$header = null;
		this.$content = null;
		this.$panel = {
			right: null,
			left: null,
		};

		this.setupEvents();
	}


	/**
	 * Home.setupEvents
	 */
	setupEvents() {
		console.info('Home.setupEvents');
		$(document)
			.on('mouseenter mouseleave', '.js-home-link', Home.toggle.bind(this))
			.on('mouseenter mouseleave', '.js-home-contact', Home.toggle.bind(this))
			.on('keydown.home', (e) => {
				if (e.which === 27) {
					this.close();
				}
			});
	}


	/**
	 * Home.toggle
	 */
	static toggle(e) {
		console.info('Home.toggle');

		if (e.type === 'mouseleave') {
			return Home.close(e);
		}

		if (e.type === 'mouseenter') {
			return Home.open(e);
		}

		return false;
	}


	/**
	 * Home.open
	 */
	static open(e) {
		console.info('Home.open');

		if (e.currentTarget.dataset.open === true) {
			return;
		}

		e.currentTarget.dataset.open = true;

		return $body
			.addClass(`panel-${e.currentTarget.dataset.position}--is-open`)
			.trigger('open.home');
	}


	/**
	 * Home.close
	 */
	static close(e) {
		console.info('Home.close');

		if (e.currentTarget.dataset.open === false) {
			return;
		}

		e.currentTarget.dataset.open = false;

		return $body
			.removeClass(`panel-${e.currentTarget.dataset.position}--is-open`)
			.trigger('close.home');
	}
}


export default Home;
