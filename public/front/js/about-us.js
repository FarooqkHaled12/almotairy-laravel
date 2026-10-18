// ====================
// Counter Animation للأرقام
// ====================
const counters = document.querySelectorAll('.achievement-number');
let animated = false;

const animateCounters = () => {
  counters.forEach(counter => {
    const target = +counter.getAttribute('data-target');
    const increment = target / 100;
    let current = 0;

    const updateCounter = () => {
      if (current < target) {
        current += increment;
        counter.textContent = Math.ceil(current);
        setTimeout(updateCounter, 20);
      } else {
        counter.textContent = target;
      }
    };

    updateCounter();
  });
};

// تشغيل الأنيميشن لما المستخدم يوصل للـ section
const achievementsSection = document.querySelector('.achievements');

if (achievementsSection) {
  window.addEventListener('scroll', () => {
    const sectionTop = achievementsSection.getBoundingClientRect().top;
    const triggerPoint = window.innerHeight / 1.3;

    if (sectionTop < triggerPoint && !animated) {
      animateCounters();
      animated = true;
    }
  });
}
