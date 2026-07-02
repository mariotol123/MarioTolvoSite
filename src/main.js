import './styles/main.scss';
import { initNavigation } from './components/navigation';
import { initScrambleButtons } from './components/scramble-buttons';

document.addEventListener('DOMContentLoaded', () => {
	initNavigation();
	initScrambleButtons();
});
