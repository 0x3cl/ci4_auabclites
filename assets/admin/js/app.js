$(document).ready(function() {

    // HAMBURGER
    let isActive = false;
    $('.hamburger-wrapper').on('click', () => {
        const isActive = $('.hamburger-wrapper').hasClass('active');
        if (!isActive) {
            $('.hamburger-wrapper, .sidebar, .content, .logo h4').addClass('active');
            $('.multi-collapse').collapse('hide');
        } else {
            $('.hamburger-wrapper, .sidebar, .content, .logo h4').removeClass('active');
        }
    });
    
    // SHOW SIDEBAR MENU WHEN CLICKED IN COLLAPSE STATE
    $('.menu-content .icon').on('click', menuShowWhenCollapse);
    function menuShowWhenCollapse() {
        if ($(window).width() >= 768) {
            $('.hamburger-wrapper, .sidebar, .content, .logo h4').removeClass('active');
            console.log($(window).width());
        }
    }

    // COLLAPSE ONLY WHAT IS CLICKED, HIDE OTHERS
    $('.multi-collapse').on('show.bs.collapse', function () {
        $('.multi-collapse').not(this).collapse('hide');
    });

    // SHOW BTN-SCROLL WHEN WINDOW SCROLLS DOWN
    $(window).on('scroll', () => {
        const scrollTop = $(window).scrollTop();
        if(scrollTop > 50) {
            $('.navbar').addClass('active');
            $('.scroll-top').addClass('active');
        } else {
            $('.navbar').removeClass('active');
            $('.scroll-top').removeClass('active');
        }
    });

    // SCROLL TO TOP WHEN BTN-SCROLL CLICKED
    $('.scroll-top').on('click', () => {
        $('html, body').animate({
            scrollTop: $('html, body').offset().top
        }, 'slow') 
    });

    // TOGGLE THEME
    // let isDark = false;
    // $('#btn-toggle-theme').on('click', () => {
    //     if(!isDark) {
    //         $('body').addClass('dark');
    //         $('#btn-toggle-theme').html('<i class="bx bxs-sun"></i> Switch Light ');
    //         $('.logo img').attr('src', '/assets/admin/images/logo-light.png');
    //         isDark = true;
    //     } else {
    //         $('body').removeClass('dark');
    //         $('#btn-toggle-theme').html('<i class="bx bx-moon"></i> Switch Dark ');
    //         $('.logo img').attr('src', '/assets/admin/images/logo-dark.png');
    //         isDark = false;
    //     }
    // });

    // INITIALIZE DATATABLES CONFIGURATION
    $('table').DataTable({
        // stateSave: true,
        responsive: true,
        scrollX: true,
        autoWidth: true,
        // scrollY: '',
        // scrollCollapse: true,
        // paging: true,
        // order: [[0, 'desc']]
    });

    // EVENT HANDLER FOR BULLETIN PAGE WHEN OPTION WAS CHANGED
    $('#news-form select#category').on('change', function() {
        if($(this).val() == 'news') {
            $('#news-form .other').html(`
            <div class="col-12 col-md-12 mb-3">
                <label class="fw-bold">Content Images</label>
                <div class="d-flex gap-3 mt-2">
                    <div class="dropbox d-flex justify-content-center align-items-center">
                        <input type="file" name="content-image[]" id="content-image" multiple>
                    </div>
                </div>
            </div>
            `);   
        } else {
            $('#news-form .other').empty();
        }
    });
});

