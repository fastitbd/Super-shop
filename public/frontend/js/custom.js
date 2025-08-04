$(document).ready(function () {

    $('.banner_image').owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        autoplay: true,
        smartSpeed: 200,
        autoplaySpeed: 6000,
        responsiveClass: true,
        nav:true,
      navText: ['<i class="fa-solid fa-angle-double-left arrow_lf"></i>','<i class="fa-solid fa-angle-double-right arrow_rt"></i>'],
        responsive: {
            0: {
                items: 1,
                
            },
            576: {
                items: 1,
               
            },
            768: {
                items: 1,
                
            },
            1000: {
                items: 1,
               
            },
            1200: {
                items: 1,
               
            }
        }
    });
    
    
    $('.banner_cart_slider').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        autoplay: true,
        smartSpeed: 200,
        autoplaySpeed: 6000,
        responsiveClass: true,
        nav:true,
      navText: ['<i class="fa-solid fa-arrow-left arrow_lf_card"></i>','<i class="fa-solid fa-arrow-right arrow_rt_card"></i>'],
        responsive: {
            0: {
                items: 2,
                
            },
            576: {
                items: 3,
               
            },
            768: {
                items: 3,
                
            },
            1000: {
                items: 4,
               
            },
            1200: {
                items: 4,
               
            }
        }
    });
    
      $('.product_slider').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        autoplay: false,
        smartSpeed: 200,
        autoplaySpeed: 6000,
        responsiveClass: true,
        nav:true,
      navText: ['<i class="fa-solid fa-angle-left arrow_lf_product"></i>','<i class="fa-solid fa-angle-right arrow_rt_product"></i>'],
        responsive: {
            0: {
                items: 2,
                
            },
            576: {
                items: 2,
               
            },
            768: {
                items: 3,
                
            },
            1000: {
                items: 6,
               
            },
            1200: {
                items: 6,
               
            }
        }
    });

  
});


