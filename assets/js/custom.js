jQuery(function ($) {

    // Dropdown menu
    $(".sidebar-dropdown > a").click(function () {
        $(".sidebar-submenu").slideUp(200);
        if ($(this).parent().hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }
    });
    // /Dropdown menu

    // for highlight sidebar-submenu that selected
    $(".sidebar-submenu a").click(function() {        
        $(".sidebar-submenu a").removeClass("active");
        $(".sidebar-wrapper ul li a").removeClass("active");
        $(this).addClass("active");
    });
    $(".sidebar-wrapper ul li a").click(function() {
        $(".sidebar-submenu a").removeClass("active");
        $(this).addClass("active");
    });
    var urlPage = $(location).attr("pathname").split(/(\\|\/)/g).pop();
    var findCurrentPage = $(".sidebar-submenu a");
    var findCurrentPageNoDropdown = $(".sidebar-wrapper ul li a:last");
    // console.log(urlPage);
    // console.log(findCurrentPage);
    // console.log(findCurrentPageNoDropdown.eq(0).attr("href"));
    if (findCurrentPageNoDropdown.eq(0).attr("href") === urlPage) {
        findCurrentPageNoDropdown.eq(0).addClass("active");
        // add this code by myself for highlight last link in submenu (formal-outage-line.html)
        findCurrentPageNoDropdown.eq(0).closest(".sidebar-dropdown").addClass("active");
        findCurrentPageNoDropdown.eq(0).closest(".sidebar-submenu").slideDown(200);
        // /add this code by myself for highlight last link in submenu (formal-outage-line.html)
    } else {
        for (let i = 0; i < findCurrentPage.length; i++) {
            if (findCurrentPage.eq(i).attr("href") === urlPage) {
                // $(".sidebar-submenu").slideUp(200);
                findCurrentPage.eq(i).addClass("active");
                findCurrentPage.eq(i).closest(".sidebar-dropdown").addClass("active");
                findCurrentPage.eq(i).closest(".sidebar-submenu").slideDown(200);
            }
        }
    }
    // /for highlight sidebar-submenu that selected

    // close sidebar 
    $("#close-sidebar").click(function () {
        $(".page-wrapper").removeClass("toggled");
    });

    //show sidebar
    $("#show-sidebar").click(function () {
        $(".page-wrapper").addClass("toggled");
    });

    //hide sidebar when small screen device
    if ($(window).width() <= 768) {
        $(".page-wrapper").removeClass("toggled");
    } else {
        $(".page-wrapper").addClass("toggled");
    }

    $(window).resize(function() {
        if ($(window).width() <= 768) {
            $(".page-wrapper").removeClass("toggled");
        } else {
            $(".page-wrapper").addClass("toggled");
        }
    });

    //custom scroll bar is only used on desktop
    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $(".sidebar-content").mCustomScrollbar({
            axis: "y",
            autoHideScrollbar: true,
            scrollInertia: 300
        });
        $(".sidebar-content").addClass("desktop");
    }


});