export function initNavigation() {
	const toggle = document.querySelector('.menu-toggle');
	const menu = document.querySelector('.main-navigation .nav, .main-navigation .menu');

	if (!toggle || !menu) {
		return;
	}

	const setMenuState = (isOpen) => {
		toggle.setAttribute('aria-expanded', String(isOpen));
		menu.classList.toggle('is-open', isOpen);
	};

	toggle.addEventListener('click', () => {
		const isOpen = toggle.getAttribute('aria-expanded') === 'true';
		setMenuState(!isOpen);
	});

	window.addEventListener('resize', () => {
		if (window.innerWidth >= 992) {
			setMenuState(false);
		}
	});
}
