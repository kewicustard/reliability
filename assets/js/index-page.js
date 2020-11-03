jQuery(document).ready(function() {

    "use strict";    

    // var x = document.getElementsByTagName("h3");
    // console.log(x);
    // console.log(x[0].dataset.year);
    // console.log($("h3")[0].dataset.year);

    var this_year = $("h1")[0].dataset.year;
    var previous_year = this_year - 1;
    var strategy_target_check = $("h3")[0].dataset.strategy_target;

    console.log(this_year, strategy_target_check);

    $.get("assets/php/index-page.php",
        { year: this_year, strategy_target: strategy_target_check },
        function(res) {
            console.log(res);

            // update title
            $("h1").append(" <small> (accumulated to " + no_monthToText_month(res.no_month) + " " + $("h1")[0].dataset.year + ")</small>");

            // show kpi tile
            if(strategy_target_check == 'yes') {
                if (res.saifi_kpi < 5) {
                    $("#saifi_kpi").text("KPI " + res.saifi_kpi).removeClass("text-green-pastel").addClass("text-red-pastel");
                    $("#saifi_kpi_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
                } else {
                    $("#saifi_kpi").text("KPI " + res.saifi_kpi).removeClass("text-red-pastel").addClass("text-green-pastel");
                    $("#saifi_kpi_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
                }

                if (res.saidi_kpi < 5) {
                    $("#saidi_kpi").text("KPI " + res.saidi_kpi).removeClass("text-green-pastel").addClass("text-red-pastel");
                    $("#saidi_kpi_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
                } else {
                    $("#saidi_kpi").text("KPI " + res.saidi_kpi).removeClass("text-red-pastel").addClass("text-green-pastel");
                    $("#saidi_kpi_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
                }
            } else { //strategy_target_check == 'no'
                if (res.saifi_kpi == '1') {
                    $("#saifi_kpi").text("worse than " + previous_year).removeClass("text-green-pastel").addClass("text-red-pastel");
                    $("#saifi_kpi_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
                } else { //res.saifi_kpi == '5'
                    $("#saifi_kpi").text("better than " + previous_year).removeClass("text-red-pastel").addClass("text-green-pastel");
                    $("#saifi_kpi_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
                }

                if (res.saidi_kpi == '1') {
                    $("#saidi_kpi").text("worse than " + previous_year).removeClass("text-green-pastel").addClass("text-red-pastel");
                    $("#saidi_kpi_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
                } else { //res.saidi_kpi == '5'
                    $("#saidi_kpi").text("better than " + previous_year).removeClass("text-red-pastel").addClass("text-green-pastel");
                    $("#saidi_kpi_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
                }                
            }

            if (res.saifi_kpi_sepa < 5) {
                $("#saifi_kpi_sepa").text("KPI " + res.saifi_kpi_sepa).removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saifi_kpi_sepa_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
            } else {
                $("#saifi_kpi_sepa").text("KPI " + res.saifi_kpi_sepa).removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saifi_kpi_sepa_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
            }

            if (res.saidi_kpi_sepa < 5) {
                $("#saidi_kpi_sepa").text("KPI " + res.saidi_kpi_sepa).removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saidi_kpi_sepa_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
            } else {
                $("#saidi_kpi_sepa").text("KPI " + res.saidi_kpi_sepa).removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saidi_kpi_sepa_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
            }

            if (res.saifi_kpi_focus < 5) {
                $("#saifi_kpi_focus").text("KPI " + res.saifi_kpi_focus).removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saifi_kpi_focus_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
            } else {
                $("#saifi_kpi_focus").text("KPI " + res.saifi_kpi_focus).removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saifi_kpi_focus_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
            }

            if (res.saidi_kpi_focus < 5) {
                $("#saidi_kpi_focus").text("KPI " + res.saidi_kpi_focus).removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saidi_kpi_focus_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
            } else {
                $("#saidi_kpi_focus").text("KPI " + res.saidi_kpi_focus).removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saidi_kpi_focus_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
            }

            if (res.saifi_kpi_nikom == "Bad") {
                $("#saifi_kpi_nikom").text(res.saifi_kpi_nikom).removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saifi_kpi_nikom_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
            } else {
                $("#saifi_kpi_nikom").text(res.saifi_kpi_nikom).removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saifi_kpi_nikom_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
            }

            if (res.saidi_kpi_nikom == "Bad") {
                $("#saidi_kpi_nikom").text(res.saidi_kpi_nikom).removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saidi_kpi_nikom_logo").removeClass("fa-smile-beam bg-green-pastel").addClass("fa-surprise bg-red-pastel");
            } else {
                $("#saidi_kpi_nikom").text(res.saidi_kpi_nikom).removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saidi_kpi_nikom_logo").removeClass("fa-surprise bg-red-pastel").addClass("fa-smile-beam bg-green-pastel");
            }
            // /show kpi tile
        
            $("#main-content").removeClass("d-none");
            $(".loader-wraper").addClass("d-none");

        }
    );

    function no_monthToText_month(no_month) {
        var text_month;
        switch(no_month) {
            case "1":
                text_month = "January";
                break;
            case "2":
                text_month = "February";
                break;
            case "3":
                text_month = "March";
                break;
            case "4":
                text_month = "April";
                break;
            case "5":
                text_month = "May";
                break;
            case "6":
                text_month = "June";
                break;
            case "7":
                text_month = "July";
                break;
            case "8":
                text_month = "August";
                break;
            case "9":
                text_month = "September";
                break;
            case "10":
                text_month = "October";
                break;
            case "11":
                text_month = "November";
                break;
            case "12":
                text_month = "December";
                break;
        }

        return text_month;
    }
    
});