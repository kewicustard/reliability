$(document).ready(function () {
    showGraphAndKpi($("#selectedYear option:selected").text());

    // show selectedYear and selectedYear head
    $("#selectedYear").on("change", function() {
        
        $("#main-content").addClass("d-none");
        $(".loader-wraper").removeClass("d-none");
        
        var selectedYear = $("#selectedYear option:selected").text();
        $("#selectedYear_head").text(selectedYear);
        showGraphAndKpi(selectedYear);
    });
    // /show selectedYear and selectedYear head

    // toggle Table
    $("#toggle_saifi_m").on("click", function() {
        $("#saifi_m").toggleClass("d-none");
        $("#saifi_m_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_m").on("click", function() {
        $("#saidi_m").toggleClass("d-none");
        $("#saidi_m_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saifi_ls").on("click", function() {
        $("#saifi_ls").toggleClass("d-none");
        $("#saifi_ls_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_ls").on("click", function() {
        $("#saidi_ls").toggleClass("d-none");
        $("#saidi_ls_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saifi_f").on("click", function() {
        $("#saifi_f").toggleClass("d-none");
        $("#saifi_f_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });
    $("#toggle_saidi_f").on("click", function() {
        $("#saidi_f").toggleClass("d-none");
        $("#saidi_f_table").toggleClass("d-none");
        $(this).toggleClass("fa-table").toggleClass("fa-chart-bar");
    });

    // /toggel Table
});

function showGraphAndKpi(selectedYear) {

    $.get("assets/php/mea-sepa-focus-group.php",
    { selectedYear: selectedYear },
    function (res) // get json data from mea-strategy.php file
    {
        console.log(res);
        // var name = [];
        var saifi = [], saidi = [], saifi_ls = [], saidi_ls = [];
        var saifi_f = [], saidi_f = [];
        var saifi_month = [], saidi_month = [], saifi_ls_month = [], saidi_ls_month = [];
        var saifi_f_month = [], saidi_f_month = [];
        var saifi_kpi = [], saidi_kpi = [], saifi_ls_kpi = [], saidi_ls_kpi = [];
        var saifi_f_kpi = [], saidi_f_kpi = [];
        var last_month;

        for (var i in res.saifi) {
            // console.log(i);
            // real indicies
            saifi.push(res.saifi[i]);
            saidi.push(res.saidi[i]);
            saifi_month.push(res.saifi_month[i]);
            saidi_month.push(res.saidi_month[i]);
            saifi_kpi.push(res.saifi_kpi[i]);
            saidi_kpi.push(res.saidi_kpi[i]);
            saifi_ls.push(res.saifi_ls[i]);
            saidi_ls.push(res.saidi_ls[i]);
            saifi_ls_month.push(res.saifi_ls_month[i]);
            saidi_ls_month.push(res.saidi_ls_month[i]);
            saifi_ls_kpi.push(res.saifi_ls_kpi[i]);
            saidi_ls_kpi.push(res.saidi_ls_kpi[i]);
            saifi_f.push(res.saifi_f[i]);
            saidi_f.push(res.saidi_f[i]);
            saifi_f_month.push(res.saifi_f_month[i]);
            saidi_f_month.push(res.saidi_f_month[i]);
            saifi_f_kpi.push(res.saifi_f_kpi[i]);
            saidi_f_kpi.push(res.saidi_f_kpi[i]);
            last_month = i;
        }

        var saifi_1 = [], saidi_1 = [], saifi_ls1 = [], saidi_ls1 = [], saifi_f1 = [], saidi_f1 = [];
        var saifi_2 = [], saidi_2 = [], saifi_ls2 = [], saidi_ls2 = [], saifi_f2 = [], saidi_f2 = [];
        var saifi_3 = [], saidi_3 = [], saifi_ls3 = [], saidi_ls3 = [], saifi_f3 = [], saidi_f3 = [];
        var saifi_4 = [], saidi_4 = [], saifi_ls4 = [], saidi_ls4 = [], saifi_f4 = [], saidi_f4 = [];
        var saifi_5 = [], saidi_5 = [], saifi_ls5 = [], saidi_ls5 = [], saifi_f5 = [], saidi_f5 = [];

        for (var i in res.saifi_target.m1) {
            // target indices;
            saifi_1.push(res.saifi_target.m1[i]);
            saifi_2.push(res.saifi_target.m2[i]);
            saifi_3.push(res.saifi_target.m3[i]);
            saifi_4.push(res.saifi_target.m4[i]);
            saifi_5.push(res.saifi_target.m5[i]);
            saidi_1.push(res.saidi_target.m1[i]);
            saidi_2.push(res.saidi_target.m2[i]);
            saidi_3.push(res.saidi_target.m3[i]);
            saidi_4.push(res.saidi_target.m4[i]);
            saidi_5.push(res.saidi_target.m5[i]);
            saifi_ls1.push(res.saifi_target.ls1[i]);
            saifi_ls2.push(res.saifi_target.ls2[i]);
            saifi_ls3.push(res.saifi_target.ls3[i]);
            saifi_ls4.push(res.saifi_target.ls4[i]);
            saifi_ls5.push(res.saifi_target.ls5[i]);
            saidi_ls1.push(res.saidi_target.ls1[i]);
            saidi_ls2.push(res.saidi_target.ls2[i]);
            saidi_ls3.push(res.saidi_target.ls3[i]);
            saidi_ls4.push(res.saidi_target.ls4[i]);
            saidi_ls5.push(res.saidi_target.ls5[i]);
            saifi_f1.push(res.saifi_target.f1[i]);
            saifi_f2.push(res.saifi_target.f2[i]);
            saifi_f3.push(res.saifi_target.f3[i]);
            saifi_f4.push(res.saifi_target.f4[i]);
            saifi_f5.push(res.saifi_target.f5[i]);
            saidi_f1.push(res.saidi_target.f1[i]);
            saidi_f2.push(res.saidi_target.f2[i]);
            saidi_f3.push(res.saidi_target.f3[i]);
            saidi_f4.push(res.saidi_target.f4[i]);
            saidi_f5.push(res.saidi_target.f5[i]);
        }
        
        // real indices
        console.log(saifi);
        console.log(saidi);
        console.log(saifi_ls);
        console.log(saidi_ls);
        console.log(saifi_f);
        console.log(saidi_f);
        
        // target indices
        console.log(saifi_5);
        console.log(saidi_5);

        // show chart
            // saifi mea chart
        if (typeof(barGraph_saifi_m) !== "undefined") {
            barGraph_saifi_m.data = injectData("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                saifi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                saifi_5),
            barGraph_saifi_m.update();
        } else {
            window.barGraph_saifi_m = new Chart($("#saifi_m"), {
                type: 'bar',
                data: injectData("SAIFI", saifi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                    saifi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                    saifi_5),
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

            // saidi mea chart
        if (typeof(barGraph_saidi_m) !== "undefined") {
            barGraph_saidi_m.data = injectData("SAIDI", saidi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                                saidi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                                saidi_5),
            barGraph_saidi_m.update();
        } else {
            window.barGraph_saidi_m = new Chart($("#saidi_m"), {
                type: 'bar',
                data: injectData("SAIDI", saidi, "rgba(205, 97, 85, 0.5)", "#C0392B", 
                                    saidi_month, "rgba(242, 215, 213, 0.5)", "#E6B0AA", 
                                    saidi_5),
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
            // saifi ls chart
        if (typeof(barGraph_saifi_ls) !== "undefined") {
            barGraph_saifi_ls.data = injectData("SAIFI", saifi_ls, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                                saifi_ls_month, "rgba(214, 234, 248, 0.5)", "#AED6F1", 
                                                saifi_ls5),
            barGraph_saifi_ls.update();
        } else {
            window.barGraph_saifi_ls = new Chart($("#saifi_ls"), {
                type: 'bar',
                data: injectData("SAIFI", saifi_ls, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                    saifi_ls_month, "rgba(214, 234, 248, 0.5)", "#AED6F1", 
                                    saifi_ls5),
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
            // saidi ls chart
        if (typeof(barGraph_saidi_ls) !== "undefined") {
            barGraph_saidi_ls.data = injectData("SAIDI", saidi_ls, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                                saidi_ls_month, "rgba(214, 234, 248, 0.5)", "#AED6F1", 
                                                saidi_ls5),
            barGraph_saidi_ls.update();
        } else {
            window.barGraph_saidi_ls = new Chart($("#saidi_ls"), {
                type: 'bar',
                data: injectData("SAIDI", saidi_ls, "rgba(93, 173, 226, 0.5)", "#3498DB", 
                                    saidi_ls_month, "rgba(214, 234, 248, 0.5)", "#AED6F1", 
                                    saidi_ls5),
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
            // saifi f chart
        if (typeof(barGraph_saifi_f) !== "undefined") {
            barGraph_saifi_f.data = injectData("SAIFI", saifi_f, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                                saifi_f_month, "rgba(212, 239, 223, 0.5)", "#A9DFBF", 
                                                saifi_f5),
            barGraph_saifi_f.update();
        } else {
            window.barGraph_saifi_f = new Chart($("#saifi_f"), {
                type: 'bar',
                data: injectData("SAIFI", saifi_f, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                    saifi_f_month, "rgba(212, 239, 223, 0.5)", "#A9DFBF", 
                                    saifi_f5),
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
            // saidi f chart
        if (typeof(barGraph_saidi_f) !== "undefined") {
            barGraph_saidi_f.data = injectData("SAIDI", saidi_f, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                                saidi_f_month, "rgba(212, 239, 223, 0.5)", "#A9DFBF", 
                                                saidi_f5),
            barGraph_saidi_f.update();
        } else {
            window.barGraph_saidi_f = new Chart($("#saidi_f"), {
                type: 'bar',
                data: injectData("SAIDI", saidi_f, "rgba(82, 190, 128, 0.5)", "#27AE60", 
                                    saidi_f_month, "rgba(212, 239, 223, 0.5)", "#A9DFBF", 
                                    saidi_f5),
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
        // /show chart

        // show kpi tile
        $("#saifi_m_kpi").text(saifi_kpi[last_month]);
        $("#saidi_m_kpi").text(saidi_kpi[last_month]);
        $("#saifi_ls_kpi").text(saifi_ls_kpi[last_month]);
        $("#saidi_ls_kpi").text(saidi_ls_kpi[last_month]);
        $("#saifi_f_kpi").text(saifi_f_kpi[last_month]);
        $("#saidi_f_kpi").text(saidi_f_kpi[last_month]);

        if (saifi_kpi[last_month] < 5) {
            $("#saifi_m_kpi").removeClass("text-green-pastel").addClass("text-red-pastel");
            $("#saifi_m_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
        } else {
            $("#saifi_m_kpi").removeClass("text-red-pastel").addClass("text-green-pastel");
            $("#saifi_m_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
        }
        if (saidi_kpi[last_month] < 5) {
            $("#saidi_m_kpi").removeClass("text-green-pastel").addClass("text-red-pastel");
            $("#saidi_m_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
        } else {
            $("#saidi_m_kpi").removeClass("text-red-pastel").addClass("text-green-pastel");
            $("#saidi_m_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
        }
        if (saifi_ls_kpi[last_month] < 5) {
            $("#saifi_ls_kpi").removeClass("text-green-pastel").addClass("text-red-pastel");
            $("#saifi_ls_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
        } else {
            $("#saifi_ls_kpi").removeClass("text-red-pastel").addClass("text-green-pastel");
            $("#saifi_ls_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
        }
        if (saidi_ls_kpi[last_month] < 5) {
            $("#saidi_ls_kpi").removeClass("text-green-pastel").addClass("text-red-pastel");
            $("#saidi_ls_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
        } else {
            $("#saidi_ls_kpi").removeClass("text-red-pastel").addClass("text-green-pastel");
            $("#saidi_ls_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
        }
        if (saifi_f_kpi[last_month] < 5) {
            $("#saifi_f_kpi").removeClass("text-green-pastel").addClass("text-red-pastel");
            $("#saifi_f_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
        } else {
            $("#saifi_f_kpi").removeClass("text-red-pastel").addClass("text-green-pastel");
            $("#saifi_f_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
        }
        if (saidi_f_kpi[last_month] < 5) {
            $("#saidi_f_kpi").removeClass("text-green-pastel").addClass("text-red-pastel");
            $("#saidi_f_kpi_logo").removeClass("fa-check-circle text-green-pastel").addClass("fa-times-circle text-red-pastel");
        } else {
            $("#saidi_f_kpi").removeClass("text-red-pastel").addClass("text-green-pastel");
            $("#saidi_f_kpi_logo").removeClass("fa-times-circle text-red-pastel").addClass("fa-check-circle text-green-pastel");
        }
        // /show kpi tile

        //show KPI Table
        $("#saifi_m_table tbody").html(showKpiTable("m", "SAIFI", saifi, saifi_kpi, saifi_1, saifi_2, saifi_3, saifi_4, saifi_5));
        $("#saidi_m_table tbody").html(showKpiTable("m", "SAIDI", saidi, saidi_kpi, saidi_1, saidi_2, saidi_3, saidi_4, saidi_5));
        $("#saifi_ls_table tbody").html(showKpiTable("ls", "SAIFI", saifi_ls, saifi_ls_kpi, saifi_ls1, saifi_ls2, saifi_ls3, saifi_ls4, saifi_ls5));
        $("#saidi_ls_table tbody").html(showKpiTable("ls", "SAIDI", saidi_ls, saidi_ls_kpi, saidi_ls1, saidi_ls2, saidi_ls3, saidi_ls4, saidi_ls5));
        $("#saifi_f_table tbody").html(showKpiTable("f", "SAIFI", saifi_f, saifi_f_kpi, saifi_f1, saifi_f2, saifi_f3, saifi_f4, saifi_f5));
        $("#saidi_f_table tbody").html(showKpiTable("f", "SAIDI", saidi_f, saidi_f_kpi, saidi_f1, saidi_f2, saidi_f3, saidi_f4, saidi_f5));
        // /show KPI Table

        $("#main-content").removeClass("d-none");
        $(".loader-wraper").addClass("d-none");
    });

    function showKpiTable(system, indexType, indices, kpi, kpi1, kpi2, kpi3, kpi4, kpi5) {
        var table_data;
        var kpi_loop = [kpi1, kpi2, kpi3, kpi4, kpi5, indices, kpi];
        // KPI loop
        $.each(kpi_loop, function(index, event) {
            table_data += '<tr>';
            if (index < 5) {
                table_data += '<th>KPI'+(index+1)+'</th>';
            } else if (index == 5) {
                table_data += '<th>'+indexType+'</th>';
            } else {
                table_data += '<th>KPI</th>';
            }
                $.each(event, function(index2, event2) {
                    table_data += '<td>'+event2+'</td>';
                });
                table_data += '</tr>';
        });

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
}