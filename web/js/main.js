(function($) {
  "use strict"

  // NAVIGATION
  var responsiveNav = $('#responsive-nav'),
    catToggle = $('#responsive-nav .category-nav .category-header'),
    catList = $('#responsive-nav .category-nav .category-list'),
    menuToggle = $('#responsive-nav .menu-nav .menu-header'),
    menuList = $('#responsive-nav .menu-nav .menu-list');

  catToggle.on('click', function() {
    menuList.removeClass('open');
    catList.toggleClass('open');
  });

  menuToggle.on('click', function() {
    catList.removeClass('open');
    menuList.toggleClass('open');
  });
  $('.catalog').dcAccordion({
    speed: 300
  });

  function showCart(cart) {
    $('#cart .modal-body').html(cart);
    $('#cart').modal();
  }

  $('#cart .modal-body').on('click', '.del-item', function () {
    var id = $(this).data('id');
    $.ajax({
      url: '/cart/del-item',
      data: {id: id},
      type: 'GET',
      success: function (res) {
        if(!res) alert('Ошибка!');
        showCart(res);
      },
      error: function () {
        alert('Error!');
      }
    });
  })


  $('._getCart').on('click', function(event){
    $.ajax({
      url: '/cart/show',
      type: 'GET',
      success: function (res) {
        if(!res) alert('Ошибка!');
        showCart(res);
      },
      error: function () {
        alert('Error!');
      }
    });
    return false;
  })

  $('._clearCart').on('click', function(event){
      $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function (res) {
          if(!res) alert('Ошибка!');
          showCart(res);
        },
        error: function () {
          alert('Error!');
        }
      });
    })

  /*$('.add-to-cart').on('click', function(){

    var that = $(this).closest('.product-single').find('img');
    var bascket = $(".header-btns-icon");
    var w = that.width();

    that.clone()
        .css({'width' : w,
          'position' : 'absolute',
          'z-index' : '9999',
          top: that.offset().top,
          left:that.offset().left})
        .appendTo("body")
        .animate({opacity: 0.05,
          left: bascket.offset()['left'],
          top: bascket.offset()['top'],
          width: 20}, 1000, function() {
          $(this).remove();
        });
  });*/

  /*$('.confirm-order').on('click', function (e) {
    alert('ok!');
  });*/

  $('.add-to-cart').on('click', function (e) {
    if (document.getElementById('product-single')) {
    var that = $(this).closest('.product-single').find('img');

      var bascket = $("._basket");
      var w = that.width();

      that.clone()
          .css({
            'width': w,
            'position': 'absolute',
            'z-index': '9999',
            top: that.offset().top,
            left: that.offset().left
          })
          .appendTo("body")
          .animate({
            opacity: 0.05,
            left: bascket.offset()['left'],
            top: bascket.offset()['top'],
            width: 20
          }, 1000, function () {
            $(this).remove();
          });
    }
    e.preventDefault();
    var id = $(this).data('id'),
        qty = $('#qty').val();
    var cart_count = $("#cart_count");
    var cart_sum = $("#cart_sum");
    $.getJSON({
      url: '/cart/add',
      data: {id: id, qty: qty},
      success: function (res) {
        cart_count.html(res.qty);
        cart_sum.html(res.sum);
      },
      error: function () {
        alert('Error!');
      }
    });

  });

  /*$('.add-to-cart').on('click', function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      $.ajax({
          url: '/cart/add',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            if(!res) alert('Ошибка!');
            showCart(res);
        },
        error: function () {
          alert('Error!');
        }
      });

  });*/

  $(document).click(function(event) {
    if (!$(event.target).closest(responsiveNav).length) {
      if (responsiveNav.hasClass('open')) {
        responsiveNav.removeClass('open');
        $('#navigation').removeClass('shadow');
      } else {
        if ($(event.target).closest('.nav-toggle > button').length) {
          if (!menuList.hasClass('open') && !catList.hasClass('open')) {
            menuList.addClass('open');
          }
          $('#navigation').addClass('shadow');
          responsiveNav.addClass('open');
        }
      }
    }
  });

  // HOME SLICK
  $('#home-slick').slick({
    autoplay: true,
    infinite: true,
    speed: 300,
    arrows: true
  });

  // PRODUCTS SLICK
  $('#product-slick-1').slick({
    slidesToShow: 3,
    slidesToScroll: 2,
    autoplay: true,
    infinite: true,
    speed: 300,
    dots: true,
    arrows: false,
    appendDots: '.product-slick-dots-1',
    responsive: [{
        breakpoint: 991,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          dots: false,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $('#product-slick-2').slick({
    slidesToShow: 3,
    slidesToScroll: 2,
    autoplay: true,
    infinite: true,
    speed: 300,
    dots: true,
    arrows: false,
    appendDots: '.product-slick-dots-2',
    responsive: [{
        breakpoint: 991,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          dots: false,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      }
    ]
  });

  // PRODUCT DETAILS SLICK
  $('#product-main-view').slick({
    infinite: true,
    speed: 300,
    dots: false,
    arrows: true,
    fade: true,
    asNavFor: '#product-view',
  });

  $('#product-view').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    centerMode: true,
    focusOnSelect: true,
    asNavFor: '#product-main-view',
  });

  // PRODUCT ZOOM
  $('#product-main-view .product-view').zoom();

  // PRICE SLIDER
  var slider = document.getElementById('price-slider');
  if (slider) {
    noUiSlider.create(slider, {
      start: [1, 999],
      connect: true,
      tooltips: [true, true],
      format: {
        to: function(value) {
          return value.toFixed(2) + '$';
        },
        from: function(value) {
          return value
        }
      },
      range: {
        'min': 1,
        'max': 999
      }
    });
  }

})(jQuery);
