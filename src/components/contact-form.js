const FIELD_SELECTOR = [
	'input[type="text"]',
	'input[type="email"]',
	'input[type="tel"]',
	'input[type="url"]',
	'input[type="number"]',
	'textarea',
].join(', ');

export function initContactForm() {
	const labels = document.querySelectorAll('.contact-block__form .wpcf7-form label');

	labels.forEach((label) => {
		const field = label.querySelector(FIELD_SELECTOR)
			|| (label.htmlFor ? document.getElementById(label.htmlFor) : null);

		if (!field) {
			return;
		}

		const textNodes = [...label.childNodes].filter((node) => node.nodeType === Node.TEXT_NODE);
		const labelText = textNodes
			.map((node) => node.textContent.trim())
			.filter(Boolean)
			.join(' ');

		if (!labelText) {
			return;
		}

		if (!field.placeholder) {
			field.placeholder = labelText;
		}

		if (!field.getAttribute('aria-label')) {
			field.setAttribute('aria-label', labelText);
		}

		if (label.contains(field)) {
			textNodes.forEach((node) => node.remove());
			[...label.children]
				.filter((element) => element.tagName === 'BR')
				.forEach((element) => element.remove());
		} else {
			label.classList.add('screen-reader-text');
		}
	});
}
