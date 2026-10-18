// ====================
// Service Tabs Switching
// ====================
const tabs = document.querySelectorAll('.service-tab');
const panels = {
  consulting: document.getElementById('service-consulting'),
  finishing: document.getElementById('service-finishing'),
  assets: document.getElementById('service-assets'),
  valuation: document.getElementById('service-valuation')
};

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    const key = tab.getAttribute('data-service');

    // Remove active from all tabs
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    // Show corresponding panel
    Object.values(panels).forEach(p => p.classList.remove('active'));
    if (panels[key]) {
      panels[key].classList.add('active');
    }

    // Smooth scroll to details section on mobile
    if (window.innerWidth <= 768) {
      const detailsSection = document.querySelector('.services-details');
      if (detailsSection) {
        setTimeout(() => {
          detailsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
      }
    }
  });
});

// ====================
// Handle URL Parameter (if coming from other pages)
// ====================
const params = new URLSearchParams(window.location.search);
const serviceParam = params.get('service');

if (serviceParam && panels[serviceParam]) {
  tabs.forEach(t => {
    if (t.getAttribute('data-service') === serviceParam) {
      t.click();
    }
  });
}
