$(document).ready(function () {
    showGraphAndKpi($("#selectedYear option:selected").text());

    // show selectedYear and selectedYear head
    $("#selectedYear").on("change", function() {
        
        $("#main-content").addClass("d-none");
        $(".loader-wraper").removeClass("d-none");
        
        var selectedYear = $("#selectedYear option:selected").text();
        $("#selectedYear_head").text(selectedYear);
        showGraphAndKpi(selectedYear);

        if (parseInt(selectedYear) >= 2019) {
            $(".asia-suvarnabhumi").show();
            $("hr:last").show();    
        } else {
            $(".asia-suvarnabhumi").hide();
            $("hr:last").hide();
        }
    });
    // /show selectedYear and selectedYear head

    // toggle Table
    $("#toggle_saifi_nikom").on("click", function() {
        $("#saifi_nikom").toggleClass("d-none");
        $("#saifi_nikom_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_nikom").on("click", function() {
        $("#saidi_nikom").toggleClass("d-none");
        $("#saidi_nikom_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saifi_H").on("click", function() {
        $("#saifi_H").toggleClass("d-none");
        $("#saifi_H_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_H").on("click", function() {
        $("#saidi_H").toggleClass("d-none");
        $("#saidi_H_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saifi_L").on("click", function() {
        $("#saifi_L").toggleClass("d-none");
        $("#saifi_L_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_L").on("click", function() {
        $("#saidi_L").toggleClass("d-none");
        $("#saidi_L_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saifi_P").on("click", function() {
        $("#saifi_P").toggleClass("d-none");
        $("#saifi_P_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_P").on("click", function() {
        $("#saidi_P").toggleClass("d-none");
        $("#saidi_P_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saifi_U").on("click", function() {
        $("#saifi_U").toggleClass("d-none");
        $("#saifi_U_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_U").on("click", function() {
        $("#saidi_U").toggleClass("d-none");
        $("#saidi_U_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saifi_A").on("click", function() {
        $("#saifi_A").toggleClass("d-none");
        $("#saifi_A_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_A").on("click", function() {
        $("#saidi_A").toggleClass("d-none");
        $("#saidi_A_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });

    // /toggel Table
});

function showGraphAndKpi(selectedYear) {

    $.get("assets/php/mea-industrial.php",
    { selectedYear: selectedYear },
    function (res) // get json data from mea-strategy.php file
    {
        console.log(res);
        // var name = [];
        var saifi, saidi, saifi_month, saidi_month, last_month;
        saifi = res.saifi;
        saidi = res.saidi;
        saifi_month = res.saifi_month;
        saidi_month = res.saidi_month;
        last_month = saifi.H.length;

        var saifi_target_nikom, saidi_target_nikom;
        // target indices;
        saifi_target_nikom = res.saifi_target_nikom;
        saidi_target_nikom = res.saidi_target_nikom;
        
        // real indices
        console.log(saifi);
        console.log(saidi);
        console.log(saifi_month);
        console.log(saidi_month);
        console.log(last_month);
        
        // target indices
        console.log(saifi_target_nikom);
        console.log(saidi_target_nikom);

        // show chart
            // saifi nikom chart
        if (typeof(barGraph_saifi_nikom) !== "undefined") {
            barGraph_saifi_nikom.data = injectData("SAIFI", saifi.nikom, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                saifi_month.nikom, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                saifi_target_nikom),
            barGraph_saifi_nikom.update();
        } else {
            window.barGraph_saifi_nikom = new Chart($("#saifi_nikom"), {
                type: 'bar',
                data: injectData("SAIFI", saifi.nikom, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                    saifi_month.nikom, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                    saifi_target_nikom),
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
                            $("#saifi_nikom_image").attr("href", this.toBase64Image());
                        }
                    }
                }
            });
        }

            // saidi nikom chart
        if (typeof(barGraph_saidi_nikom) !== "undefined") {
            barGraph_saidi_nikom.data = injectData("SAIDI", saidi.nikom, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                saidi_month.nikom, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                saidi_target_nikom),
            barGraph_saidi_nikom.update();
        } else {
            window.barGraph_saidi_nikom = new Chart($("#saidi_nikom"), {
                type: 'bar',
                data: injectData("SAIDI", saidi.nikom, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                    saidi_month.nikom, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                    saidi_target_nikom),
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
            // saifi Bangchan chart
        if (typeof(barGraph_saifi_H) !== "undefined") {
            barGraph_saifi_H.data = injectEachNikomData("SAIFI", saifi.H, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                                saifi_month.H, "rgba(214, 234, 248, 0.5)", "#AED6F1"),
            barGraph_saifi_H.update();
        } else {
            window.barGraph_saifi_H = new Chart($("#saifi_H"), {
                type: 'bar',
                data: injectEachNikomData("SAIFI", saifi.H, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                    saifi_month.H, "rgba(214, 234, 248, 0.5)", "#AED6F1"),
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
                }
            });
        }
            // saidi Bangchan chart
        if (typeof(barGraph_saidi_H) !== "undefined") {
            barGraph_saidi_H.data = injectEachNikomData("SAIDI", saidi.H, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                                saidi_month.H, "rgba(214, 234, 248, 0.5)", "#AED6F1"),
            barGraph_saidi_H.update();
        } else {
            window.barGraph_saidi_H = new Chart($("#saidi_H"), {
                type: 'bar',
                data: injectEachNikomData("SAIDI", saidi.H, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                    saidi_month.H, "rgba(214, 234, 248, 0.5)", "#AED6F1"),
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
            // saifi Lat Krabang chart
        if (typeof(barGraph_saifi_L) !== "undefined") {
            barGraph_saifi_L.data = injectEachNikomData("SAIFI", saifi.L, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                                saifi_month.L, "rgba(212, 239, 223, 0.5)", "#A9DFBF"),
            barGraph_saifi_L.update();
        } else {
            window.barGraph_saifi_L = new Chart($("#saifi_L"), {
                type: 'bar',
                data: injectEachNikomData("SAIFI", saifi.L, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                    saifi_month.L, "rgba(212, 239, 223, 0.5)", "#A9DFBF"),
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
                }
            });
        }
            // saidi Lat Krabang chart
        if (typeof(barGraph_saidi_L) !== "undefined") {
            barGraph_saidi_L.data = injectEachNikomData("SAIDI", saidi.L, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                                saidi_month.L, "rgba(212, 239, 223, 0.5)", "#A9DFBF"),
            barGraph_saidi_L.update();
        } else {
            window.barGraph_saidi_L = new Chart($("#saidi_L"), {
                type: 'bar',
                data: injectEachNikomData("SAIDI", saidi.L, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                    saidi_month.L, "rgba(212, 239, 223, 0.5)", "#A9DFBF"),
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
            // saifi Bangplee chart
        if (typeof(barGraph_saifi_P) !== "undefined") {
            barGraph_saifi_P.data = injectEachNikomData("SAIFI", saifi.P, "rgba(241, 196, 15, 0.5)", "#D4AC0D", 
                                                saifi_month.P, "rgba(249, 231, 159, 0.5)", "#F4D03F"),
            barGraph_saifi_P.update();
        } else {
            window.barGraph_saifi_P = new Chart($("#saifi_P"), {
                type: 'bar',
                data: injectEachNikomData("SAIFI", saifi.P, "rgba(241, 196, 15, 0.5)", "#D4AC0D", 
                                    saifi_month.P, "rgba(249, 231, 159, 0.5)", "#F4D03F"),
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
                }
            });
        }
            // saidi Bangplee chart
        if (typeof(barGraph_saidi_P) !== "undefined") {
            barGraph_saidi_P.data = injectEachNikomData("SAIDI", saidi_P, "rgba(241, 196, 15, 0.5)", "#D4AC0D", 
                                                saidi_month.P, "rgba(249, 231, 159, 0.5)", "#F4D03F"),
            barGraph_saidi_P.update();
        } else {
            window.barGraph_saidi_P = new Chart($("#saidi_P"), {
                type: 'bar',
                data: injectEachNikomData("SAIDI", saidi.P, "rgba(241, 196, 15, 0.5)", "#D4AC0D", 
                                    saidi_month.P, "rgba(249, 231, 159, 0.5)", "#F4D03F"),
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
            // saifi Bangpoo chart
        if (typeof(barGraph_saifi_U) !== "undefined") {
            barGraph_saifi_U.data = injectEachNikomData("SAIFI", saifi.U, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                                saifi_month.U, "rgba(255, 205, 164, 0.5)", "#FFB170"),
            barGraph_saifi_U.update();
        } else {
            window.barGraph_saifi_U = new Chart($("#saifi_U"), {
                type: 'bar',
                data: injectEachNikomData("SAIFI", saifi.U, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                    saifi_month.U, "rgba(255, 205, 164, 0.5)", "#FFB170"),
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
                }
            });
        }
            // saidi Bangpoo chart
        if (typeof(barGraph_saidi_U) !== "undefined") {
            barGraph_saidi_U.data = injectEachNikomData("SAIDI", saidi_U, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                                saidi_month.U, "rgba(255, 205, 164, 0.5)", "#FFB170"),
            barGraph_saidi_U.update();
        } else {
            window.barGraph_saidi_U = new Chart($("#saidi_U"), {
                type: 'bar',
                data: injectEachNikomData("SAIDI", saidi.U, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                    saidi_month.U, "rgba(255, 205, 164, 0.5)", "#FFB170"),
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
        
        if (parseInt(selectedYear) >= 2019) {
                // saifi Asia Suvarnabhumi chart
            if (typeof(barGraph_saifi_A) !== "undefined") {
                barGraph_saifi_A.data = injectEachNikomData("SAIFI", saifi.A, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                                    saifi_month.A, "rgba(255, 205, 164, 0.5)", "#FFB170"),
                barGraph_saifi_A.update();
            } else {
                window.barGraph_saifi_A = new Chart($("#saifi_A"), {
                    type: 'bar',
                    data: injectEachNikomData("SAIFI", saifi.A, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                        saifi_month.A, "rgba(255, 205, 164, 0.5)", "#FFB170"),
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
                    }
                });
            }
                // saidi Asia Suvarnabhumi chart
            if (typeof(barGraph_saidi_A) !== "undefined") {
                barGraph_saidi_A.data = injectEachNikomData("SAIDI", saidi.A, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                                    saidi_month.A, "rgba(255, 205, 164, 0.5)", "#FFB170"),
                barGraph_saidi_A.update();
            } else {
                window.barGraph_saidi_A = new Chart($("#saidi_A"), {
                    type: 'bar',
                    data: injectEachNikomData("SAIDI", saidi.A, "rgba(225, 116, 0, 0.5)", "#D96200", 
                                        saidi_month.A, "rgba(255, 205, 164, 0.5)", "#FFB170"),
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
        }
        // /show chart

        //show Table
        $("#saifi_nikom_table tbody").html(showTable("nikom", "SAIFI", saifi.nikom, saifi_target_nikom));
        $("#saidi_nikom_table tbody").html(showTable("nikom", "SAIDI", saidi.nikom, saidi_target_nikom));
        $("#saifi_H_table tbody").html(showTable("H", "SAIFI", saifi.H));
        $("#saidi_H_table tbody").html(showTable("H", "SAIDI", saidi.H));
        $("#saifi_L_table tbody").html(showTable("L", "SAIFI", saifi.L));
        $("#saidi_L_table tbody").html(showTable("L", "SAIDI", saidi.L));
        $("#saifi_P_table tbody").html(showTable("P", "SAIFI", saifi.P));
        $("#saidi_P_table tbody").html(showTable("P", "SAIDI", saidi.P));
        $("#saifi_U_table tbody").html(showTable("U", "SAIFI", saifi.U));
        $("#saidi_U_table tbody").html(showTable("U", "SAIDI", saidi.U));
        $("#saifi_A_table tbody").html(showTable("A", "SAIFI", saifi.A));
        $("#saidi_A_table tbody").html(showTable("A", "SAIDI", saidi.A));
        // /show Table

        $("#main-content").removeClass("d-none");
        $(".loader-wraper").addClass("d-none");
    });

    function showTable(system, indexType, indices, target) {
        var table_data;
        if (system != "nikom") {
            // KPI loop
            table_data += '<tr>';
                table_data += '<th>'+indexType+'</th>';
                $.each(indices, function(index, event) {
                    table_data += '<td>'+event+'</td>';
                });
            table_data += '</tr>';
        } else {
            var kpi_loop = [target, indices];
            // KPI loop
            $.each(kpi_loop, function(index, event) {
                table_data += '<tr>';
                    if (index < 1) {
                        table_data += '<th>Service Level</th>';
                    } else if (index == 1) {
                        table_data += '<th>'+indexType+'</th>';
                    }
                    $.each(event, function(index2, event2) {
                        table_data += '<td>'+event2+'</td>';
                    });
                table_data += '</tr>';
            });
        }

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
                    label: indexType + " month",
                    backgroundColor: colorBarM,
                    borderColor: colorBarM,
                    hoverBackgroundColor: colorBarHoverM,
                    hoverBorderColor: colorBarHoverM,
                    data: dataM
                },  {
                    label: indexType + " Service Level",
                    type: "line",
                    borderColor: "#C70039",
                    data: target,
                    fill: false
                  }]
        };

        return chartdata;
    }

    function injectEachNikomData(indexType, data, colorBar, colorBarHover, dataM, colorBarM, colorBarHoverM) {
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
                    label: indexType + " month",
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