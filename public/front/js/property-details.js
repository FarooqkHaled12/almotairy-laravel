// معرض الصور البسيط
const mainImage   = document.getElementById('mainImage');
const thumbsWrap  = document.getElementById('galleryThumbs');
const thumbs      = thumbsWrap ? thumbsWrap.querySelectorAll('.thumb') : [];
const prevBtn     = document.getElementById('prevImage');
const nextBtn     = document.getElementById('nextImage');

let currentIndex = 0;

function setActiveImage(index) {
    if (!thumbs.length) return;
    if (index < 0) index = thumbs.length - 1;
    if (index >= thumbs.length) index = 0;
    currentIndex = index;

    thumbs.forEach((img, i) => {
        img.classList.toggle('active', i === currentIndex);
        if (i === currentIndex && mainImage) {
            mainImage.src = img.src;
            mainImage.alt = img.alt || 'صورة الشقة';
        }
    });
}

thumbs.forEach((img, index) => {
    img.addEventListener('click', () => {
        setActiveImage(index);
    });
});

if (prevBtn) {
    prevBtn.addEventListener('click', () => setActiveImage(currentIndex - 1));
}
if (nextBtn) {
    nextBtn.addEventListener('click', () => setActiveImage(currentIndex + 1));
}

// تأكيد بسيط عند حجز معاينة
const bookVisitBtn = document.getElementById('bookVisitBtn');
if (bookVisitBtn) {
    bookVisitBtn.addEventListener('click', () => {
        const confirmVisit = confirm('هل ترغب في حجز معاينة لهذه الشقة والتواصل مع فريق المبيعات؟');
        if (confirmVisit) {
            window.location.href = 'contact.html?property=haram-panorama';
        }
    });
}

// أول صورة مفعلة
setActiveImage(0);
