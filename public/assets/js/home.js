$(function () {

  // ===== STICKY HEADER SHRINK =====
  var $header = $('#siteHeader');
  var headerTop = $header.offset().top;

  function handleScroll() {
    if ($(window).scrollTop() > 50) {
      $header.addClass('scrolled');
    } else {
      $header.removeClass('scrolled');
    }
  }

  $(window).on('scroll', handleScroll);
  handleScroll();

  // ===== ANNOUNCEMENT BAR CLOSE =====
  $('.announcement-close').on('click', function () {
    $('.announcement-bar').slideUp();
  });

  // ===== MOBILE MENU =====
  $('#mobileMenuToggle').on('click', function () {
    $('#mobileMenuOverlay').addClass('active');
    $('#mobileMenuPanel').addClass('active');
    $('body').css('overflow', 'hidden');
  });

  function closeMobileMenu() {
    $('#mobileMenuOverlay').removeClass('active');
    $('#mobileMenuPanel').removeClass('active');
    $('body').css('overflow', '');
  }

  $('#mobileMenuOverlay').on('click', closeMobileMenu);
  $('#mobileMenuClose').on('click', closeMobileMenu);

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      if ($('#cartDrawer').hasClass('open')) {
        var btn = document.getElementById('cartDrawerClose');
        if (btn) btn.click();
      }
    }
  });

  // ===== ACCOUNT DROPDOWN =====
  $('#accountToggle').on('click', function (e) {
    e.stopPropagation();
    $('#accountDropdown').toggleClass('active');
  });

  $(document).on('click', function (e) {
    if (!$(e.target).closest('#accountDropdown, #accountToggle').length) {
      $('#accountDropdown').removeClass('active');
    }
  });

  // ===== CART DRAWER (backup handlers via delegation) =====
  $(document).on('click', '#cartDrawerClose', function () {
    $('#cartDrawer, #cartOverlay').removeClass('open');
    $('body').css('overflow', '');
  });

  $(document).on('click', '#cartOverlay', function (e) {
    if ($(e.target).is('#cartOverlay')) {
      $('#cartDrawer, #cartOverlay').removeClass('open');
      $('body').css('overflow', '');
    }
  });

  // ===== FADE-UP ON SCROLL (Intersection Observer) =====
  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    $('.fade-up').each(function () {
      observer.observe(this);
    });
  } else {
    $('.fade-up').addClass('visible');
  }

  // ===== REVIEWS SLIDER =====
  var $track = $('#reviewsTrack');
  var $dots = $('#reviewsDots');
  var $slides = $track.children();
  var slideCount = $slides.length;
  var currentIndex = 0;
  var autoSlide;

  function renderDots() {
    $dots.empty();
    for (var i = 0; i < slideCount; i++) {
      var $dot = $('<span class="reviews-dot"></span>');
      if (i === currentIndex) $dot.addClass('active');
      $dot.on('click', function () { goToSlide($(this).index()); });
      $dots.append($dot);
    }
  }

  function goToSlide(index) {
    currentIndex = index;
    var offset = -currentIndex * 100;
    $track.css('transform', 'translateX(' + offset + '%)');
    $dots.find('.reviews-dot').removeClass('active').eq(currentIndex).addClass('active');
  }

  function nextSlide() { goToSlide((currentIndex + 1) % slideCount); }

  function prevSlide() { goToSlide((currentIndex - 1 + slideCount) % slideCount); }

  function resetAutoSlide() {
    clearInterval(autoSlide);
    autoSlide = setInterval(nextSlide, 4000);
  }

  $('#reviewsNext').on('click', function () { nextSlide(); resetAutoSlide(); });
  $('#reviewsPrev').on('click', function () { prevSlide(); resetAutoSlide(); });

  if (slideCount > 0) {
    renderDots();
    autoSlide = setInterval(nextSlide, 4000);
  }

  // ===== COUNTDOWN TIMER =====
  function startCountdown(days, hours, minutes) {
    var totalSeconds = days * 86400 + hours * 3600 + minutes * 60;

    function update() {
      if (totalSeconds <= 0) return;
      var d = Math.floor(totalSeconds / 86400);
      var h = Math.floor((totalSeconds % 86400) / 3600);
      var m = Math.floor((totalSeconds % 3600) / 60);
      var s = totalSeconds % 60;

      $('#countdownDays').text(String(d).padStart(2, '0'));
      $('#countdownHours').text(String(h).padStart(2, '0'));
      $('#countdownMinutes').text(String(m).padStart(2, '0'));
      $('#countdownSeconds').text(String(s).padStart(2, '0'));

      totalSeconds--;
    }

    update();
    setInterval(update, 1000);
  }

  startCountdown(14, 8, 30);

  // ===== WISHLIST TOGGLE =====
  $(document).on('click', '.wishlist-btn', function () {
    var $btn = $(this);
    $btn.find('i').toggleClass('far fas');
    if ($btn.find('i').hasClass('fas')) {
      $btn.css('color', '#e74c3c');
    } else {
      $btn.css('color', '');
    }
  });
});
