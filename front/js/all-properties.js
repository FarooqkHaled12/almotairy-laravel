// ===============
// Sidebar toggle (mobile)
// ===============
const openSidebarBtn = document.getElementById('openSidebar');
const closeSidebarBtn = document.getElementById('closeSidebar');
const sidebar = document.getElementById('propertiesSidebar');

if (openSidebarBtn && sidebar) {
  openSidebarBtn.addEventListener('click', () => {
    sidebar.classList.add('active');
    document.body.classList.add('sidebar-open');
  });
}

if (closeSidebarBtn && sidebar) {
  closeSidebarBtn.addEventListener('click', () => {
    sidebar.classList.remove('active');
    document.body.classList.remove('sidebar-open');
  });
}

document.addEventListener('click', (e) => {
  if (
    document.body.classList.contains('sidebar-open') &&
    sidebar &&
    !sidebar.contains(e.target) &&
    e.target !== openSidebarBtn
  ) {
    sidebar.classList.remove('active');
    document.body.classList.remove('sidebar-open');
  }
});

// ===============
// Filtering
// ===============
const categoryButtons = document.querySelectorAll('.filter-btn[data-category]');
const typeButtons     = document.querySelectorAll('.filter-type-btn[data-type]');
const cards           = document.querySelectorAll('.property-card');
const resultCountEl   = document.getElementById('resultCount');
const noResultsEl     = document.getElementById('noResults');

let activeCategory = 'all';
let activeType     = 'all';

function applyFilters() {
  let visible = 0;

  cards.forEach(card => {
    const cardCat  = card.getAttribute('data-category');
    const cardType = card.getAttribute('data-type');

    const matchCat  = (activeCategory === 'all') || (cardCat === activeCategory);
    const matchType = (activeType === 'all')     || (cardType === activeType);

    if (matchCat && matchType) {
      card.style.display = 'block';
      visible++;
    } else {
      card.style.display = 'none';
    }
  });

  if (resultCountEl) resultCountEl.textContent = visible;

  if (noResultsEl) {
    noResultsEl.style.display = visible === 0 ? 'block' : 'none';
  }
}

// كاتيجوري
categoryButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    activeCategory = btn.getAttribute('data-category');

    categoryButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    applyFilters();

    if (window.innerWidth <= 992 && sidebar) {
      sidebar.classList.remove('active');
      document.body.classList.remove('sidebar-open');
    }
  });
});

// تايب
typeButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    const type = btn.getAttribute('data-type');

    typeButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    activeType = type;
    applyFilters();
  });
});

// أول تشغيل
applyFilters();
