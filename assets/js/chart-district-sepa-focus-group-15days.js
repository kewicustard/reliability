$(document).ready(function () {
    
    // Define constant
    var yearNoTarget = [2019, 2020, 2021];
    // ./Define constant

    var selectedDistrictValue = $("#selectedDistrict option:selected").val();
    var selectedYear = $("#selectedYear option:selected").text();
    var checkTarget;
    if (yearNoTarget.includes(parseInt(selectedYear))) {
        checkTarget = 0; // hasn't target
    } else {
        checkTarget = 1; // has target
    }
    showGraphAndKpi_all(selectedYear, selectedDistrictValue, checkTarget);
    
    // show head of selectedDistrict and selectedYear
    $("#showButton").on("click", function() {

        $("#main-content").addClass("d-none");
        $(".loader-wraper").removeClass("d-none");        

        selectedDistrict = $("#selectedDistrict option:selected").text();
        selectedDistrictValue = $("#selectedDistrict option:selected").val();
        selectedYear = $("#selectedYear option:selected").text();
        if (yearNoTarget.includes(parseInt(selectedYear))) {
            checkTarget = 0; // hasn't target
        } else {
            checkTarget = 1; // has target
        }
        if ($("#selectedDistrict option:selected").val() === "0") {
            $(".show_header_dashboard").text("ดัชนีฯ สะสมของ "+selectedDistrict + " " + selectedYear);
            $(".show_all_district").removeClass("d-none");
            $(".show_each_district").addClass("d-none");
            $("#saifi_all_table").addClass("d-none");
            $("#saidi_all_table").addClass("d-none");
            showGraphAndKpi_all(selectedYear, selectedDistrictValue, checkTarget);
        } else {
            $(".show_header_dashboard").text("การไฟฟ้านครหลวงเขต " + selectedDistrict + " " + selectedYear);
            $(".show_all_district").addClass("d-none");
            if (checkTarget == 1) { // has target
                $(".show_each_district > div:nth-of-type(1)").addClass("d-md-flex d-lg-flex d-xl-flex flex-xl-column").removeClass("d-none");
                $(".show_each_district > div:nth-of-type(2)").addClass("col-xl-5").removeClass("col-xl-6");
                $(".show_each_district > div:nth-of-type(3)").addClass("col-xl-5").removeClass("col-xl-6");
            } else { // hasn't target
                // console.log($(".show_each_district > div + div").html());
                // console.log($(".show_each_district > div:nth-of-type(3)").html());
                $(".show_each_district > div:nth-of-type(1)").removeClass("d-md-flex d-lg-flex d-xl-flex flex-xl-column").addClass("d-none");
                $(".show_each_district > div:nth-of-type(2)").removeClass("col-xl-5").addClass("col-xl-6");
                $(".show_each_district > div:nth-of-type(3)").removeClass("col-xl-5").addClass("col-xl-6");
            }
            $(".show_each_district").removeClass("d-none");
            showDashboard_each(selectedYear, selectedDistrictValue, checkTarget);
        }
    });
    // /show selectedYear and selectedYear head

    // toggle Table
    $("#toggle_saifi_table").on("click", function(event) {
        event.preventDefault();
        $("#saifi_all_table").toggleClass("d-none");
        if ($(this).text() == "show table") {
            $(this).text("hide table");    
        } else {
            $(this).text("show table");
        }
    });
    $("#toggle_saidi_table").on("click", function(event) {
        event.preventDefault();
        $("#saidi_all_table").toggleClass("d-none");
        if ($(this).text() == "show table") {
            $(this).text("hide table");    
        } else {
            $(this).text("show table");
        }
    });
    // /toggel Table
});

function showGraphAndKpi_all(selectedYear, selectedDistrictValue, checkTarget) {
    
    if (typeof data == 'undefined' || data.data_year != selectedYear) {
        
        $.get("assets/php/all-district-sepa-focus-group-15days.php",
        { 
            selectedYear: selectedYear,
            selectedDistrictValue: selectedDistrictValue,
            checkTarget: checkTarget
        },
        function (res) {// get json data from all-district-sepa-focus-group-15days.php file
            console.log(res);
            window.data = res;
            displayGraphandKpi_all(data);
        });

    } else { // data.data_year == selectedYear
        displayGraphandKpi_all(data);
    }

    function displayGraphandKpi_all(res) {// get json data from all-district-sepa-focus-group-15days.php file
        // console.log(res);
        // var name = [];
        
        var saifi = [], saidi = [], saifi_target = [], saidi_target = [];
        var tabb = [], tabb_code = [], last_month = res.no_month, last_day = res.lasted_day;

        $("h2").text("District SEPA Focus Group Unofficial (" + last_day + "/" + last_month + "/" + selectedYear + ")");
        $("#saifi_all_chart_header").text(last_month + "/" + selectedYear);
        $("#saidi_all_chart_header").text(last_month + "/" + selectedYear);

        updateSelectedDistrict(res.tabb);

        x = 0;
        if (checkTarget == 1) { // has target
            for (var i in res.saifi) {
                tabb_code.push(res.tabb_code[x]);
                tabb.push(res.tabb[i]);
                saifi.push(res.saifi[i][last_month-1]);
                saidi.push(res.saidi[i][last_month-1]);
                saifi_target.push(res.saifi_target[i].saifi_5[last_month-1]);
                saidi_target.push(res.saidi_target[i].saidi_5[last_month-1]);
                x++;
            }
        } else { // hasn't target
            for (var i in res.saifi) {
                tabb_code.push(res.tabb_code[x]);
                tabb.push(res.tabb[i]);
                saifi.push(res.saifi[i][last_month-1]);
                saidi.push(res.saidi[i][last_month-1]);
                x++;
            }
        }

        // console.log(tabb);

        // show chart
        {
                // saifi all chart
            if (typeof(barGraph_saifi_all) !== "undefined") {
                if (checkTarget == 1) {
                    barGraph_saifi_all.data = injectData("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", saifi_target, tabb);
                } else {
                    barGraph_saifi_all.data = injectDataNoTarget("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", tabb);
                }
                barGraph_saifi_all.update();
            } else {
                if (checkTarget == 1) {
                    chartDataTemp = injectData("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", saifi_target, tabb);                    
                } else {
                    chartDataTemp = injectDataNoTarget("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", tabb);
                }
                window.barGraph_saifi_all = new Chart($("#saifi_all"), {
                    type: 'bar',
                    data: chartDataTemp,
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                },
                                ticks: {
                                    min: 0,
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'interruptions / customer'
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        // animation: {
                        //     onComplete: function(animation) {
                        //         $("#saifi_m_image").attr("href", this.toBase64Image());
                        //     }
                        // }
                    }
                });
            }

                // saidi all chart
            if (typeof(barGraph_saidi_all) !== "undefined") {
                if (checkTarget == 1) {
                    barGraph_saidi_all.data = injectData("SAIDI", saidi, "rgba(93, 173, 226, 0.5)", "#3498DB", saidi_target, tabb);
                } else {
                    barGraph_saidi_all.data = injectDataNoTarget("SAIDI", saidi, "rgba(93, 173, 226, 0.5)", "#3498DB", tabb);
                }
                barGraph_saidi_all.update();
            } else {
                if (checkTarget == 1) {
                    chartDataTemp = injectData("SAIDI", saidi, "rgba(93, 173, 226, 0.5)", "#3498DB", saidi_target, tabb);
                } else {
                    chartDataTemp = injectDataNoTarget("SAIDI", saidi, "rgba(93, 173, 226, 0.5)", "#3498DB", tabb);
                }
                window.barGraph_saidi_all = new Chart($("#saidi_all"), {
                    type: 'bar',
                    data: chartDataTemp,
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                },
                                ticks: {
                                    min: 0,
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'minutes / customer'
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                    }
                });
            }

            changeChartjsFontSize(selectedDistrictValue);
        }
        // /show chart

        //show KPI Table
        {
            if (checkTarget == 1) {
                $("#saifi_all_table tbody").html(showKpiTable(tabb_code, tabb, "SAIFI", res.saifi, res.saifi_target, 'saifi_'));
                $("#saidi_all_table tbody").html(showKpiTable(tabb_code, tabb, "SAIDI", res.saidi, res.saidi_target, 'saidi_'));
            } else {
                $("#saifi_all_table tbody").html(showKpiTableNoTarget(tabb_code, tabb, "SAIFI", res.saifi));
                $("#saidi_all_table tbody").html(showKpiTableNoTarget(tabb_code, tabb, "SAIDI", res.saidi));
            }
        }
        // /show KPI Table

        $("#main-content").removeClass("d-none");
        $(".loader-wraper").addClass("d-none");
    }

    function updateSelectedDistrict(tabb) {
        // console.log(tabb);
        var htmlDistrict = '<option value="0" selected>ทุกการไฟฟ้านครหลวงเขต</option>';
        let name_district;
        $.each(tabb, function(index, event_tabb) {
            htmlDistrict += '<option value="'+index+'">';
            // console.log(typeof(index));
            switch (parseInt(index)) {
                case 1:
                    name_district = 'บางกะปิ';
                    break;
                case 2:
                    name_district = 'บางพลี';
                    break;
                case 3:
                    name_district = 'บางใหญ่';
                    break;
                case 4:
                    name_district = 'คลองเตย';
                    break;
                case 5:
                    name_district = 'มีนบุรี';
                    break;
                case 6:
                    name_district = 'นนทบุรี';
                    break;
                case 7:
                    name_district = 'ราษฎร์บูรณะ';
                    break;
                case 8:
                    name_district = 'สามเสน';
                    break;
                case 9:
                    name_district = 'สมุทรปราการ';
                    break;
                case 10:
                    name_district = 'ธนบุรี';
                    break;
                case 11:
                    name_district = 'วัดเลียบ';
                    break;
                case 12:
                    name_district = 'ยานนาวา';
                    break;
                case 13:
                    name_district = 'บางขุนเทียน';
                    break;
                case 14:
                    name_district = 'บางเขน';
                    break;
                case 15:
                    name_district = 'บางบัวทอง';
                    break;
                case 16:
                    name_district = 'ลาดกระบัง';
                    break;
                case 17:
                    name_district = 'นวลจันทร์';
                    break;
                case 18:
                    name_district = 'บางนา';
                    break;
                case 0:
                    name_district = 'ทุกการไฟฟ้านครหลวงเขต';
            }
            htmlDistrict += name_district+' ('+event_tabb+')</option>';
        });
        $("#selectedDistrict").html(htmlDistrict);
    }

    function showKpiTable(tabb_code, tabb, indexType, indices, target, no_target) {
        var table_data;
        // console.log(tabb_code);
        // console.log(tabb);
        // console.log(indexType);
        // console.log(indices);
        // console.log(target);
        // console.log(no_target);
            // table loop
            $.each(tabb, function(index, event_tabb) {
                table_data += '<tr>';
                table_data += '<th>'+event_tabb+'</th>';
                table_data += '<th>KPI5</th>';
                $.each(target[tabb_code[index]][no_target+"5"], function(index2, event_target) {
                    table_data += '<td>'+event_target+'</td>';
                });
                table_data += '</tr><tr>';
                table_data += '<th></th>';
                table_data += '<th>'+indexType+'</th>';
                $.each(indices[tabb_code[index]], function(index2, event_index) {
                    table_data += '<td>'+event_index+'</td>';                
                });
                table_data += '</tr>';
            });

        return table_data;
    }

    function showKpiTableNoTarget(tabb_code, tabb, indexType, indices) {
        var table_data;
            // table loop
            $.each(tabb, function(index, event_tabb) {
                table_data += '<tr>';
                table_data += '<th>'+event_tabb+'</th>';
                table_data += '<th>'+indexType+'</th>';
                $.each(indices[tabb_code[index]], function(index2, event_index) {
                    table_data += '<td>'+event_index+'</td>';                
                });
                table_data += '</tr>';
            });

        return table_data;
    }

    function injectData(indexType, data, colorBar, colorBarHover, target, tabb) {
        var chartdata = {
            labels: tabb,
            datasets: [
                {
                    label: indexType,
                    backgroundColor: colorBar,
                    borderColor: colorBar,
                    hoverBackgroundColor: colorBarHover,
                    hoverBorderColor: colorBarHover,
                    data: data
                },  {
                    label: indexType + ' KPI 5',
                    type: "line",
                    borderColor: "#C70039",
                    data: target,
                    fill: false
                }]
        };

        return chartdata;
    }

    function injectDataNoTarget(indexType, data, colorBar, colorBarHover, tabb) {
        var chartdata = {
            labels: tabb,
            datasets: [
                {
                    label: indexType,
                    backgroundColor: colorBar,
                    borderColor: colorBar,
                    hoverBackgroundColor: colorBarHover,
                    hoverBorderColor: colorBarHover,
                    data: data
                }]
        };

        return chartdata;
    }
}

function showDashboard_each(selectedYear, selectedDistrictValue, checkTarget) {
    // console.log(selectedYear);
    // console.log(data);
    if (data.data_year == selectedYear) {
        showGraphAndKpi_each();
        
    } else {
        $.get("assets/php/all-district-sepa-focus-group-15days.php",
        { 
            selectedYear: selectedYear,
            selectedDistrictValue: selectedDistrictValue,
            checkTarget: checkTarget
        },
        function (res) {
            console.log(res);
            if ($.inArray(selectedDistrictValue, res.tabb_code) < 0) {
                // show modal
                $(".modal-body").text("ฟข. ที่เลือกไม่อยู่ใน Focus Group ของปี "+selectedYear);
                $('#alertDistrict').modal('show');

                $(".show_header_dashboard").text("ดัชนีฯ สะสมของ ทุกการไฟฟ้านครหลวงเขต " + selectedYear);
                $(".show_all_district").removeClass("d-none");
                $(".show_each_district").addClass("d-none");
                $("#saifi_all_table").addClass("d-none");
                $("#saidi_all_table").addClass("d-none");
                showGraphAndKpi_all(selectedYear,"0", checkTarget);
            } else {
                window.data = res;
                showGraphAndKpi_each();
            }
            
        });
    }    
    
    function showGraphAndKpi_each() {
        // var name = [];
        var saifi = [], saidi = [], saifi_month = [], saidi_month = [], saifi_target = [], saidi_target = [];
        var tabb = [], last_month = data.no_month;

        updateSelectedDistrict(data.tabb);

        // console.log(selectedDistrictValue);

        if (checkTarget == 1) {
            for (var i in data.saifi[selectedDistrictValue]) {
                // real indicies
                saifi.push(data.saifi[selectedDistrictValue][i]);
                saidi.push(data.saidi[selectedDistrictValue][i]);
                saifi_month.push(data.saifi_month[selectedDistrictValue][i]);
                saidi_month.push(data.saidi_month[selectedDistrictValue][i]);
            }
            for (var i in data.saifi_target[selectedDistrictValue].saifi_5) {
                saifi_target.push(data.saifi_target[selectedDistrictValue].saifi_5[i]);
                saidi_target.push(data.saidi_target[selectedDistrictValue].saidi_5[i]);
            }
        } else {
            for (var i in data.saifi[selectedDistrictValue]) {
                // real indicies
                saifi.push(data.saifi[selectedDistrictValue][i]);
                saidi.push(data.saidi[selectedDistrictValue][i]);
                saifi_month.push(data.saifi_month[selectedDistrictValue][i]);
                saidi_month.push(data.saidi_month[selectedDistrictValue][i]);
            }
        }
        // console.log(saifi);
        // console.log(saidi);
        // console.log(saifi_target);
        // console.log(saidi_target);

        // show chart
        {
                // saifi chart
            if (typeof(barGraph_saifi) !== "undefined") {
                if (checkTarget == 1) { // has target
                    barGraph_saifi.data = injectData("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saifi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                    saifi_target);
                } else { // hasn't target
                    barGraph_saifi.data = injectDataNoTarget("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saifi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA");
                }
                barGraph_saifi.update();
            } else {
                if (checkTarget == 1) { // has target
                    chartDataTemp = injectData("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saifi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                    saifi_target);
                } else { // hasn't target
                    chartDataTemp = injectDataNoTarget("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saifi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA");
                }
                window.barGraph_saifi = new Chart($("#saifi"), {
                    type: 'bar',
                    data: chartDataTemp,
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                },
                                ticks: {
                                    min: 0,
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'interruptions / customer'
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        animation: {
                            onComplete: function(animation) {
                                $("#saifi_m_image").attr("href", this.toBase64Image());
                            }
                        }
                    }
                });
            }

                // saidi chart
            if (typeof(barGraph_saidi) !== "undefined") {
                if (checkTarget == 1) {
                    barGraph_saidi.data = injectData("SAIDI", saidi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saidi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                    saidi_target);
                } else {
                    barGraph_saidi.data = injectDataNoTarget("SAIDI", saidi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saidi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA");
                }
                barGraph_saidi.update();
            } else {
                if (checkTarget == 1) {
                    chartDataTemp = injectData("SAIDI", saidi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saidi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                    saidi_target);
                } else {
                    chartDataTemp = injectDataNoTarget("SAIDI", saidi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                    saidi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA");
                }
                window.barGraph_saidi = new Chart($("#saidi"), {
                    type: 'bar',
                    data: chartDataTemp,
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false,
                                },
                                ticks: {
                                    min: 0,
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'minutes / customer'
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                    }
                });
            }

            changeChartjsFontSize(selectedDistrictValue);
        }
        // /show chart
        
        // show kpi tile
        if (checkTarget == 1) {
                // saifi
            if (Number(saifi[last_month-1]) <= Number(saifi_target[last_month-1])) {
                $("#saifi_kpi").text("good").removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saifi_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
            } else {
                $("#saifi_kpi").text("bad").removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saifi_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
            }
                // saidi
            if (Number(saidi[last_month-1]) <= Number(saidi_target[last_month-1])) {
                $("#saidi_kpi").text("good").removeClass("text-red-pastel").addClass("text-green-pastel");
                $("#saidi_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
            } else {
                $("#saidi_kpi").text("bad").removeClass("text-green-pastel").addClass("text-red-pastel");
                $("#saidi_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
            }
        }
        // /show kpi tile

        // show kpi table
        if (checkTarget == 1) { // has target
            $("#saifi_table tbody").html(showKpiTable("SAIFI", saifi, saifi_month, saifi_target));
            $("#saidi_table tbody").html(showKpiTable("SAIDI", saidi, saidi_month, saidi_target));
        } else { // hasn't target
            $("#saifi_table tbody").html(showKpiTableNoTarget("SAIFI", saifi, saifi_month));
            $("#saidi_table tbody").html(showKpiTableNoTarget("SAIDI", saidi, saidi_month));
        }
        // /show kpi table

        $("#main-content").removeClass("d-none");
        $(".loader-wraper").addClass("d-none");
    }

    function updateSelectedDistrict(tabb) {
        // console.log(tabb);
        var htmlDistrict = '<option value="0">ทุกการไฟฟ้านครหลวงเขต</option>';
        let name_district;
        $.each(tabb, function(index, event_tabb) {
            htmlDistrict += '<option value="'+index+'"';
            if (index == selectedDistrictValue) {
                htmlDistrict += ' selected>'
            } else {
                htmlDistrict += '>';
            }

            // console.log(typeof(index));
            switch (parseInt(index)) {
                case 1:
                    name_district = 'บางกะปิ';
                    break;
                case 2:
                    name_district = 'บางพลี';
                    break;
                case 3:
                    name_district = 'บางใหญ่';
                    break;
                case 4:
                    name_district = 'คลองเตย';
                    break;
                case 5:
                    name_district = 'มีนบุรี';
                    break;
                case 6:
                    name_district = 'นนทบุรี';
                    break;
                case 7:
                    name_district = 'ราษฎร์บูรณะ';
                    break;
                case 8:
                    name_district = 'สามเสน';
                    break;
                case 9:
                    name_district = 'สมุทรปราการ';
                    break;
                case 10:
                    name_district = 'ธนบุรี';
                    break;
                case 11:
                    name_district = 'วัดเลียบ';
                    break;
                case 12:
                    name_district = 'ยานนาวา';
                    break;
                case 13:
                    name_district = 'บางขุนเทียน';
                    break;
                case 14:
                    name_district = 'บางเขน';
                    break;
                case 15:
                    name_district = 'บางบัวทอง';
                    break;
                case 16:
                    name_district = 'ลาดกระบัง';
                    break;
                case 17:
                    name_district = 'นวลจันทร์';
                    break;
                case 18:
                    name_district = 'บางนา';
                    break;
                case 0:
                    name_district = 'ทุกการไฟฟ้านครหลวงเขต';
            }
            htmlDistrict += name_district+' ('+event_tabb+')</option>';
        });
        $("#selectedDistrict").html(htmlDistrict);
    }

    function showKpiTable(indexType, indices, indices_month, kpi5) {
        var table_data;
            // table loop
            table_data += '<tr>';
            table_data += '<th>KPI5</th>';
            $.each(kpi5, function(index, event_kpi5) {
                table_data += '<td>'+event_kpi5+'</td>';
            });
            table_data += '</tr><tr>';
            table_data += '<th>'+indexType+'</th>';
            $.each(indices, function(index, event_index) {
                table_data += '<td>'+event_index+'</td>';                
            });
            table_data += '</tr><tr>';
            table_data += '<th>'+indexType+'_month</th>';
            $.each(indices_month, function(index, event_index_month) {
                table_data += '<td>'+event_index_month+'</td>';                
            });
            table_data += '</tr>';

        return table_data;
    }

    function showKpiTableNoTarget(indexType, indices, indices_month) {
        var table_data;
            // table loop
            table_data += '<tr>';
            table_data += '<th>'+indexType+'</th>';
            $.each(indices, function(index, event_index) {
                table_data += '<td>'+event_index+'</td>';                
            });
            table_data += '</tr><tr>';
            table_data += '<th>'+indexType+'_month</th>';
            $.each(indices_month, function(index, event_index_month) {
                table_data += '<td>'+event_index_month+'</td>';                
            });
            table_data += '</tr>';

        return table_data;
    }

    function injectData(indexType, data, colorBar, colorBarHover, dataM, colorBarM, colorBarHoverM, target) {
        var chartdata = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: indexType,
                    backgroundColor: colorBar,
                    borderColor: colorBar,
                    hoverBackgroundColor: colorBarHover,
                    hoverBorderColor: colorBarHover,
                    data: data
                },  {
                    label:indexType + ' month',
                    backgroundColor: colorBarM,
                    borderColor: colorBarM,
                    hoverBackgroundColor: colorBarHoverM,
                    hoverBorderColor: colorBarHoverM,
                    data: dataM
                },  {
                    label: indexType + ' KPI 5',
                    type: "line",
                    borderColor: "#C70039",
                    data: target,
                    fill: false
                  }]
        };

        return chartdata;
    }

    function injectDataNoTarget(indexType, data, colorBar, colorBarHover, dataM, colorBarM, colorBarHoverM) {
        var chartdata = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: indexType,
                    backgroundColor: colorBar,
                    borderColor: colorBar,
                    hoverBackgroundColor: colorBarHover,
                    hoverBorderColor: colorBarHover,
                    data: data
                },  {
                    label: indexType + ' month',
                    backgroundColor: colorBarM,
                    borderColor: colorBarM,
                    hoverBackgroundColor: colorBarHoverM,
                    hoverBorderColor: colorBarHoverM,
                    data: dataM
                }]
        };

        return chartdata;
    }
}

$(window).resize(function() {
    changeChartjsFontSize($("#selectedDistrict option:selected").val());
});

function changeChartjsFontSize(selectedDistrictValue) {
    var size;
    if ($(window).width() <= 760) {
        // console.log($(window).width()*1.5/100);
        size = $(window).width()*2/100;
    } else {
        // console.log(($(window).width()-260)*1.5/100);
        size = ($(window).width()-260)*1.5/100;
    }

    if (selectedDistrictValue === '0') {
        Chart.defaults.global.defaultFontSize = size;
    } else {
        Chart.defaults.global.defaultFontSize = size/1.5;
    }
}