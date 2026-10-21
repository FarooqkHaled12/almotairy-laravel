document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('propertySearch');
  const locationInput = document.getElementById('locationSearch');
  const categorySelect = document.getElementById('categorySearch');
  const areaMinInput = document.getElementById('areaMin');
  const areaMaxInput = document.getElementById('areaMax');
  const buttons = document.querySelectorAll('.listing-filter');
  const cards = document.querySelectorAll('.listing-card');
  const count = document.getElementById('resultCount');
  const empty = document.getElementById('noResults');
  const reset = document.getElementById('resetFilters');
  const resetEmpty = document.getElementById('resetEmpty');
  const matchBanner = document.getElementById('listingMatchBanner');
  const matchMessage = document.getElementById('listingMatchMessage');
  let location = new URLSearchParams(window.location.search).get('q')?.trim().toLocaleLowerCase() || '';
  if (locationInput && location) locationInput.value = new URLSearchParams(window.location.search).get('q').trim();

  function applyFilters() {
    const category = categorySelect.value;
    const minArea = areaMinInput.value === '' ? null : Number(areaMinInput.value);
    const maxArea = areaMaxInput.value === '' ? null : Number(areaMaxInput.value);
    const hasCriteria = category !== 'all' || Boolean(location) || minArea !== null || maxArea !== null;
    let visible = 0;
    cards.forEach(card => {
      const area = card.dataset.area === '' ? null : Number(card.dataset.area);
      const matches = (category === 'all' || card.dataset.category === category) &&
        (card.dataset.location || '').toLocaleLowerCase().includes(location) &&
        (minArea === null || (area !== null && area >= minArea)) &&
        (maxArea === null || (area !== null && area <= maxArea));
      card.hidden = !matches;
      if (matches) visible++;
    });
    count.textContent = visible;
    empty.hidden = visible !== 0;
    reset.hidden = category === 'all' && !location && minArea === null && maxArea === null;
    matchBanner.hidden = !hasCriteria;
    if (hasCriteria) {
      matchMessage.textContent = visible
        ? matchBanner.dataset.matchText.replace(':count', visible)
        : matchBanner.dataset.noMatchText;
    }
    buttons.forEach(button => {
      const active = button.dataset.category === category;
      button.classList.toggle('active', active);
      button.setAttribute('aria-pressed', String(active));
    });
  }

  form.addEventListener('submit', event => {
    event.preventDefault();
    location = locationInput.value.trim().toLocaleLowerCase();
    applyFilters();
  });
  categorySelect.addEventListener('change', applyFilters);
  areaMinInput.addEventListener('input', applyFilters);
  areaMaxInput.addEventListener('input', applyFilters);
  locationInput.addEventListener('input', () => {
    location = locationInput.value.trim().toLocaleLowerCase();
    applyFilters();
  });
  function clearFilters() {
    locationInput.value = '';
    location = '';
    categorySelect.value = 'all';
    areaMinInput.value = '';
    areaMaxInput.value = '';
    applyFilters();
  }
  reset.addEventListener('click', clearFilters);
  resetEmpty.addEventListener('click', clearFilters);
  buttons.forEach(button => button.addEventListener('click', () => {
    categorySelect.value = button.dataset.category;
    applyFilters();
  }));

  applyFilters();

  const grid = document.getElementById('propertyGrid');
  const sort = document.getElementById('propertySort');
  const originalOrder = Array.from(cards);
  sort.addEventListener('change', () => {
    const ordered = sort.value === 'oldest' ? [...originalOrder].reverse() : originalOrder;
    ordered.forEach(card => grid.appendChild(card));
  });
  grid.querySelectorAll('.listing-card__gallery').forEach(gallery => {
    const controls = gallery.querySelector('.listing-card__gallery-controls');
    if (!controls) return;
    const images = gallery.querySelectorAll('.listing-card__image img');
    const indicator = controls.querySelector('.listing-card__gallery-count');
    const dots = gallery.querySelector('.listing-card__gallery-dots');
    const imageLink = gallery.querySelector('.listing-card__image');
    let current = 0;
    controls.hidden = false;
    dots.hidden = false;
    function showImage(index) {
      images[current].hidden = true;
      current = (index + images.length) % images.length;
      images[current].hidden = false;
      indicator.textContent = `${current + 1} / ${images.length}`;
      dots.querySelectorAll('[data-gallery-index]').forEach(dot => {
        dot.setAttribute('aria-pressed', String(Number(dot.dataset.galleryIndex) === current));
      });
    }
    controls.querySelectorAll('[data-gallery-step]').forEach(button => {
      button.addEventListener('click', () => showImage(current + Number(button.dataset.galleryStep)));
    });
    dots.querySelectorAll('[data-gallery-index]').forEach(dot => {
      dot.addEventListener('click', () => showImage(Number(dot.dataset.galleryIndex)));
    });
    let touchStart = null;
    imageLink.addEventListener('touchstart', event => {
      if (event.touches.length === 1) touchStart = { x: event.touches[0].clientX, y: event.touches[0].clientY };
    }, { passive: true });
    imageLink.addEventListener('touchend', event => {
      if (!touchStart || event.changedTouches.length !== 1) return;
      const dx = event.changedTouches[0].clientX - touchStart.x;
      const dy = event.changedTouches[0].clientY - touchStart.y;
      touchStart = null;
      if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) {
        event.preventDefault();
        showImage(current + (dx < 0 ? 1 : -1));
      }
    }, { passive: false });
    imageLink.addEventListener('touchcancel', () => {
      touchStart = null;
    });
  });
  const viewButtons = document.querySelectorAll('[data-listing-view]');
  viewButtons.forEach(button => button.addEventListener('click', () => {
    const listView = button.dataset.listingView === 'list';
    grid.classList.toggle('listing-grid--list', listView);
    viewButtons.forEach(option => {
      const selected = option === button;
      option.classList.toggle('is-active', selected);
      option.setAttribute('aria-pressed', String(selected));
    });
  }));

  const propertyLocation = document.getElementById('propertyLocation');
  if (propertyLocation) {
    const locationCards = document.querySelectorAll('.location-card');
    propertyLocation.addEventListener('change', () => {
      locationCards.forEach(card => {
        card.hidden = card.dataset.location !== propertyLocation.value;
      });
    });
  }
});
