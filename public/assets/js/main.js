(function($){

    "use strict";

    $(window).on('load', function() {
        $('body').addClass('animation');
    });

    $(document).ready(function(){

        // links to
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(t) {
            if (location.pathname.replace(/^\//, "") === this.pathname.replace(/^\//, "") && location.hostname === this.hostname) {
                var e = $(this.hash);
                (e = e.length ? e : $("[name=" + this.hash.slice(1) + "]")).length && (t.preventDefault(),
                $("html, body").animate({
                    scrollTop: e.offset().top
                }, 1e3, function() {
                    var t = $(e);
                    if (t.focus(),
                    t.is(":focus"))
                        return !1;
                    t.attr("tabindex", "-1"),
                    t.focus()
                }))
            }
        });

        // reviews
        if ($('.swiper-container').length>0){
            var mySwiper = new Swiper('.swiper-container', {
                autoplay: {delay: 3000,},
                loop: false,
                grabCursor: true,
                slidesPerView: 3,
                breakpoints: {
                    414: {slidesPerView: 1},
                    800: {slidesPerView: 3}
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }
            });
        }

    });
})(this.jQuery);
