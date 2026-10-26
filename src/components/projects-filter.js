export function initProjectsFilter() {
	const grids = document.querySelectorAll('[data-projects-grid]');

	grids.forEach((grid) => {
		const section = grid.closest('.projects-grid');
		const filters = section ? Array.from(section.querySelectorAll('[data-project-filter], [data-project-filter-all]')) : [];
		const cards = Array.from(grid.querySelectorAll('[data-project-card]'));
		const activeFilters = new Set();
		const filtersToggle = section?.querySelector('[data-project-filters-toggle]');
		const extraFilters = filters.filter((filter) => filter.hasAttribute('data-project-filter')).slice(20);

		if (filtersToggle && extraFilters.length) {
			let expanded = false;
			const updateFilterVisibility = () => {
				extraFilters.forEach((filter) => {
					filter.hidden = !expanded && !activeFilters.has(filter.dataset.projectFilter);
				});
				filtersToggle.setAttribute('aria-expanded', String(expanded));
				filtersToggle.textContent = expanded ? filtersToggle.dataset.labelCollapse : filtersToggle.dataset.labelExpand;
			};

			filtersToggle.hidden = false;
			filtersToggle.addEventListener('click', () => {
				expanded = !expanded;
				updateFilterVisibility();
			});
			section.addEventListener('click', (event) => {
				if (event.target.closest('[data-project-filter], [data-project-filter-all]')) {
					updateFilterVisibility();
				}
			});
			updateFilterVisibility();
		}

		if (!section || !filters.length || !cards.length) {
			return;
		}

		const applyFilters = () => {
			const showDefault = activeFilters.size === 0;

			cards.forEach((card) => {
				const cardTerms = (card.dataset.projectTerms || '').split(' ').filter(Boolean);
				const hasMatch = cardTerms.some((term) => activeFilters.has(term));
				const shouldShow = showDefault ? !card.classList.contains('is-hidden-by-default') : hasMatch;

				card.hidden = !shouldShow;
			});

			filters.forEach((filter) => {
				const filterValue = filter.dataset.projectFilter;
				const isAll = filter.hasAttribute('data-project-filter-all');
				const isActive = isAll ? showDefault : activeFilters.has(filterValue);

				filter.classList.toggle('is-active', isActive);
				filter.setAttribute('aria-pressed', isActive ? 'true' : 'false');
			});
		};

		filters.forEach((filter) => {
			filter.addEventListener('click', () => {
				if (filter.hasAttribute('data-project-filter-all')) {
					activeFilters.clear();
					applyFilters();
					return;
				}

				const filterValue = filter.dataset.projectFilter;

				if (!filterValue) {
					return;
				}

				if (activeFilters.has(filterValue)) {
					activeFilters.delete(filterValue);
				} else {
					activeFilters.add(filterValue);
				}

				applyFilters();
			});
		});

		applyFilters();
	});
}
