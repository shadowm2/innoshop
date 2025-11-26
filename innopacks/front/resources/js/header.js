$(function () {
  // Page header scroll effect handling
  const headerContentHeight = $('.header-box').outerHeight(true);

  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $('.header-box').addClass('header-fixed');
      // If not on homepage and no placeholder exists, add placeholder to prevent page jumping
      if (!$('body').hasClass('page-home') && !$('.header-placeholder').length) {
        $('.header-box').before('<div class="header-placeholder" style="height:' + headerContentHeight + 'px"></div>');
      }
    } else {
      $('.header-box').removeClass('header-fixed');
      $('.header-placeholder').remove();
    }
  });
  
  // Mobile menu enhancements
  $('#mobile-menu-offcanvas').on('show.bs.offcanvas', function () {
    // Add body class to prevent background scrolling
    $('body').addClass('mobile-menu-open');
  });
  
  $('#mobile-menu-offcanvas').on('hide.bs.offcanvas', function () {
    // Remove body class when menu is closed
    $('body').removeClass('mobile-menu-open');
  });
  
  // Smooth scrolling for anchor links
  $('.mobile-menu-wrap a[href^="#"]').on('click', function (e) {
    e.preventDefault();
    const target = $($(this).attr('href'));
    if (target.length) {
      $('html, body').animate({
        scrollTop: target.offset().top - 80
      }, 500);
      // Close mobile menu after clicking
      $('#mobile-menu-offcanvas').offcanvas('hide');
    }
  });
  
  // Cart quantity synchronization
  function syncCartQuantity() {
    const cartQuantity = $('.header-cart-icon .icon-quantity').text();
    $('.mobile-header-top .cart-quantity').text(cartQuantity);
  }
  
  // Initial sync
  syncCartQuantity();
  
  // Sync when cart updates
  $(document).on('cartUpdated', function() {
    syncCartQuantity();
  });
});