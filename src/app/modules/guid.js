const classes = require('dom-classes');
const select = require('dom-select');

/**
 * Guid
 */
const guid = () => {
	// show/hide guides with CMD+;
	document.addEventListener('keydown', (e) => {
		if ((e.metaKey || e.ctrlKey) && e.keyCode === 186) {
			classes.toggle(select('.Guid'), 'display-xs-none');
		}
	});
};

export default guid;
