$(function () {
  var $grid = $('#productsGrid');
  var $sidebar = $('#collectionSidebar');

  // ===== ACCORDION TOGGLE =====
  $('.sidebar-accordion-header').on('click', function () {
    var $accordion = $(this).closest('.sidebar-accordion');
    $accordion.toggleClass('active');
  });

  // ===== MOBILE FILTER TOGGLE =====
  $('#filterToggle').on('click', function () {
    $sidebar.toggleClass('active');
  });
  $sidebar.on('click', function (e) {
    if ($(e.target).is('#collectionSidebar') && $(window).width() <= 992) {
      $sidebar.removeClass('active');
    }
  });

  // ===== GRID/LIST VIEW TOGGLE =====
  $('.view-btn').on('click', function () {
    $('.view-btn').removeClass('active');
    $(this).addClass('active');
    if ($(this).data('view') === 'list') {
      $grid.addClass('list-view');
    } else {
      $grid.removeClass('list-view');
    }
  });

  // ===== PRICE RANGE SLIDER =====
  var $priceMin = $('#priceMin');
  var $priceMax = $('#priceMax');
  var $fill = $('#priceRangeFill');
  var $minLabel = $('#priceMinLabel');
  var $maxLabel = $('#priceMaxLabel');

  function updatePriceRange() {
    var min = parseFloat($priceMin.val());
    var max = parseFloat($priceMax.val());
    var overallMin = parseFloat($priceMin.attr('min'));
    var overallMax = parseFloat($priceMax.attr('max'));

    if (min > max) {
      // Swap
      var tmp = min;
      min = max;
      max = tmp;
      $priceMin.val(min);
      $priceMax.val(max);
    }

    var pctMin = ((min - overallMin) / (overallMax - overallMin)) * 100;
    var pctMax = ((max - overallMin) / (overallMax - overallMin)) * 100;

    $fill.css({ left: pctMin + '%', width: (pctMax - pctMin) + '%' });
    $minLabel.text(Math.round(min).toLocaleString());
    $maxLabel.text(Math.round(max).toLocaleString());

  }

  $priceMin.on('input', updatePriceRange);
  $priceMax.on('input', updatePriceRange);
  $priceMin.on('change', applyFilters);
  $priceMax.on('change', applyFilters);
  updatePriceRange();

  // ===== APPLY FILTERS BUTTON =====
  $('#applyFilters').on('click', applyFilters);

  // ===== SORT =====
  $('#sortSelect').on('change', applyFilters);

  // ===== APPLY FILTERS =====
  function applyFilters() {
    var params = new URLSearchParams(window.location.search);

    var sort = $('#sortSelect').val();
    if (sort !== 'newest') params.set('sort', sort);
    else params.delete('sort');

    var brands = [];
    $('.brand-filter:checked').each(function () { brands.push($(this).val()); });
    if (brands.length) params.set('brand', brands.join(','));
    else params.delete('brand');

    var minPrice = $priceMin.val();
    var maxPrice = $priceMax.val();
    var overallMin = $priceMin.attr('min');
    var overallMax = $priceMax.attr('max');

    if (parseFloat(minPrice) > parseFloat(overallMin)) params.set('min_price', minPrice);
    else params.delete('min_price');
    if (parseFloat(maxPrice) < parseFloat(overallMax)) params.set('max_price', maxPrice);
    else params.delete('max_price');

    var qs = params.toString();
    var url = window.location.pathname + (qs ? '?' + qs : '');
    window.location.href = url;
  }

  // ===== CLEAR FILTERS =====
  $('#clearFilters').on('click', function () {
    window.location.href = window.location.pathname;
  });

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

  // ===== PARALLAX HERO =====
  $(window).on('scroll', function () {
    var scrollTop = $(window).scrollTop();
    $('.collection-hero-bg').css('transform', 'translateY(' + (scrollTop * 0.4) + 'px) scale(1.05)');
  });
});
