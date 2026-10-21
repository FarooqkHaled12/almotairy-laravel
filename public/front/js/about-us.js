// ====================
// سلايدر صور قسم "قصتنا"
// ====================
document.querySelectorAll('[data-ab-slider]').forEach(slider => {
  const slides = slider.querySelectorAll('.ab-slider-track img');
  if (slides.length < 2) {
    slider.querySelector('.ab-slider-nav')?.remove();
    return;
  }

  let current = 0;
  const show = index => {
    slides[current].classList.remove('is-active');
    current = (index + slides.length) % slides.length;
    slides[current].classList.add('is-active');
  };

  slider.querySelector('[data-ab-prev]').addEventListener('click', () => show(current - 1));
  slider.querySelector('[data-ab-next]').addEventListener('click', () => show(current + 1));
});
