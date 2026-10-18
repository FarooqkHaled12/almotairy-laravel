// =======================
// Mobile Navbar Toggle
// =======================
const menuToggle = document.getElementById('mobile-menu');
const navList   = document.querySelector('.nav-list');

if (menuToggle && navList) {
  menuToggle.addEventListener('click', () => {
    navList.classList.toggle('active');
    menuToggle.classList.toggle('open');
  });

  // إغلاق المينيو لما يضغط على لينك
  navList.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      navList.classList.remove('active');
      menuToggle.classList.remove('open');
    });
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
// Filter Properties
// =======================
const filterButtons   = document.querySelectorAll('.filter-btn');
const propertyCards   = document.querySelectorAll('.property-card');

filterButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    // active button style
    filterButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const filterValue = btn.getAttribute('data-filter');

    propertyCards.forEach(card => {
      const category = card.getAttribute('data-category');

      if (filterValue === 'all' || filterValue === category) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
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
// FAQ Accordion
// =======================
const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
  const question = item.querySelector('.faq-question');
  question.addEventListener('click', () => {
    // لو حابب تفتح واحد وتقفل الباقي:
    faqItems.forEach(it => {
      if (it !== item) it.classList.remove('active');
    });

    item.classList.toggle('active');
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
