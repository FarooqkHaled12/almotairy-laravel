// ====================
// Contact Form Validation & Submission
// ====================
const contactForm = document.getElementById('contactForm');
const formMessage = document.getElementById('formMessage');

if (contactForm) {
  contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    // جمع البيانات
    const formData = {
      fullName: document.getElementById('fullName').value.trim(),
      phone: document.getElementById('phone').value.trim(),
      email: document.getElementById('email').value.trim(),
      subject: document.getElementById('subject').value,
      propertyType: document.getElementById('propertyType').value,
      budget: document.getElementById('budget').value,
      message: document.getElementById('message').value.trim(),
    };

    // التحقق من الحقول المطلوبة
    if (!formData.fullName || !formData.phone || !formData.subject || !formData.message) {
      showMessage('من فضلك املأ جميع الحقول المطلوبة (*)', 'error');
      return;
    }

    // التحقق من رقم الهاتف (مصري)
    const phoneRegex = /^(010|011|012|015)\d{8}$/;
    if (!phoneRegex.test(formData.phone)) {
      showMessage('من فضلك أدخل رقم هاتف مصري صحيح', 'error');
      return;
    }

    // التحقق من البريد الإلكتروني إن وُجد
    if (formData.email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(formData.email)) {
        showMessage('من فضلك أدخل بريد إلكتروني صحيح', 'error');
        return;
      }
    }

    // إظهار رسالة التحميل
    const submitBtn = contactForm.querySelector('.btn-submit');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> جاري الإرسال...';
    submitBtn.disabled = true;

    // محاكاة إرسال (هنا تحط API الخاص بيك أو خدمة زي Formspree)
    setTimeout(() => {
      // نجاح الإرسال
      showMessage('تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.', 'success');
      contactForm.reset();
      
      // إعادة الزر لحالته الأصلية
      submitBtn.innerHTML = originalBtnText;
      submitBtn.disabled = false;

      // إخفاء الرسالة بعد 5 ثواني
      setTimeout(() => {
        formMessage.style.display = 'none';
      }, 5000);
    }, 2000);

    /* 
    // لو حابب تستخدم Formspree أو API حقيقي:
    try {
      const response = await fetch('YOUR_API_ENDPOINT', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (response.ok) {
        showMessage('تم إرسال رسالتك بنجاح!', 'success');
        contactForm.reset();
      } else {
        showMessage('حدث خطأ، حاول مرة أخرى', 'error');
      }
    } catch (error) {
      showMessage('حدث خطأ في الاتصال', 'error');
    }

    submitBtn.innerHTML = originalBtnText;
    submitBtn.disabled = false;
    */
  });
}

function showMessage(message, type) {
  formMessage.textContent = message;
  formMessage.className = `form-message ${type}`;
  formMessage.style.display = 'block';
}

// ====================
// Smooth Scroll to Map
// ====================
document.querySelectorAll('a[href="#map"]').forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const mapSection = document.getElementById('map');
    if (mapSection) {
      const headerHeight = document.getElementById('header').offsetHeight;
      const targetPosition = mapSection.offsetTop - headerHeight;
      window.scrollTo({
        top: targetPosition,
        behavior: 'smooth'
      });
    }
  });
});
