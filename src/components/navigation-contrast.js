const THEME_COLORS = {
	dark: '#fff',
	light: '#000',
};

export function initNavigationContrast() {
	const navigation = document.querySelector('.main-navigation');
	const links = document.querySelectorAll('.main-navigation .nav a, .main-navigation .menu a');
	const sections = [...document.querySelectorAll('[data-header-theme]')];

	if (!navigation || !links.length || !sections.length) {
		return;
	}

	let animationFrame;

	const colorAtPosition = (positionY) => {
		const section = sections.find((item) => {
			const bounds = item.getBoundingClientRect();
			return bounds.top <= positionY && bounds.bottom > positionY;
		});

		return THEME_COLORS[section?.dataset.headerTheme] || THEME_COLORS.light;
	};

	const updateColors = () => {
		links.forEach((link) => {
			const linkBounds = link.getBoundingClientRect();

			if (!linkBounds.height) {
				return;
			}

			const startColor = colorAtPosition(linkBounds.top + 0.5);
			const endColor = colorAtPosition(linkBounds.bottom - 0.5);
			const boundaries = sections
				.flatMap((section) => {
					const bounds = section.getBoundingClientRect();
					return [bounds.top, bounds.bottom];
				})
				.filter((boundary) => boundary > linkBounds.top && boundary < linkBounds.bottom)
				.sort((first, second) => first - second);
			const split = boundaries.length
				? ((boundaries[0] - linkBounds.top) / linkBounds.height) * 100
				: 100;

			link.style.setProperty('--navigation-color-start', startColor);
			link.style.setProperty('--navigation-color-end', endColor);
			link.style.setProperty('--navigation-color-split', `${split}%`);

			const underlineTop = linkBounds.bottom - 3;
			const underlineStartColor = colorAtPosition(underlineTop + 0.1);
			const underlineEndColor = colorAtPosition(linkBounds.bottom - 0.1);
			const underlineBoundary = boundaries.find(
				(boundary) => boundary > underlineTop && boundary < linkBounds.bottom
			);
			const underlineSplit = underlineBoundary
				? ((underlineBoundary - underlineTop) / 3) * 100
				: 100;

			link.style.setProperty('--navigation-underline-color-start', underlineStartColor);
			link.style.setProperty('--navigation-underline-color-end', underlineEndColor);
			link.style.setProperty('--navigation-underline-color-split', `${underlineSplit}%`);
		});
	};

	const scheduleUpdate = () => {
		window.cancelAnimationFrame(animationFrame);
		animationFrame = window.requestAnimationFrame(updateColors);
	};

	window.addEventListener('scroll', scheduleUpdate, { passive: true });
	window.addEventListener('resize', scheduleUpdate);
	if ('ResizeObserver' in window) {
		new ResizeObserver(scheduleUpdate).observe(navigation);
	}

	if (document.fonts?.ready) {
		document.fonts.ready.then(scheduleUpdate);
	}

	scheduleUpdate();
}
