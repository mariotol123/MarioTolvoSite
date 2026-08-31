import './styles/main.scss';
import { initNavigation } from './components/navigation';
import { initNavigationContrast } from './components/navigation-contrast';
import { initScrambleButtons } from './components/scramble-buttons';
import { initSkillsToggle } from './components/skills-toggle';
import { initContactForm } from './components/contact-form';
import { initProjectsFilter } from './components/projects-filter';

document.addEventListener('DOMContentLoaded', () => {
	initNavigation();
	initNavigationContrast();
	initScrambleButtons();
	initSkillsToggle();
	initContactForm();
	initProjectsFilter();
});
