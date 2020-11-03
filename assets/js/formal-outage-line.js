//datepicker
jQuery(document).ready(function(){

    // date range
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var ealierMonth = new Date(nowTemp.getFullYear(), nowTemp.getMonth()-1, 1, 0, 0, 0, 0);
    
    var endDate = $('.dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() < startDate.date.valueOf()) {
            startDate.setValue(ev.date);
        }
        endDate.hide();
    }).data('datepicker');

    endDate.setValue(now);

    var startDate = $('.dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() > endDate.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        startDate.hide();
    }).data('datepicker');
    startDate.setValue(ealierMonth);
    
    $('.dpd2').on('change', function() {
        if (startDate.date.valueOf() > endDate.date.valueOf()) {
            startDate.setValue(endDate.date);
        }
    });
    $('.dpd1').on('change', function() {
        if (startDate.date.valueOf() > endDate.date.valueOf()) {
            endDate.setValue(startDate.date);
        }
    });
    // /date range

    // remark last database date
    var parts = [];
    $.get("assets/php/formal-outage-line-first.php",
        function(res) {
            parts = res[0].event_date.split('-'); // array parts = [ัyear, month, day]
            var thaiMonth = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
            var lastDataDate = parts[2] + " " + thaiMonth[Number(parts[1])-1] + " " + parts[0];
            // console.log(lastDataDate);
            $("#lastDataDate").html(lastDataDate);
        });
    // /remark last database date

    function isDate(txtDate)
    {
        var currVal = txtDate;
        if(currVal == '')
        return false;
        
        //Declare Regex  
        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
        var dtArray = currVal.match(rxDatePattern); // is format OK?
    
        if (dtArray == null)
            return false;
        
        //Checks for mm/dd/yyyy format.
        dtMonth = dtArray[1];
        dtDay= dtArray[3];
        dtYear = dtArray[5];
    
        if (dtMonth < 1 || dtMonth > 12)
            return false;
        else if (dtDay < 1 || dtDay > 31)
            return false;
        else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
            return false;
        else if (dtMonth == 2)
        {
            var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
            if (dtDay > 29 || (dtDay == 29 && !isleap))
                return false;
        }
        return true;
    }

    // table
    pdfMake.fonts = {
        THSarabun: {
            normal: 'THSarabun.ttf',
            bold: 'THSarabun-Bold.ttf',
            italics: 'THSarabun-Italic.ttf',
            bolditalics: 'THSarabun-BoldItalic.ttf'
        }
    };

    $(".progressionAndResponse").hide();
    $("#outageLineTable").hide();
    var columnName = [
                        {title: 'Date <br>(Y-m-d)'},
                        {title: 'Line'},
                        {title: 'From'},
                        {title: 'To'},
                        {title: 'Minutes'},
                        {title: 'Causes'},
                        {title: 'Component'},
                        {title: 'Relay'},
                        {title: 'Pole'},
                        {title: 'Road'},
                        {title: 'Lateral'},
                        {title: 'Affected fdrs'},
                        {title: 'fdr_minutes'}
                     ];

    var table;
    function createTable(table_data) {
        table = $('#outageLineTable').DataTable( {
            data: table_data,
            columns: columnName,
            responsive: true,
            dom: "<'row'<'col-md-6'B><'col-md-6'f>>"+
                    "<'row'<'col-md-12'rt>>"+
                    "<'row'<'col-md-6'i><'col-md-6 d-flex justify-content-center justify-content-md-end'p>>",
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength', 'copy', 'excel', //'pdf'
                {
                    'extend': 'pdf',
                    'text': 'PDF',
                    'pageSize': 'A4',
                    'customize': function(doc) {
                        doc.defaultStyle = {
                            font: 'THSarabun',
                            fonSize: 16
                        };
                    }
                }
            ]
        } );

        new $.fn.dataTable.FixedHeader( table ); // solve problem that you refresh data then header is gone

        table.on( 'responsive-resize', function ( e, datatable, columns ) {
            table
                .columns.adjust().draw()
                .responsive.recalc();
        } );

        $('.dt-buttons').addClass('d-flex justify-content-center justify-content-md-start');
    }
    // /table

    // action when submitted
    $("#searchForm").on("submit", function(event) {
        event.preventDefault();
        // date validation
        var dateFromVal = $('.dpd1').val();
        var dateToVal = $('.dpd2').val();
        if(isDate(dateFromVal) && isDate(dateToVal)) {
            // continue
        } else {
            alert('Invalid Date');
            return false;
        }
        // /date validation
        // $("#outageLineTable").DataTable().destroy(); //this code does not work
        
        if ( $.fn.dataTable.isDataTable( '#outageLineTable' ) ) {
            table.destroy();
            $('#outageFeederTable').empty();
        }

        $("#outageLineTable").hide();
        $(".progressAndResponse").html("");
        $(".progressAndResponse").addClass("loader12").show();
        $.get("assets/php/formal-outage-line.php",
            $("#searchForm").serialize(),
            function(res){
                console.log(res);
                // console.log($("#searchForm").serialize());
                var table_data = [];
                if (res.length === 0) {
                    var no_res = '<blockquote class="blockquote text-center"><p class="mb-0">ไม่มีสถิติไฟฟ้าดับ หรือ ใส่ชื่อสายส่งไม่ถูกต้อง</p></blockquote>';
                    $(".progressAndResponse").removeClass("loader12");
                    $(".progressAndResponse").html(no_res);
                } else {
                    
                    $.each(res, function(index, event) {
                        table_data.push([   event.event_date, 
                                            event.line, 
                                            event.time_from, 
                                            event.time_to, 
                                            event.timeocb, 
                                            event.t_cause, 
                                            event.t_component, 
                                            event.relay_show, 
                                            event.pole,
                                            event.road,
                                            event.lateral,
                                            event.affected_fdrs,
                                            event.fdr_minutes
                                        ]);
                    });
                    
                    var dateFrom = $("[name='dateFrom']").val();
                    // console.log(Number(dateFrom.substr(-4,4)));
                    if (Number(dateFrom.substr(-4,4)) < 2001) {
                        dateFrom = "01/01/2001";
                    }
                    
                    var dateTo = $("[name='dateTo']").val();
                    var dateDBCompare = new Date(Number(parts[0]), Number(parts[1])-1, Number(parts[2]));
                    var dateToCompare = new Date(Number(dateTo.substr(-4,4)), Number(dateTo.substr(0,2))-1, Number(dateTo.substr(3,2)));
                    if (dateDBCompare.getTime() < dateToCompare.getTime()) {
                        dateTo = parts[1] + "/" + parts[2] + "/" + parts[0];
                    }
                    
                    var lineName = $("#inputLineName").val().toUpperCase();
                    var caption = 'สถิติสายส่ง ' + lineName + ' ไฟฟ้าดับ วันที่ ' + dateFrom + ' ถึง วันที่ ' + dateTo;
                    $("caption").addClass("h5 text-center").css("caption-side","top").text(caption);                    
                    $(".progressAndResponse").removeClass("loader12");
                    $(".progressAndResponse").hide();
                    $("#outageLineTable").show();
                    createTable(table_data);
                }
            }
        );
    });
    // /action when submitted

});