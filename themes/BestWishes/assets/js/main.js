/*  ---------------------------------------------------
    Template Name: Male Fashion
    Description: Male Fashion - ecommerce teplate
    Author: Colorib
    Author URI: https://www.colorib.com/
    Version: 1.0
    Created: Colorib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.filter__controls li').on('click', function () {
            $('.filter__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.product__filter').length > 0) {
            var containerEl = document.querySelector('.product__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Search Switch
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Accordin Active
    --------------------*/
    $('.collapse').on('shown.bs.collapse', function () {
        $(this).prev().addClass('active');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).prev().removeClass('active');
    });

    //Canvas Menu
    $(".canvas__open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("active");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".offcanvas-menu-overlay").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("active");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    /*-----------------------
        Hero Slider
    ------------------------*/
    $(".hero__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='arrow_left'><span/>", "<span class='arrow_right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false
    });

    /*--------------------------
        Select
    ----------------------------*/
    // $("select").niceSelect();

    /*-------------------
		Radio Btn
	--------------------- */
    $(".product__color__select label, .shop__sidebar__size label, .product__details__option__size label").on('click', function () {
        $(".product__color__select label, .shop__sidebar__size label, .product__details__option__size label").removeClass('active');
        $(this).addClass('active');
    });

    /*-------------------
		Scroll
	--------------------- */
    $(".nice-scroll").niceScroll({
        cursorcolor: "#0d0d0d",
        cursorwidth: "5px",
        background: "#e5e5e5",
        cursorborder: "",
        autohidemode: true,
        horizrailenabled: false
    });

    /*------------------
        CountDown
    --------------------*/
    // For demo preview start
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    if(mm == 12) {
        mm = '01';
        yyyy = yyyy + 1;
    } else {
        mm = parseInt(mm) + 1;
        mm = String(mm).padStart(2, '0');
    }
    // var timerdate = mm + '/' + dd + '/' + yyyy;
    // For demo preview end


    // Uncomment below and use your date //

    var timerdate = $("#countdown").data('date');
    if (new Date(new Date(timerdate).toDateString()) <= new Date(new Date().toDateString())) {
        let tomorrow = new Date(new Date());
        tomorrow.setDate(tomorrow.getDate() + 1)
        timerdate =   tomorrow.toISOString().slice(0,10);
    }

    $("#countdown").countdown(timerdate, function (event) {
        $(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>დღე</p> </div>" + "<div class='cd-item'><span>%H</span> <p>საათი</p> </div>" + "<div class='cd-item'><span>%M</span> <p>წუთი</p> </div>" + "<div class='cd-item'><span>%S</span> <p>წამი</p> </div>"));
    });

    /*------------------
		Magnific
	--------------------*/
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="fa fa-angle-up dec qtybtn"></span>');
    proQty.append('<span class="fa fa-angle-down inc qtybtn"></span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });

    var proQty = $('.pro-qty-2');
    proQty.prepend('<span class="fa fa-angle-left dec qtybtn"></span>');
    proQty.append('<span class="fa fa-angle-right inc qtybtn"></span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });

    /*------------------
        Achieve Counter
    --------------------*/
    $('.cn_num').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    $('#addToCartButton').on('click', function() {
        event.preventDefault();
        $('#addToCardForm').submit();
    });

    $('#buyNowButton').on('click', function() {
        event.preventDefault();
        $('#buyNowForm').submit();
    });

    $('.deleteCartItemButton').on('click', function (item) {
        event.preventDefault();
        var product_id = $(this).data("product_id");
        $('#deleteProductID').val(product_id);
        $('#deleteCartItemForm').submit();
    });

    $('.qtybtn.dec').on('click', function() {
        event.preventDefault();
        var input =  $(this).siblings('.cartItemQuantity');
        var inputVal = parseInt(input.val()) - 1 > 1 ? parseInt(input.val()) - 1 : 1;
        $('#updateQuantityProductID').val(input.data('product_id'));
        $('#newQuantity').val(inputVal);
        $('#updateQuantity').submit();

    });

    $('.qtybtn.inc').on('click', function(event) {
        
        var input =  $(this).siblings('.cartItemQuantity');
        var inputVal = parseInt(input.val()) + 1;
        if (inputVal > input.data('max_quantity')) {
            event.preventDefault();
            event.stopPropagation();
            Swal.fire({
              title: 'მარაგი ამოიწურა',
              text: 'მარაგში დარჩენილია მხოლოდ '+input.data('max_quantity')+ ' პროდუქტი',
              icon: 'fail',
              confirmButtonText: 'OK',
              customClass: {
                confirmButton: 'swal-ok-button'
              }
            });
            return;
        }
       
        $('#updateQuantityProductID').val(input.data('product_id'));
        $('#newQuantity').val(inputVal);
        $('#updateQuantity').submit();
    });

    $('#LocationSelect').on('change', function (){
        var deliveryPrice = $(this).find(':selected').data('delivery_price');
        var productsPrice =$('#productsPrice').text();
        $('#deliveryPrice').html(deliveryPrice+' ₾');
        $('#totalPrice').html(((parseFloat(deliveryPrice) +  parseFloat(productsPrice)).toFixed(2))+' ₾')

    })

    function clearErrors() {
        $('.error-message').remove();
        $('input').css('border', '1px solid #ced4da');
    }

    // On form submit, validate the form
    $('#CheckoutForm').on('submit', function (e) {
        e.preventDefault();  // Prevent the form from submitting until validation is checked
        clearErrors(); // Clear any existing error messages

        let isValid = true;

        // First Name and Last Name Validation
        $('input[name="first_name"], input[name="last_name"]').each(function () {
            if ($(this).val().trim() === '') {
                $(this).css('border', '1px solid red')
                    .after('<span class="error-message" style="color:red; font-size:12px;">გთხოვთ შეავსოთ ეს ველი</span>');
                isValid = false;
            }
        });

        // ID Number Validation
        let idNumber = $('input[name="id_number"]').val();
        if (idNumber === '' || !/^\d{11}$/.test(idNumber)) {
            $('input[name="id_number"]').css('border', '1px solid red')
                .after('<span class="error-message" style="color:red; font-size:12px;">პირადი ნომერი უნდა იყოს 11 ნიშნა</span>');
            isValid = false;
        }

        // Address Validation
        let address = $('input[name="address"]').val();
        if (address.trim() === '') {
            $('input[name="address"]').css('border', '1px solid red')
                .after('<span class="error-message" style="color:red; font-size:12px;">გთხოვთ შეავსოთ მისამართი</span>');
            isValid = false;
        }

        // Phone Number Validation
        let phoneNumber = $('input[name="phone_number"]').val();
        if (phoneNumber === '' || !/^\+?\d{1,3}(\s?\d{2,3}){2,5}$/.test(phoneNumber)) {
            $('input[name="phone_number"]').css('border', '1px solid red')
                .after('<span class="error-message" style="color:red; font-size:12px;">გთხოვთ შეიყვანოთ სწორი ნომერი</span>');
            isValid = false;
        }

        // Terms and Conditions Checkbox Validation
        if (!$('#acc-or').is(':checked')) {
            $('#acc-or').after('<span class="error-message" style="color:red; font-size:12px;">გთხოვთ, დაეთანხმოთ წესებს და პირობებს</span>');
            isValid = false;
        }

        // Submit the form if validation passes
        if (isValid) {
            this.submit();
        }
    });

    // Clear error message on input focus
    $('input, #acc-or').on('focus change', function () {
        $(this).next('.error-message').remove();
        $(this).css('border', '1px solid #ced4da');
    });


    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#addToCartFromList input[name="product_id"]').val($(this).data('product-id'));
        $('#addToCartFromList').submit();

    });
    
    $('#LocationSelect').select2({
        width: 'resolve',
        placeholder: "Select a location",
        width: '100%',  // Ensures the select takes up 100% width of its container
        // allowClear: true // Adds a clear button to remove selection
    });

})(jQuery);
