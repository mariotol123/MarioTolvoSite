export function initSkillsToggle() {
	const toggleButtons = document.querySelectorAll('.skills-block__toggle');

	toggleButtons.forEach((button) => {
		const gridId = button.getAttribute('aria-controls');
		const grid = gridId ? document.getElementById(gridId) : null;

		if (!grid) {
			return;
		}

		const extraSkills = grid.querySelectorAll('[data-skill-extra]');

		button.addEventListener('click', () => {
			const isExpanded = button.getAttribute('aria-expanded') === 'true';

			extraSkills.forEach((skill) => {
				skill.hidden = isExpanded;
			});

			button.setAttribute('aria-expanded', String(!isExpanded));
		});
	});
}
