// COOKIE ACCEPTED
export function isCookieAccepted() {
    const isCookieAccepted = localStorage.getItem('isCookieAccepted');
    if(isCookieAccepted === 'true') {
        $('.cookie-policy').slideUp();
    } else {
        $('.cookie-policy').slideDown();
    }
}

// START LOADER
export function startLoader() {
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

// EXIT LOADER
export function exitLoader() {
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

export function toastMessage(response) {
    if(response.status === 'error') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.message,
            confirmButtonText: 'GOT IT',
            confirmButtonColor: '#801313',
        });
    } else if(response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Yey...',
            text: response.message,
            confirmButtonText: 'GOT IT',
            confirmButtonColor: '#801313',
        });
    }
}

export function activeFaculty() {
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

export function seeMore() {
    const maxChars = 800;

    // Select all elements with the 'text-overlap' class
    const textElements = $('.text-overlap');
    
    textElements.each(function() {
        const textElement = $(this);
        const originalText = textElement.text();
        const truncatedText = originalText.substring(0, maxChars);
    
        if (originalText.length > maxChars) {
            textElement.html(truncatedText + '...' + '<a href="javascript:void(0)" class="see-more-option text-link ms-2" style="text-decoration: underline; font-size: inherit;">See More</a>');
        }
    
        let isOpen = false;
    
        // Use event delegation to handle click events on 'See More'/'See Less' links
        textElement.on('click', '.see-more-option', function() {
            if (!isOpen) {
                isOpen = true;
                textElement.html(originalText + '<a href="javascript:void(0)" class="see-more-option text-link ms-2" style="text-decoration: underline; font-size: inherit;">See Less</a>');
            } else {
                isOpen = false;
                textElement.html(truncatedText + '...' + '<a href="javascript:void(0)" class="see-more-option text-link ms-2" style="text-decoration: underline; font-size: inherit;">See More</a>');
            }
        });
    });
    
    
}

export function testimonialControls() {
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