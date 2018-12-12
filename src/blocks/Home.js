const $body = $('body');


class Home {
	constructor() {
		this.$header = null;
		this.$content = null;
		this.$panel = {
			right: null,
			left: null,
		};

		this.positions = [];
		document.querySelectorAll('.js-home-link').forEach((link) => {
			this.positions.push(link.dataset.position);
		});

		this.setupEvents();
		this.open('left', 'false');
	}


	/**
	 * Home.setupEvents
	 */
	setupEvents() {
		// console.info('Home.setupEvents');

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
		// console.info('Home.toggle');

		if (e.type === 'mouseleave') {
			return this.close(e.currentTarget.dataset.position, e.currentTarget.dataset.open);
		}

		if (e.type === 'mouseenter') {
			return this.open(e.currentTarget.dataset.position, e.currentTarget.dataset.open);
		}

		return false;
	}


	/**
	 * Home.open
	 *
	 * @param str 	position
	 * @param bol	state
	 */
	open(position, state) {
		// console.info('Home.open');

		if (state === true) {
			return;
		}

		// state = true;
		this.positions.forEach((p) => {
			$body.removeClass(`panel-${p}--is-open`);
		});

		$body
			.addClass(`panel-${position}--is-open`)
			.trigger('open.home');
	}


	/**
	 * Home.close
	 *
	 * @param str 	position
	 * @param bol	state
	 */
	close(position, state) {
		// console.info('Home.close');

		if (state === false) {
			return;
		}

		// state = false;

		this.positions.forEach((p) => {
			$body.removeClass(`panel-${p}--is-open`);
		});

		$body
			.removeClass(`panel-${position}--is-open`)
			.trigger('close.home');
	}
}


export default Home;
