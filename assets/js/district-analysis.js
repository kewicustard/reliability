jQuery(document).ready(function() {
    
    // Datatable
    var allCustNum, allCustMin;

    function createTable() {
        window.table = $('#outageEventTable').DataTable({
            // ajax: 'https://api.myjson.com/bins/1us28',
            // responsive: true,
            scrollX: true,
            scrollCollapse: true,
            dom: "<'row'<'col-md-6'B><'col-md-6'f>>"+
                    "<'row'<'col-md-12'rt>>"+
                    "<'row'<'col-md-6'i><'col-md-6 d-flex justify-content-center justify-content-md-end'p>>",
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength',
                {
                    text: 'Select all',
                    action: function () {
                        table.rows().select();
                    }
                },
                {
                    text: 'Select none',
                    action: function () {
                        table.rows().deselect();
                    }
                }
            ],
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            } ],
            select: {
                style:    'multi',
                // selector: 'td:first-child'
            },
            order: [[ 1, 'desc' ]]               
        });

        // table.on( 'responsive-resize', function ( e, datatable, columns ) {
        //     table
        //         .columns.adjust().draw()
        //         .responsive.recalc();
        // });

        allCustNum = table
                        .column(14)
                        .data()
                        .reduce( function (a, b) {
                            return Number(a) + Number(b);
                        });
        allCustMin = table
                        .column(15)
                        .data()
                        .reduce( function (a, b) {
                            return Number(a) + Number(b);
                        });
        console.log(allCustNum);
        console.log(allCustMin);
    }

    $("#calculates").on("click", function(){
        // var rowData = table.rows( indexes ).data().toArray();
        var selectedRows = table.rows( { selected: true } ).data().toArray();
        // console.log(count);
        let sumCustNum = 0, sumCustMin = 0;
        selectedRows.forEach(element => {
            sumCustNum += parseFloat(element[14]);
            sumCustMin += parseFloat(element[15]);
        });
        console.log(sumCustNum);
        console.log(sumCustMin);
        console.log(allCustNum-sumCustNum);
        console.log(allCustMin-sumCustMin);
    });

    // Datatable

    // action when submitted selectedYear and selectedDistrict
    $("#districtAnalysis").on("submit", function(event) {
        event.preventDefault();

        // $("#outageLineTable").DataTable().destroy(); //this code does not work
        if (typeof(table) !== "undefined") {
            table.destroy();            
        }
        // $("#outageLineTable").hide();
        // $(".progressAndResponse").html("");
        // $(".progressAndResponse").addClass("loader12").show();
        // console.log($("#districtAnalysis").serialize());
        $.get("assets/php/district-analysis.php",
            $("#districtAnalysis").serialize(),
            function(res){
                // console.log(res);
                // console.log($("#searchForm").serialize());
                if (res.length === 0) {
                    var no_res = '<blockquote class="blockquote text-center"><p class="mb-0">ไม่มีสถิติไฟฟ้าดับ หรือ ใส่ชื่อสายส่งไม่ถูกต้อง</p></blockquote>';
                    $(".progressAndResponse").removeClass("loader12");
                    $(".progressAndResponse").html(no_res);
                } else {
                    var table_data;
                    $.each(res, function(index, event) {
                        // console.log(event);
                        table_data += '<tr>'+
                                            '<td></td>'+
                                            '<td>'+event.date+'</td>'+
                                            '<td>'+event.new_month+'</td>'+
                                            '<td>'+event.feeder+'</td>'+
                                            '<td>'+event.time_from+'</td>'+
                                            '<td>'+event.time_to+'</td>'+
                                            '<td>'+event.timeocb+'</td>'+
                                            '<td>'+event.time_eq+'</td>'+
                                            '<td>'+event.to1+'</td>'+
                                            '<td>'+event.to2+'</td>'+
                                            '<td>'+event.to3+'</td>'+
                                            '<td>'+event.to4+'</td>'+
                                            '<td>'+event.outgdist+'</td>'+
                                            '<td>'+event.custdist+'</td>'+
                                            '<td>'+event.cust_num+'</td>'+
                                            '<td>'+event.cust_min+'</td>'+
                                            '<td>'+event.t_main+'</td>'+
                                            '<td>'+event.t_cause+'</td>'+
                                        '</tr>';
                    });
                    $("#outageEventTable tbody").html(table_data);
                    
                    // var dateFrom = $("[name='dateFrom']").val();
                    // var dateTo = $("[name='dateTo']").val();
                    // var lineName = $("#inputLineName").val().toUpperCase();
                    // var caption = 'สถิติสายส่ง ' + lineName + ' ไฟฟ้าดับ วันที่ ' + dateFrom + ' ถึง วันที่ ' + dateTo;
                    // $("caption").addClass("h5 text-center").css("caption-side","top").text(caption);                    
                    createTable();
                    // $(".progressAndResponse").removeClass("loader12");
                    // $(".progressAndResponse").hide();
                    // $("#outageLineTable").show();
                }
            }
        );
    });
    // /action when submitted selectedYear and selectedDistrict
});