// =======================
// Mobile Navbar Toggle
// =======================
const menuToggle = document.getElementById('mobile-menu');
const navList   = document.querySelector('.nav-list');

if (menuToggle && navList) {
  const setMenuOpen = (open) => {
    navList.classList.toggle('active', open);
    menuToggle.classList.toggle('open', open);
    document.body.classList.toggle('menu-open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
    menuToggle.setAttribute('aria-label', open ? menuToggle.dataset.closeLabel : menuToggle.dataset.openLabel);
  };

  menuToggle.addEventListener('click', () => {
    setMenuOpen(!navList.classList.contains('active'));
  });

  // إغلاق المينيو لما يضغط على لينك
  navList.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      setMenuOpen(false);
    });
  });

  document.addEventListener('click', (event) => {
    if (!navList.contains(event.target) && !menuToggle.contains(event.target)) setMenuOpen(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && navList.classList.contains('active')) {
      setMenuOpen(false);
      menuToggle.focus();
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) setMenuOpen(false);
  });
}

// =======================
// Change header style on scroll (اختياري)
// =======================
const header = document.getElementById('header');

const updateHeaderStyle = () => {
  if (!header) return;
  const hero = document.body.classList.contains('home-page') ? document.querySelector('.hero') : null;
  const pastHero = hero ? hero.getBoundingClientRect().bottom <= header.offsetHeight : window.scrollY > 50;
  header.classList.toggle('header-scrolled', pastHero);
  document.body.classList.toggle('home-hero-visible', Boolean(hero && !pastHero));
};
window.addEventListener('scroll', updateHeaderStyle, { passive: true });
window.addEventListener('resize', updateHeaderStyle);
updateHeaderStyle();

// =======================
// Modals Open / Close
// =======================
// دوال عامة عشان تستدعيها من الـ HTML زي ما عامل
window.openModal = function (id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = 'block';
};

window.closeModal = function (id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = 'none';
};

// إغلاق المودال لما تضغط برّه المحتوى
window.addEventListener('click', (e) => {
  document.querySelectorAll('.modal').forEach(modal => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
});

// =======================
// Contact Form (تجربة بسيطة على الفرونت فقط)
// =======================
const contactForm = document.getElementById('contactForm');

if (contactForm) {
  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const name    = document.getElementById('name').value.trim();
    const phone   = document.getElementById('phone').value.trim();
    const interest= document.getElementById('interest').value;
    const message = document.getElementById('message').value.trim();

    if (!name || !phone) {
      alert('من فضلك أدخل الاسم ورقم الهاتف.');
      return;
    }

    // هنا ممكن تبعت البيانات لـ API أو خدمة مثل Formspree
    // دلوقتي هنكتفي برسالة تأكيد للمستخدم
    alert('تم إرسال طلبك بنجاح، سنتواصل معك في أقرب وقت ممكن.');

    contactForm.reset();
  });
}

// =======================
// Smooth scroll (لضمان سلوك ناعم في كل المتصفحات)
// =======================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const targetId = this.getAttribute('href').substring(1);
    const targetEl = document.getElementById(targetId);

    if (targetEl) {
      e.preventDefault();
      const topOffset = header ? header.offsetHeight : 0;
      const elementPosition = targetEl.getBoundingClientRect().top + window.scrollY;
      const offsetPosition = elementPosition - topOffset;

      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      });
    }
  });
});

// One reusable, one-shot homepage motion system. Elements remain visible until
// this block has mapped them and the observer is ready, so JS failures never
// leave content hidden.
(() => {
  if (!document.body.classList.contains('home-page')) return;

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const mobile = window.matchMedia('(max-width: 860px)').matches;
  const mappings = [];
  const add = (selector, direction, group = null, image = false, slider = false) => {
    document.querySelectorAll(selector).forEach((element, index) => {
      if (mappings.some(item => item.element === element)) return;
      const resolvedDirection = typeof direction === 'function' ? direction(index, element) : direction;
      mappings.push({ element, direction: resolvedDirection, index, group, image, slider });
    });
  };

  add('.developments-heading, .featured-properties .featured-heading, .home-services-heading', 'up');
  add('.development-slide', index => index % 2 ? 'left' : 'right', 'developments', false, true);
  add('.featured-properties .property-card', index => ['right', 'left', 'up'][index % 3], 'properties');
  add('.home-about-copy', 'right');
  add('.home-about-visual', 'left', null, true);
  add('.home-about-features li', mobile ? 'up' : 'right', 'about-features');
  add('.home-service', index => ['right', 'left', 'up'][index % 3], 'services');
  add('.contact-info', 'right');
  add('.contact-form-box', 'left');
  add('.home-apartments-heading, .home-explore-copy, .home-partner-copy, .home-faq__heading', 'up');

  if (!mappings.length) return;

  mappings.forEach(item => {
    const { element, direction, group, index, image } = item;
    element.setAttribute('data-motion-reveal', 'true');
    element.setAttribute('data-motion-direction', direction);
    if (group && !item.slider) {
      const delayStep = mobile ? 80 : 100;
      const delay = Math.min(index * delayStep, 300);
      element.style.setProperty('--motion-delay', `${delay}ms`);
    }
    if (image) element.querySelector('img')?.setAttribute('data-motion-image', 'true');
  });

  const reveal = element => {
    element.classList.add('is-visible');
    element.querySelector('[data-motion-image]')?.classList.add('is-visible');
  };

  if (reduced || !('IntersectionObserver' in window)) {
    mappings.forEach(item => reveal(item.element));
    return;
  }

  const observer = new IntersectionObserver((entries, io) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      reveal(entry.target);
      io.unobserve(entry.target);
    });
  }, { rootMargin: '0px 0px -10% 0px', threshold: 0.1 });

  mappings.filter(item => !item.slider).forEach(item => observer.observe(item.element));

  // Horizontal project cards need the slider itself as their observation
  // viewport. This prevents off-screen cards from animating early and keeps
  // card transforms isolated from the swipeable track.
  const sliderTrack = document.querySelector('.developments-track');
  const sliderItems = mappings.filter(item => item.slider);
  let sliderObserver = null;
  if (sliderTrack && sliderItems.length) {
    sliderObserver = new IntersectionObserver((entries, io) => {
      const visibleEntries = entries
        .filter(entry => entry.isIntersecting)
        .sort((a, b) => a.target.offsetLeft - b.target.offsetLeft);
      visibleEntries.forEach((entry, index) => {
        entry.target.style.setProperty('--motion-delay', `${Math.min(index * (mobile ? 80 : 100), 200)}ms`);
        reveal(entry.target);
        io.unobserve(entry.target);
      });
    }, { root: sliderTrack, rootMargin: '0px -4% 0px -4%', threshold: 0.18 });
    sliderItems.forEach(item => sliderObserver.observe(item.element));
  } else {
    sliderItems.forEach(item => observer.observe(item.element));
  }

  document.documentElement.classList.add('motion-ready');

  // Elements already visible at initialization should animate immediately.
  requestAnimationFrame(() => mappings.filter(item => !item.slider).forEach(({ element }) => {
    const rect = element.getBoundingClientRect();
    if (rect.top < window.innerHeight * .9 && rect.bottom > 0) reveal(element);
  }));
})();
