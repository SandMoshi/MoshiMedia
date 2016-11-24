$(document).ready(function () {
    /***************** Navbar-Collapse ******************/

    $(window).scroll(function () {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });

    /***************** Page Scroll ******************/

    $(function () {
		 
		 
		 if( window.innerWidth > 767 ){
       // offset code to 53 on not mobile
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top -50
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
		 }
		 else{
        // offset code to 0 on mobile
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
		 }
    });

    /***************** Scroll Spy ******************/

    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    })

    /***************** Owl Carousel ******************/

    $("#owl-hero").owlCarousel({

        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        transitionStyle: "fadeUp",
        autoPlay: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]

    });


    /***************** Full Width Slide ******************/

    var slideHeight = $(window).height();

    $('#owl-hero .item').css('height', slideHeight);

    $(window).resize(function () {
        $('#owl-hero .item').css('height', slideHeight);
    });
    /***************** Owl Carousel Testimonials ******************/

    $("#owl-testi").owlCarousel({

        navigation: false, // Show next and prev buttons
        paginationSpeed: 400,
        singleItem: true,
        transitionStyle: "backSlide",
        autoPlay: true

    });
    /***************** Countdown ******************/

    $('#fun-facts').bind('inview', function (event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $(this).find('.timer').each(function () {
                var $this = $(this);
                $({
                    Counter: 0
                }).animate({
                    Counter: $this.text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
            $(this).unbind('inview');
        }
    });
    /***************** Google Map ******************/

    function initialize() {
        var mapCanvas = document.getElementById('map');
        var mapOptions = {
            center: new google.maps.LatLng(54.422471, -110.2044194,11.75),
            zoom: 11,
			   draggable: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
					  scrollwheel: false,
						disableDefaultUI: true,
					
        }
        var map = new google.maps.Map(mapCanvas, mapOptions);
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    /***************** Wow.js ******************/
    
    new WOW().init();
    
    /***************** Preloader ******************/
    
    var preloader = $('.preloader');
    $(window).load(function () {
        preloader.remove();
    });
})

   /***************** Contact Form Submission ******************/

$(document).ready(function (e){
$("#main-contact-form").on('submit',(function(e){
	e.preventDefault();
	$('#sendingemail').fadeIn();
		$.ajax({
		url: "../sendemail.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		success: function(data){
			console.log(data);
			if (data.type == 'Error') {
					//alert(data.message);
				  $('#sendingemail').fadeOut();
				  $("#notsent").html(data.message).fadeIn();
				}
			else{
				$('#sendingemail').fadeOut();
				$('#emailsent').fadeIn();
			  //alert(data.message);
			}
		},
	  error: function(XHR,textStatus,errorThrown) {
    		//alert("error");
			  console.log(XHR.status + "..." + textStatus + "..." + errorThrown);
			  alert(XHR.status);
    		alert(textStatus);
    		alert(errorThrown);
		}
	}	        
 );
}));
});
   /***************** Navbar Collapse on Click ******************/
$(document).ready(function (e){
		$('.nav>li>a').on('click', function(){
				$('.navbar-collapse').collapse('hide');
		});
});