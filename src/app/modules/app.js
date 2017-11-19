import config from '../../config';


/**
 * App
 */
class App {
	constructor() {
		console.log('%c🔥 Moka Création x 19h47 🔥', 'background-color:#000;color:#fff;padding:0.5em 1em;');
	}

	/**
	 * App.disableScroll
	 */
	static disableScroll() {
		const documentElementScrollLeft = document.documentElement.scrollLeft;
		const documentElementScrollTop = document.documentElement.scrollTop;
		const pageXOffset = self.pageXOffset;
		const pageYOffset = self.pageYOffset;
		const bodyScrollLeft = document.body.scrollLeft;
		const bodyScrollTop = document.body.scrollTop;


		// lock scroll position, but retain settings for later
		// http://stackoverflow.com/a/3656618
		config.body.scroll.left = pageXOffset || documentElementScrollLeft || bodyScrollLeft;

		config.body.scroll.top = pageYOffset || documentElementScrollTop || bodyScrollTop;

		config.html.css('overflow', 'hidden');

		App.resetScroll(config.body.scroll.left, config.body.scroll.top);
	}


	/**
	 * App.enableScroll
	 *
	 * @param  position
	 */
	static enableScroll(position) {
		// console.log('App.enableScroll');
		let resumeScroll = true;
		let currentPosition = position;

		if (typeof currentPosition === 'undefined') {
			currentPosition = config.body.scroll.top;
		}

		if (typeof currentPosition === 'boolean' && currentPosition === false) {
			resumeScroll = false;
		}

		// unlock scroll position
		// http://stackoverflow.com/a/3656618
		config.html.css('overflow', 'visible');

		// resume scroll position if possible
		if (resumeScroll) {
			App.resetScroll(config.body.scroll.left, currentPosition);
		}
	}


	/**
	 * App.resetScroll
	 *
	 * @param  positionX
	 * @param  positionY
	 */
	static resetScroll(positionX, positionY) {
		if (typeof positionX !== 'undefined') {
			config.body.scroll.left = parseInt(positionX, 10);
		}

		if (typeof positionY !== 'undefined') {
			config.body.scroll.top = parseInt(positionY, 10);
		}

		window.scrollTo(config.body.scroll.left, config.body.scroll.top);
	}
}

export default App;
