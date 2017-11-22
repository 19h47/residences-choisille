import './assets/stylesheets/styles.scss';
import App from './app/modules/app';
import guid from './app/modules/guid';
import Menu from './app/modules/Menu';
import Home from './app/modules/Home';
import './app/modules/residence';

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
