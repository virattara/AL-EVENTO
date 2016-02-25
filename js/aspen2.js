$(document).ready(function(){

$(".page-scroll").hover(function(){
	$(this).css("background-color", "#3F4545");
    }, function(){
    $(this).css("background-color", "#0D47A1");
    });

$(".page-scroll").click(function () {
        $(".page-scroll").removeClass("active");
        $(this).addClass("active");     
    });

$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash;
	    var $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	        
	    });
	});

function reload_js(src) {
        $('script[src="' + src + '"]').remove();
        $('<script>').attr('src', src).appendTo('head');
    }
    reload_js('aspen2.js');


});
