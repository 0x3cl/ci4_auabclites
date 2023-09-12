// INITIALIZE AOS

AOS.init();

startLoader();

setTimeout(() => {
    exitLoader() 
}, 3000);

isCookieAccepted();

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

$('.group-content').click(function() {
    if(isSidebarActive) {
        $('.hamburger-wrapper').removeClass('active');
        $('.sidebar').removeClass('active');
        $('.group-content').removeClass('blur');
    }
});

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

// LOAD LOADER

function startLoader() {
    const loaders = ['.loader-primary', '.loader-secondary', '.loader-tertiary', '.loader-content'];
    let delay = 0;
    
    loaders.forEach((loader) => {
        setTimeout(() => {
            $(loader).css('left', '0');
        }, delay);
        delay += 200;
    });

    setTimeout(() => {
        $('.loader-content .logo-content').fadeIn(500);
    }, delay);
}

function exitLoader() {
    $('.loader-content .logo-content').fadeOut(500, () => {
        const loaders = ['.loader-primary', '.loader-secondary', '.loader-tertiary', '.loader-content'];
        let delay = 200;

        loaders.reverse().forEach((loader) => {
            setTimeout(() => {
                $(loader).css('left', '100%');
            }, delay);
            delay += 200;
        });

        setTimeout(() => {
            $('.loader').fadeOut();
        }, delay);
    });
}

function isCookieAccepted() {
    const isCookieAccepted = localStorage.getItem('isCookieAccepted');
    if(isCookieAccepted === 'true') {
        $('.cookie-policy').slideUp();
    } else {
        $('.cookie-policy').slideDown();
    }
}

let activeIndex = 2; 

// function changeLogo(direction) {
//     const orgLogos = $('.org-logo');
//     const orgDesc = $('.org-description');
    
//     $(orgLogos[activeIndex]).removeClass('active');
//     $(orgDesc[activeIndex]).removeClass('active');

//     activeIndex += direction;

//     if (activeIndex < 0) {
//         activeIndex = orgLogos.length - 1;
//     } else if (activeIndex >= orgLogos.length) {
//         activeIndex = 0;
//     }

//     $(orgLogos[activeIndex]).addClass('active');
//     $(orgDesc[activeIndex]).addClass('active');
// }

// changeLogo(0);

activeFaculty();

function activeFaculty() {
    const facultyContainer = $('#carousel-container');
    const item = $('.carousel-image');
    let centeredIndex = Math.floor(item.length / 2); // Index 7 corresponds to the 8th item
    let order;

    let selected = centeredIndex;

    if(selected % 2 == 0) {
        centeredIndex = centeredIndex + 1;   
    }

    function setActiveItem() {
        item.removeClass('active');
        $('.carousel-image').eq(selected).addClass('active');
        order = $('.carousel-image').eq(selected).data('order');
        
        $('.carousel-description').removeClass('active');
        $('.carousel-description').eq(order).addClass('active');
    }

    function reorderImages() {
        const reorderedImages = [];
        for (let i = centeredIndex; i < item.length; i++) {
            reorderedImages.push(item.eq(i));
        }
        for (let i = 0; i < centeredIndex; i++) {
            reorderedImages.push(item.eq(i));
        }
        facultyContainer.empty(); // Clear the container
        reorderedImages.forEach(function (image) {
            facultyContainer.append(image);
        });
    }

    reorderImages(); // Initial setup
    setActiveItem();

    $('.control-prev').click(function () {
        const lastElement = facultyContainer.find('.carousel-image:last');
        lastElement.detach();
        facultyContainer.prepend(lastElement);
        centeredIndex = (centeredIndex - 1 + item.length) % item.length;
        reorderImages(); // Reorder the images
        setActiveItem();
    });

    $('.control-next').click(function () {
        const firstElement = facultyContainer.find('.carousel-image:first');
        firstElement.detach();
        facultyContainer.append(firstElement);
        centeredIndex = (centeredIndex + 1) % item.length;
        reorderImages(); // Reorder the images
        setActiveItem();
    });
}

lightGallery(document.getElementById('light-gallery'), {
    selector: '.item',
    plugins: [lgZoom, lgThumbnail],
    download: false,
    licenseKey: 'your_license_key',
    speed: 500,
});

// OFFICERS

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

function removeSmallImages() {
    var minImageWidth = 300; // Minimum width required
    
    $("#light-gallery img").each(function () {
        var image = $(this);
        var imageWidth = image.width(); // Get image width
        
        if (imageWidth < minImageWidth) {
            image.remove(); // Remove the image if it's too small
        }
    });
}

seeMore();

function seeMore() {
    const maxChars = 500;
    const textElement = $('#text-overlap');
    const originalText = textElement.text();
    const truncatedText = originalText.substring(0, maxChars);

    if(originalText.length > maxChars) {
        textElement.html(truncatedText + '...' + '<a href="javascript:void(0)" id="see-more-option" class="text-link ms-2" style="text-decoration: underline; font-size: inherit;">See More</a>');
    }

    let isOpen = false;
    $(document).on('click', '#see-more-option', function () {
        if (!isOpen) {
            isOpen = true;
            textElement.html(originalText + '<a href="javascript:void(0)" id="see-more-option" class="text-link ms-2" style="text-decoration: underline; font-size: inherit;">See Less</a>');
        } else {
            isOpen = false;
            textElement.html(truncatedText + '...' + '<a href="javascript:void(0)" id="see-more-option" class="text-link ms-2" style="text-decoration: underline; font-size: inherit;">See More</a>');
        }
    });
}

testimonialControls();

function testimonialControls() {

    const max = $('#testimonial .testimonial-content .item-content[data-id]').length;

    $(document).on('click', '#testimonial .control-prev', function(e) {
        e.preventDefault();
        const id = $('#testimonial .item-content.active').data('id');
        let target = id - 1;
        if(target < 1) {
            target = max;
        }
        console.log(target);
        navigateView(target)
    });

    $(document).on('click', '#testimonial .control-next', function(e) {
        e.preventDefault();
        const id = $('#testimonial .item-content.active').data('id');
        let target = id + 1;
        if(target > max) {
            target = 1
        }
        navigateView(target)
    });

    function navigateView(target) {
        $('#testimonial .testimonial-content .item-content').removeClass('active');
        $('#testimonial .testimonial-content .item-content[data-id="'+target+'"]').addClass('active');
    }

}

$('#btn-subscribe').on('click', function() {
   const email = $('#newsletter-email').val().trim()
    $.ajax({
        url: '/auabclites/api/v1/insert/newsletter',
        method: 'POST',
        data: {
            'email': email
        }, success: function(response) {
            console.log(response);
        }
    })
});