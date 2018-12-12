import 'stylesheets/styles.scss';

import guid from 'Common/guid';
import Menu from 'Common/Menu';

import App from 'Blocks/App';
import Home from 'Blocks/Home';

import 'Blocks/residence';

require.context('svg/', true);
require.context('jpg/', true);
require.context('png/', true);
require.context('icons/', true);

window.app = new App();

guid();

function makeHome() {
	return new Home();
}

makeHome();

// Menu
const MainMenu = new Menu();
MainMenu.setupEvents();

console.log('Yo!');
