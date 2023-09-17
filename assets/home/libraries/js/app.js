// IMPORT NECESSARY METHODS / HELPER FUNCTIONS

import { toastMessage, isCookieAccepted, startLoader,
        exitLoader, activeFaculty, seeMore,
        testimonialControls } from "./helpers.js";

// INITIALIZE AOS
AOS.init();
startLoader();
setTimeout(() => {
    exitLoader() 
}, 3000);
isCookieAccepted();
activeFaculty();
seeMore();
testimonialControls();

// ACCEPT COOKIE
$('#cookie-accept').click(function() {
    localStorage.setItem('isCookieAccepted', 'true');
    isCookieAccepted();
});

// DESCLINE COOKIE
$('#cookie-decline').click(function() {
    localStorage.setItem('isCookieAccepted', 'false');
    $('.cookie-policy').fadeOut();
    setTimeout(() => {
        isCookieAccepted();
    }, 3000);
});

// SHOW HEADER WHEN WINDOW SCROLL
$(window).scroll(function() {
    if($(this).scrollTop() > 200) {
        $('.scroll-top').addClass('active');
    } else {
        $('.scroll-top').removeClass('active');
    }

    $('.scroll-top').on('click', function() {
        $(this).animate({
            scrollTop: $('html, body').scrollTop(0)
        }, 'slow');
    })

});

// HAMBURGER ANIMATION
let isSidebarActive = false;
$('.hamburger-wrapper').click(function() {
    if(!isSidebarActive) {
        $(this).addClass('active');
        $('.sidebar').addClass('active');
        $('.group-content').addClass('blur');
        isSidebarActive = true;
    } else {
        $(this).removeClass('active')
        $('.sidebar').removeClass('active');
        $('.group-content').removeClass('blur');
        isSidebarActive = false;
    }
    
});

// HIDE SIDEBAR WHEN GROUP CONTENT CLICKED
$('.group-content').click(function() {
    if(isSidebarActive) {
        $('.hamburger-wrapper').removeClass('active');
        $('.sidebar').removeClass('active');
        $('.group-content').removeClass('blur');
    }
});

// INITIALIZE LIGH GALLERY PLUGIN
lightGallery(document.getElementById('light-gallery'), {
    selector: '.item',
    plugins: [lgZoom, lgThumbnail],
    download: false,
    licenseKey: 'your_license_key',
    speed: 500,
});

// SELECT OFFICERS CONTROLS
$(document).on('click', '#select-officer', function(e) {
    e.preventDefault();
    const key = $(this).data('id')

    var selectedItem = $(this);
    var container = $('.officer-names');
    const scrollTo = selectedItem.offset().top - container.offset().top + container.scrollTop() - (container.height() / 2);
    container.animate({
        scrollTop: scrollTo
    }, 500);

    $('#select-officer.active').removeClass('active');
    $('.officer-image .item').removeClass('active');

    $('#select-officer[data-id="'+key+'"]').addClass('active');
    $('.officer-image .item[data-id="'+key+'"]').addClass('active');

    $('#about-officer .item').removeClass('active');
    $('#about-officer .item[data-id="'+key+'"]').addClass('active');
 
});

// SUBSCRIBE NEWSLETTER CONTROL
$('#btn-subscribe').on('click', function() {
    const email = $('#newsletter-email').val().trim()
     $.ajax({
         url: '/auabclites/api/v1/insert/newsletter',
         method: 'POST',
         data: {
             'email': email
         }, beforeSend() {
             $('#btn-subscribe').attr('disabled', true);
         }, success: function(response) {
             toastMessage(response);
         }
     }).done(function() {
         $('#btn-subscribe').attr('disabled', false);
     });
 });

//  REDIRECT PAGE
 $('.redirect-page').on('click', function() {
    const src = $(this).data('src');
    window.location.href = src;
});

