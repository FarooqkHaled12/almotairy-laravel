// ====================
// كروت نوع الاستفسار تختار القيمة في قائمة النموذج والعكس
// ====================
const inquiryCards = document.querySelectorAll('[data-inquiry]');
const inquirySelect = document.getElementById('ct-interest');

const markInquiry = value => {
  inquiryCards.forEach(card => {
    const active = card.dataset.inquiry === value;
    card.classList.toggle('is-active', active);
    card.setAttribute('aria-pressed', active ? 'true' : 'false');
  });
};

if (inquirySelect) {
  inquiryCards.forEach(card => {
    card.addEventListener('click', () => {
      inquirySelect.value = card.dataset.inquiry;
      markInquiry(card.dataset.inquiry);
      document.getElementById('contact-form')?.querySelector('.ct-form-card')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
  });

  inquirySelect.addEventListener('change', () => markInquiry(inquirySelect.value));
}

// بعد الإرسال نرجع لنفس الصفحة، فننزل لرسالة النجاح أو الخطأ داخل النموذج
document.querySelector('.ct-alert')?.scrollIntoView({ block: 'center' });
