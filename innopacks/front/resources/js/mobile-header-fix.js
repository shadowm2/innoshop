// Mobile Header Fix JavaScript
document.addEventListener('DOMContentLoaded', function() {
  // Handle offcanvas events
  const mobileMenu = document.getElementById('mobileMenuOffcanvas');
  
  if (mobileMenu) {
    // Prevent background scrolling when menu is open
    mobileMenu.addEventListener('show.bs.offcanvas', function () {
      document.body.style.overflow = 'hidden';
    });
    
    mobileMenu.addEventListener('hide.bs.offcanvas', function () {
      document.body.style.overflow = '';
    });
  }
  
  // Cart badge update (if needed)
  function updateCartBadge() {
    // This would typically be connected to your cart system
    // For now, we'll just ensure the badge is visible
    const cartBadges = document.querySelectorAll('.cart-badge');
    cartBadges.forEach(badge => {
      // In a real implementation, you would update this with actual cart count
      // badge.textContent = cartCount;
      // For now, we'll just show a static value or hide if 0
      const count = parseInt(badge.textContent) || 0;
      if (count > 0) {
        badge.style.display = 'flex';
      } else {
        badge.style.display = 'none';
      }
    });
  }
  
  // Initialize cart badge
  updateCartBadge();
  
  // Close menu when clicking on links (for single page apps)
  const mobileLinks = document.querySelectorAll('.mobile-nav .nav-link');
  mobileLinks.forEach(link => {
    link.addEventListener('click', function() {
      // Close the offcanvas menu
      const offcanvas = bootstrap.Offcanvas.getInstance(mobileMenu);
      if (offcanvas) {
        offcanvas.hide();
      }
    });
  });
});