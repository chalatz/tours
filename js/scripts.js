(function($){

    var site_menu = $('#site-menu'),
        site_menu_items = $('#site-menu__items'),
        menu_top_offset = site_menu.position().top;

    site_menu_height = site_menu.height();

    // Toggles the sliding of the mobilemenu
    var handle_menu = function() {

        var menu_header = $('#site-menu__header')
            site_menu = $('#site-menu');

        menu_header.on('click', function(e){
            site_menu.toggleClass('site-menu--mobile');
            site_menu_items.slideToggle();
        });

    };

    // Toggles the sliding of the mobilemenu's subitems
    var handle_submenu = function(){
        var parent_item = $('.site-menu__item--with-subitems');

        if(window.innerWidth < 1024){

            parent_item.on('click', function(e){
                e.preventDefault();
                var $this = $(this),
                    submenu = $this.find('.site-menu__subitems'),
                    angle_icon = $this.find('.site-menu__angle-icon');

                $this.children().on('click', function(e){
                    e.stopPropagation();
                });

                angle_icon.toggleClass('fa-angle-down fa-angle-up');

                submenu.slideToggle();
            });
        } else {
            parent_item.hoverIntent(function(){
                var $this = $(this),
                    submenu = $this.find('.site-menu__subitems'),
                    angle_icon = $this.find('.site-menu__angle-icon'),
                    the_link = $this.find('.site-menu__link site-menu__sublink');

                angle_icon.toggleClass('fa-angle-down fa-angle-up');

                submenu.slideToggle();
            });
        }

    };

    // window.onscroll = function() {sticky_header()};

    // Get the navbar
    var navbar = document.getElementById("site-menu");
    // Get the offset position of the navbar
    var sticky = navbar.offsetTop;

    // sticky header
    var sticky_header = function(){
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky-nav")
        } else {
            navbar.classList.remove("sticky-nav");
        }

    };

    // Toggles the sliding of the langs selector
    var handle_langs_selector = function() {

        var active_lang = $('#langs__item--active'),
            inactive_langs = $('#langs__inactives');

        active_lang.on('click', function(e){
            $('#langs__item--active-icon').toggleClass('fa-angle-down fa-angle-up');
            inactive_langs.slideToggle();
            $(this).toggleClass('langs-item-activated');
        });

    };

    // scrolls to the corresponing section when menu with internal href is clicked
    var scroll_to = function(button_id, the_href){

        $('#'+button_id).on('click', function(event){
            var $this = $(this),
                menu_item = $this.parent('.site-menu__item'),
                internal_menu_item = $('.site-menu__item--internal');

                if(window.innerWidth < 768){
                    site_menu_items.fadeOut();
                }

            internal_menu_item.removeClass('site-menu__item--active');

            menu_item.addClass('site-menu__item--active');

            $('html, body').animate({
                scrollTop: $('#'+the_href).offset().top - site_menu_height - 6
            }, 1000, function(){
                internal_menu_item.removeClass('site-menu__item--active');
                menu_item.addClass('site-menu__item--active');
            });

            event.preventDefault();
        });
    };

    // Sticky menu
    var stick_it = function(el, top_offset, el_height){

        var current_scroll_pos = $(document).scrollTop(),
            body_width = $('body').width(),
            window_width = window.innerWidth;

        if(current_scroll_pos >= top_offset){
            el.addClass('sticky');
            if(window_width >= 768){
                el.css('width', body_width + 'px');
            }
            el.next().css('padding-top', el_height + 'px');
        } else {
            el.removeClass('sticky');
            if(window_width >= 768){
                el.css('width', '100%');
            }
            el.next().css('padding-top', 'initial');
        }

    };

    $(window).on('resize', function(){
        var body_width = $('body').width(),
            window_width = window.innerWidth,
            menu_top_offset = site_menu.position().top
            langs__inactives = $('#langs__inactives'),
            active_lang = $('#langs__item--active');

        site_menu_height = site_menu.height()

        // if(window_width >= 768 && site_menu.hasClass('sticky')){
        //     site_menu.css('width', body_width + 'px');
        // }
        // if(window_width < 768 && site_menu.hasClass('sticky')){
        //     site_menu.css('width', '100%');
        // }

        // Deal with langs selector bug on resize
        if(window_width < 768){
            langs__inactives.css('display', 'inline-block');
        } else {
            if(active_lang.hasClass('langs-item-activated')){
                langs__inactives.css('display', 'block');
            } else {
                langs__inactives.css('display', 'none');
            }
        }

    });

    var internal_menu_links = $('.site-menu__link--internal'),
        last_scroll_item_id;

    var scroll_items = internal_menu_links.map(function(){
        var item = $($(this).attr("href"));
        if (item.length) {
             return item;
        }
    });

    // On scroll, highlight the corresponding internal menu link
    var activate_menu = function(scroll_items, internal_menu_links){

        // Get document scroll position
        var fromTop = $(document).scrollTop() + site_menu_height;

        // Get id of current scroll item
        var cur = scroll_items.map(function(){
            if ($(this).offset().top < fromTop)
            return this;
        });

        // Get the id of the current element
        cur = cur[cur.length-1];
        var scroll_item_id = cur && cur.length ? cur[0].id : "";

        if (last_scroll_item_id !== scroll_item_id) {
            last_scroll_item_id = scroll_item_id;
            // Set/remove active class
            internal_menu_links.each(function(){
                var $this = $(this),
                    menu_item = $this.parent('.site-menu__item');
                menu_item.removeClass('site-menu__item--active');
                if($this.attr('href') == '#'+scroll_item_id){
                    menu_item.addClass('site-menu__item--active');
                }
            });
        }

    };

    //$(window).on('scroll', function(){
        //stick_it(site_menu, menu_top_offset, site_menu_height);
        //activate_menu(scroll_items, internal_menu_links);
    //});

    var handle_pop_form = function(){

        var button = $('#pop-form-button'),
            pop_form = $('#pop-form'),
            close_button = $('#pop-form__close');

        button.on('click', function(){
            var $this = $(this)
                button_width = $this.width();
            $this.animate({
                opacity: 0,
                left: '-=' + button_width
            }, 500);
            pop_form.show().animate({
                opacity: 1,
                bottom: 0
            });
        });

        close_button.on('click', function(){
            pop_form.animate({
                opacity: 0,
                bottom: '-=3rem'
            }, 300, function(){
                pop_form.hide();
            });
            button.animate({
                opacity: .9,
                left: '.5rem'
            }, 300);
        });

    }

    var goto_top = function(){

        $(window).scroll(function(event){
            var scroll = $(window).scrollTop();
            if (scroll >= 1500) {
              $(".go-top").addClass("show");
            } else {
              $(".go-top").removeClass("show");
            }
          });

          $('#scrollBtn').click(function(event){
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            event.preventDefault();
          });

    };

    slide_tour_content = function(){

        var button = $('.tour__read-more');

        button.on('click', function(){
            var $this = $(this),
                content = $this.siblings('.collapsible'),
                icon = $this.find('.tour__read-more-arrow-icon'),
                text = $this.find('.text');

            content.slideToggle(500);

            $this.toggleClass('content-shown');

            icon.toggleClass('fa-angle-up fa-angle-down');

            if($this.hasClass('content-shown')){
                text.text('Hide');
            } else {
                text.text('Read');
            }

        });

    }

    var handle_faq = function(){

        var que = $('.faq__q'),
            ans = $('.faq__a'),
            is_large = false;

        $(window).on('resize', function() {
            is_large = window.innerWidth > 768;
        });

        if(window.innerWidth > 768) {
            is_large = true;
        }

        ans.hide();

        que.on('click', function(){

            if(is_large === false){

                var $this = $(this),
                    ans = $this.siblings('.faq__a'),
                    icon = $this.children('.faq__icon');

                ans.slideToggle();

                icon.toggleClass('rotate-45');
            }

        });

    }

    var fill_year = function(){
        var current_year = (new Date()).getFullYear();

        $('#year-input').val(current_year);
    };


    var getUrlParam= function(name) {
        var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return (results && results[1]) || undefined;
    }

    var handle_contact_form_post = function(){

        var form_status = getUrlParam('contact-form-sent');

        if (form_status === 'success') {
            var msg_div = $('#msg'),
                msg_close = $('#msg-close'),
                msg_content =
                    '<span id="msg-close"><i class="fas fa-window-close msg__close"></i></span>' +
                    '<h1 class="msg__title">Email Sent!</h1>' +
                    '<p>Thank you for the interest that you\'ve shown in our services. Your request was sent successfully and will be processed soon.</p>';

            msg_div.html(msg_content);

            msg_div.show();

            $(msg_div).on('click', '#msg-close', function(e){
                $(msg_div).fadeOut(300);
            });
        }

        if (form_status === 'fail') {
            var msg_div = $('#msg'),
                msg_close = $('#msg-close'),
                msg_content =
                    '<span id="msg-close"><i class="fas fa-window-close msg__close"></i></span>' +
                    '<h1 class="msg__title">Something went wrong</h1>' +
                    '<p class="centered">Please try to fill the form again.</p>' +
                    '<p class="centered">If the problem persists, please try to contact us directly at <a href="mailto:request@RhodesPrivateTours.com">request@RhodesPrivateTours.com</p>';

            msg_div.addClass('msg--fail')

            msg_div.html(msg_content);

            msg_div.show();

            $(msg_div).on('click', '#msg-close', function(e){
                $(msg_div).fadeOut(300);
            });
        }

        if (form_status === 'validation-error') {
            var msg_div = $('#msg'),
                msg_close = $('#msg-close'),
                msg_content =
                    '<span id="msg-close"><i class="fas fa-window-close msg__close"></i></span>' +
                    '<h1 class="msg__title">Missing field(s)</h1>' +
                    '<p class="centered">Please try to fill all the fields before submitting.</p>' +
                    '<p class="centered">If the problem persists, please try to contact us directly at <a href="mailto:request@RhodesPrivateTours.com">request@RhodesPrivateTours.com</p>';

            msg_div.addClass('msg--fail');

            msg_div.html(msg_content);

            msg_div.show();

            $(msg_div).on('click', '#msg-close', function(e){
                $(msg_div).fadeOut(300);
            });
        }

    };

    var handle_form_loader = function(){
        $('#contact-form').on('submit', function(){
            var the_btn = $('#form__submit');
            the_btn
                .html('<i class="fas fa-circle-notch fa-spin"></i> Sending email...')
                .addClass('form__submit--sending');
        });
    };

    var handle_privacy_modal = function(){

        // Hide modal on ESC key
        var the_modal = $('#privacy-terms');

        // $(document).on('keydown', function(e){
        //     if(the_modal.is(':visible') && e.keyCode == 27){
        //         $.fancybox.close();
        //     }
        // });

        // Hide menu if a click takes place outside of menu area
        // $(document).on('click', function(event){
        //     if(!$(event.target).closest('#privacy-terms').length && !$(event.target).closest('#open-privacy-modal').length){
        //         $.fancybox.close();
        //     }
        // });

        // the_modal.on('dblclick', function(e){
        //     $.fancybox.close();
        // });

        the_modal.on('doubleTap', function(e){
            $.fancybox.close();
        });

    };

    fill_year();

    handle_faq();

    handle_menu();

    handle_submenu();

    handle_langs_selector();

    handle_pop_form();

    goto_top();

    slide_tour_content();

    handle_contact_form_post();

    handle_form_loader();

    handle_privacy_modal();

    // scroll_to('goto-rhodes-sites', 'rhodes-sites');
    // scroll_to('goto-more-info', 'more-info');

    //   $('[data-fancybox="tour-gallery"]').fancybox({
    //     loop: true
    //   });

})(jQuery);