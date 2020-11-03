$(document).ready(function () {
    var selectedDistrictValue = $("#selectedDistrict option:selected").val();
    var selectedYear = $("#selectedYear option:selected").text();
    var checkTarget;
    if (selectedYear >= 2019) {
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
        if (selectedYear >= 2019) {
            checkTarget = 0; // hasn't target
        } else {
            checkTarget = 1; // has target
        }
        // console.log(selectedDistrict, selectedDistrictValue, selectedYear, checkTarget);

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

    // console.log(typeof data);
    if (typeof data == 'undefined' || data.data_year != selectedYear) {
        
        $.get("assets/php/all-district-strategy.php",
        { 
            selectedYear: selectedYear,
            selectedDistrictValue: selectedDistrictValue,
            checkTarget: checkTarget
        },
        function (res) {// get json data from mea-strategy.php file
            console.log(res);
            window.data = res;
            displayGraphandKpi_all(data);
        });

    } else { // data.data_year == selectedYear
        displayGraphandKpi_all(data);
    }

    function displayGraphandKpi_all(res) {// get json data from mea-strategy.php file

        var saifi = [], saidi = [], saifi_target = [], saidi_target = [];
        var tabb = [], last_month = res.no_month;
        
        $("#saifi_all_chart_header").text(last_month + "/" + selectedYear);
        $("#saidi_all_chart_header").text(last_month + "/" + selectedYear);
        
        if (checkTarget == 1) { // has target
            for (var i in res.saifi) {
                tabb.push(res.tabb[i-1]);
                saifi.push(res.saifi[i][last_month-1]);
                saidi.push(res.saidi[i][last_month-1]);
                saifi_target.push(res.saifi_target[i].saifi_5[last_month-1]);
                saidi_target.push(res.saidi_target[i].saidi_5[last_month-1]);
            }    
        } else { // hasn't target
            for (var i in res.saifi) {
                tabb.push(res.tabb[i-1]);
                saifi.push(res.saifi[i][last_month-1]);
                saidi.push(res.saidi[i][last_month-1]);
            }
        }
        // console.log(tabb);
        // console.log(saifi);
        // console.log(saidi);
        // console.log(saifi_target);
        // console.log(saidi_target);            

        // show chart
        {
                // saifi all chart
            var chartDataTemp;
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
                                },
                                // ticks: {
                                //     fontSize: 16,
                                // }
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
                    },
                    // plugins: [{
                    //     /* Adjust axis labelling font size according to chart size */
                    //     beforeDraw: function(c) {
                    //         var chartHeight = c.chart.width;
                    //         console.log(chartHeight);
                    //         var size = chartHeight * 1.5 / 100;
                    //         c.scales['x-axis-0'].options.ticks.minor.fontSize = size;
                    //         c.scales['y-axis-0'].options.ticks.minor.fontSize = size;
                    //     }
                    //  }]
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
                $("#saifi_all_table tbody").html(showKpiTable(tabb, "SAIFI", res.saifi, res.saifi_target, 'saifi_'));
                $("#saidi_all_table tbody").html(showKpiTable(tabb, "SAIDI", res.saidi, res.saidi_target, 'saidi_'));
            } else {
                $("#saifi_all_table tbody").html(showKpiTableNoTarget(tabb, "SAIFI", res.saifi));
                $("#saidi_all_table tbody").html(showKpiTableNoTarget(tabb, "SAIDI", res.saidi));
            }            
        }
        // /show KPI Table

        $("#main-content").removeClass("d-none");
        $(".loader-wraper").addClass("d-none");
    }

    function showKpiTable(tabb, indexType, indices, target, no_target) {
        var table_data;
            // table loop
            $.each(tabb, function(index, event_tabb) {
                table_data += '<tr>';
                table_data += '<th>'+event_tabb+'</th>';
                table_data += '<th>KPI5</th>';
                $.each(target[index+1][no_target+"5"], function(index2, event_target) {
                    table_data += '<td>'+event_target+'</td>';
                });
                table_data += '</tr><tr>';
                table_data += '<th></th>';
                table_data += '<th>'+indexType+'</th>';
                $.each(indices[index+1], function(index2, event_index) {
                    table_data += '<td>'+event_index+'</td>';                
                });
                table_data += '</tr>';
            });

        return table_data;
    }

    function showKpiTableNoTarget(tabb, indexType, indices) {
        var table_data;
            // table loop
            $.each(tabb, function(index, event_tabb) {
                table_data += '<tr>';
                table_data += '<th>'+event_tabb+'</th>';
                table_data += '<th>'+indexType+'</th>';
                $.each(indices[index+1], function(index2, event_index) {
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
        // showGraphAndKpi_each(selectedYear, selectedDistrictValue);
        showGraphAndKpi_each();
        
    } else {
        $.get("assets/php/all-district-strategy.php",
        { 
            selectedYear: selectedYear,
            selectedDistrictValue: selectedDistrictValue,
            checkTarget: checkTarget
        },
        function (res) {
            console.log(res);
            window.data = res;
            // showGraphAndKpi_each(selectedYear, selectedDistrictValue);
            showGraphAndKpi_each();
        });
    }    
    
    // function showGraphAndKpi_each(selectedYear, selectedDistrictValue) {
    function showGraphAndKpi_each() {
        // var name = [];
        var saifi = [], saidi = [], saifi_month = [], saidi_month = [], saifi_target = [], saidi_target = [];
        var tabb = [], last_month = data.no_month;

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
            var chartDataTemp;
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
                    label: indexType + ' month',
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