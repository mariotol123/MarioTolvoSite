import './styles/main.scss';
import { initNavigation } from './components/navigation';
import { initNavigationContrast } from './components/navigation-contrast';
import { initScrambleButtons } from './components/scramble-buttons';
import { initSkillsToggle } from './components/skills-toggle';

document.addEventListener('DOMContentLoaded', () => {
	initNavigation();
	initNavigationContrast();
	initScrambleButtons();
	initSkillsToggle();
});
