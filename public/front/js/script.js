// =======================
// Mobile Navbar Toggle
// =======================
const menuToggle = document.getElementById('mobile-menu');
const navList   = document.querySelector('.nav-list');

if (menuToggle && navList) {
  const setMenuOpen = (open) => {
    navList.classList.toggle('active', open);
    menuToggle.classList.toggle('open', open);
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

window.addEventListener('scroll', () => {
  if (window.scrollY > 50) {
    header.classList.add('header-scrolled');
  } else {
    header.classList.remove('header-scrolled');
  }
});

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
