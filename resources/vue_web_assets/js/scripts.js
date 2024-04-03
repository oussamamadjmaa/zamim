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
    const userPreferredMode = getCookie("preferredMode");

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
        setCookie("preferredMode", "dark-mode", 30, "."+window.location.hostname);
    } else {
        $("body").removeClass('dark-mode').addClass('light-mode');
        setCookie("preferredMode", "light-mode", 30, "."+window.location.hostname);
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

// Define function to set cookie
function setCookie(name, value, days, domain) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/; domain=" + domain;
}

function getCookie(cookieName) {
    var name = cookieName + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(';');
    for(var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) == 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}
