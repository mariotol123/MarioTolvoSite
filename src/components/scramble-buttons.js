const RANDOM_CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

const getRandomCharacter = () => {
	const index = Math.floor(Math.random() * RANDOM_CHARACTERS.length);
	return RANDOM_CHARACTERS[index];
};

export function initScrambleButtons() {
	const buttons = document.querySelectorAll('.js-scramble-button');
	const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	buttons.forEach((button) => {
		const label = button.textContent.trim().replace(/\s+/g, ' ');

		if (!label) {
			return;
		}

		button.setAttribute('aria-label', label);

		const originalLabel = document.createElement('span');
		originalLabel.className = 'scramble-button__original';
		originalLabel.setAttribute('aria-hidden', 'true');
		originalLabel.textContent = label;

		const animatedLabel = document.createElement('span');
		animatedLabel.className = 'scramble-button__animated';
		animatedLabel.setAttribute('aria-hidden', 'true');

		const letters = Array.from(label, (character) => {
			const letter = document.createElement('span');
			letter.className = 'scramble-button__letter';
			letter.dataset.character = character;
			letter.textContent = character;

			if (character === ' ') {
				letter.classList.add('is-space');
			}

			animatedLabel.append(letter);
			return letter;
		});

		const availableLetters = letters.filter((letter) => !letter.classList.contains('is-space'));
		let animationTimer;

		const restoreLabel = () => {
			availableLetters.forEach((letter) => {
				letter.textContent = letter.dataset.character;
				letter.classList.remove('is-scrambling');
			});
		};

		const animateLabel = () => {
			window.clearTimeout(animationTimer);

			if (reduceMotion) {
				restoreLabel();
				return;
			}

			let frame = 0;
			const numberOfLetters = Math.min(
				Math.max(1, Math.ceil(availableLetters.length * 0.4)),
				Math.max(1, availableLetters.length - 1)
			);
			const charactersToAnimate = [...availableLetters]
				.sort(() => Math.random() - 0.5)
				.slice(0, numberOfLetters);

			restoreLabel();

			const updateLetters = () => {
				const settledLetters = Math.floor(frame / 3);

				charactersToAnimate.forEach((letter, index) => {
					const isSettled = index < settledLetters;
					letter.textContent = isSettled ? letter.dataset.character : getRandomCharacter();
					letter.classList.toggle('is-scrambling', !isSettled);
				});

				if (settledLetters >= charactersToAnimate.length) {
					restoreLabel();
					return;
				}

				frame += 1;
				animationTimer = window.setTimeout(updateLetters, 65);
			};

			updateLetters();
		};

		button.replaceChildren(originalLabel, animatedLabel);
		button.addEventListener('pointerenter', animateLabel);
		button.addEventListener('focus', animateLabel);
	});
}
