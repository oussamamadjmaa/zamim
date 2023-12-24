$(document).ready(function () {
    //AOS Init
    AOS.init({
      offset: 100,
      easing: 'ease-in-out',
      delay: 100,
    });

    //remove toggle-nav class from body
    $("body").removeClass('toggle-nav')

    //Dark & light mode
    const userPreferredMode = localStorage.getItem("preferredMode");

    if (userPreferredMode === "dark-mode" || (!userPreferredMode && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        $("body").addClass('dark-mode');
        $('#darkModeToggle').prop('checked', true);
    } else if (userPreferredMode === "light-mode") {
        $("body").addClass('light-mode');
        $('#darkModeToggle').prop('checked', false);
    }
});

//Navbar actions
$(document).on('click', '.toggle-nav-menu', function () {
    $("body").toggleClass('toggle-nav')
})

$(document).on('click', '.nav-overlay', function () {
    $("body").removeClass('toggle-nav')
})

// Toggle dark mode when the switch is clicked
$(document).on('change', '#darkModeToggle', function () {
    if ($(this).is(':checked')) {
        $("body").removeClass('light-mode').addClass('dark-mode');
        localStorage.setItem("preferredMode", "dark-mode");
    } else {
        $("body").removeClass('dark-mode').addClass('light-mode');
        localStorage.setItem("preferredMode", "light-mode");
    }
});

//
$(document).on('click', 'a[href^="#"]', function (e) {
    // target element id
    var id = $(this).attr('href');

    // target element
    var $id = $(id);
    if ($id.length === 0) {
        return;
    }

    // prevent standard hash navigation (avoid blinking in IE)
    e.preventDefault();

    // top position relative to the document
    var pos = $id.offset().top;

    // animated top scrolling
    $('body, html').animate({ scrollTop: pos });
});


//
var lastScrollTop = 0;
$(window).scroll(function (event) {
    var st = $(this).scrollTop();

    if ($(document).scrollTop() > 10) {
        $('body').css('padding-top', $('#header').height());
        $('#header').addClass('fixed-nav');
    }
    else {
        $('body').css('padding-top', 0);
        $('#header').removeClass('fixed-nav');
    }

    if (st > lastScrollTop && $(document).scrollTop() > $('#header').height() * 2) {
        $("#header").addClass('hide');
    } else {
        $("#header").removeClass('hide');
    }
    lastScrollTop = st;
});
