jQuery(document).ready(function(){

    // toggle switch
    $(":checkbox").on("change", function() {
        if ($(this).prop("checked")) {
            $(".round-feeder").css({"color": "lightgray"});//, "text-shadow": ""});
            $(".round-district").css({"color": "#006dcc"});//, "text-shadow": "0 0 2px #006dcc", "transition": "text-shadow 0.5s ease", "transition": "color 0.5s ease"});
            $(".card-header").fadeOut(200);
            $(".card-header").removeClass("bg-info").addClass("bg-primary");
            $(".card-header").text("สถิติสายป้อนไฟฟ้าดับที่ใช้คำนวณดัชนีฯ ราย ฟข. (ข้อมูลไม่เป็นทางการ)").fadeIn(200);        
            $(".card").removeClass("border-info").addClass("border-primary");
            $("#submitForm").removeClass("btn-info").addClass("btn-primary");
            $("#downloadDistrictCust").removeClass("btn-info").addClass("btn-primary");
            // $("#searchForm .form-group:nth-child(2)").hide(); // hide feederName text box
            $("#inputFeederName").attr('required', false);
            
            // $("#DataDate").html(initialDataDate15 + " ถึง " + lastDataDate15);
            // // You have to set ennDate before startDate.
            // endDate.setValue(new Date(lastDataYear15E + "-" + lastDataMonth15E + "-" + lastDataDay15E));
            // startDate.setValue(new Date(lastDataYear15E + "-" + lastDataMonth15E + "-01"));
            $("#DataDate").html(initialDataDate + " ถึง " + lastDataDate);
            endDate.setValue(lastDataDateE);
            startDate.setValue(initialDataDateE);

        } else {
            $(".round-feeder").css({"color": "#17a2b8"});//, "text-shadow": "0 0 2px #17a2b8", "transition": "text-shadow 0.5s ease", "transition": "color 0.5s ease"});
            $(".round-district").css({"color": "lightgray"});//, "text-shadow": ""});
            $(".card-header").fadeOut(200);
            $(".card-header").removeClass("bg-primary").addClass("bg-info");
            $(".card-header").text("สถิติสายป้อนไฟฟ้าดับที่ใช้คำนวณดัชนีฯ ราย ฟข. (ข้อมูลทางการ)").fadeIn(200);
            $(".card").removeClass("border-primary").addClass("border-info");
            $("#submitForm").removeClass("btn-primary").addClass("btn-info");
            $("#downloadDistrictCust").removeClass("btn-primary").addClass("btn-info");
            // $("#searchForm .form-group:nth-child(2)").show();
            $("#inputFeederName").attr('required', true);
            
            $("#DataDate").html(initialDataDate + " ถึง " + lastDataDate);
            endDate.setValue(lastDataDateE);
            startDate.setValue(initialDataDateE);
        }
    });
    // /toggle switch

    // remark last database date
    var initialDataDate, lastDataDate, initialDataDate15, lastDataDate15;
    var initialDataDateE, lastDataDateE, initialDataDay15E, lastDataYear15E, lastDataMonth15E;
    $.get("assets/php/top-indices-F-cause-first.php",
        function(res) {
            console.log(res);
            // console.log(res[0].lasted_date);
            // console.log(res[0].date);
            // console.log(res[0].date.split('-'));
            // var parts = JSON.parse(res)[0].date.split('-'); // array parts = [ัyear, month, day] ใช้ได้เมื่อ php file ไม่ได้ใส่ header('Content-Type: application/json');
            // initialDataDateE = res[0].initial_date;
            // lastDataDateE = res[0].lasted_date;
            // initialDataDate15E = res[1].initial_date15;
            // lastDataDate15E = res[1].lasted_date15;
            
            var thaiMonth = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
            var parts = res[0].initial_date.split('-'); // array parts = [year, month, day]
            initialDataDate = parts[2] + " " + thaiMonth[Number(parts[1])-1] + " " + parts[0];
            var parts = res[0].lasted_date.split('-'); // array parts = [year, month, day]
            lastDataDate = parts[2] + " " + thaiMonth[Number(parts[1])-1] + " " + parts[0];
            lastDataDateE = new Date(parts[0] + "-" + parts[1] + "-" + parts[2]);
            initialDataDateE = new Date(parts[0] + "-" + parts[1] + "-01");
            // var parts = res[1].initial_date15.split('-'); // array parts = [year, month, day]
            // initialDataDate15 = parts[2] + " " + thaiMonth[Number(parts[1])-1] + " " + parts[0];
            // var parts = res[1].lasted_date15.split('-'); // array parts = [year, month, day]
            // lastDataDate15 = parts[2] + " " + thaiMonth[Number(parts[1])-1] + " " + parts[0];
            // lastDataDay15E = parts[2];
            // lastDataMonth15E = parts[1];
            // lastDataYear15E = parts[0];
            // initialDataDate15 = "01 " + thaiMonth[Number(parts[1])-1] + " " + parts[0]

            // console.log(lastDataDate);
            $("#DataDate").html(initialDataDate + " ถึง " + lastDataDate);
            endDate.setValue(lastDataDateE);
            startDate.setValue(initialDataDateE);            
            // $("#DataDate").html(initialDataDate15 + " ถึง " + lastDataDate15);
        });

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
    // /remark last database date

    // date range
    {
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var ealierMonth = new Date(nowTemp.getFullYear(), nowTemp.getMonth()-1, 1, 0, 0, 0, 0);
        // console.log(nowTemp);
        // var d = new Date("2019-05-21");
        // console.log(d);
        
        var endDate = $('.dpd2').datepicker({
            onRender: function(date) {
                // console.log('end');
                return date.valueOf() > now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            if (ev.date.valueOf() < startDate.date.valueOf()) {
                startDate.setValue(ev.date);
            }
            startDate.setValue(startDate.date);
            endDate.hide();
        }).data('datepicker');

        // endDate.setValue(lastDataDateE);

        var startDate = $('.dpd1').datepicker({
            onRender: function(date) {
                // console.log('start');
                return date.valueOf() > endDate.date.valueOf() ? 'disabled' : '';
                // return date.valueOf() > now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            startDate.hide();
            // add this code for forcing to select only last month
            if ($(":checkbox").prop("checked") && startDate.date.valueOf() < (new Date(lastDataYear15E + "-" + lastDataMonth15E + "-01")).valueOf()) {
                startDate.setValue(new Date(lastDataYear15E + "-" + lastDataMonth15E + "-01"));
            }
            // / add this code for forcing to select only last month
        }).data('datepicker');
        
        // startDate.setValue(ealierMonth);
    }
    // /date range

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
    $("#outageFeederTable").hide();
                    
    var table;                    
    function createTable(table_data) {
        var columnNameCauseEachDistrictSustain = [
                {title: 'สาเหตุ'},
                {title: 'จำนวนครั้งไฟฟ้าดับ<br>ที่มีสาเหตุจาก ฟข. ที่เลือก'},
                {title: 'จำนวนครั้งไฟฟ้าดับที่มีสาเหตุจาก<br>และกระทบต่อ<br>ฟข. ที่เลือกเท่านั้น'},
                {title: 'จำนวนผู้ใช้ไฟฟ้าดับที่มีสาเหตุจาก<br>และกระทบต่อ<br>ฟข. ที่เลือกเท่านั้น'},
                {title: 'จำนวนผู้ใช้ไฟนาทีสาเหตุจาก<br>และกระทบต่อ<br>ฟข. ที่เลือกเท่านั้น'},
                {title: 'จำนวนครั้งไฟฟ้าดับ<br>ที่มีสาเหตุจาก ฟข. อื่น<br>และกระทบกับ ฟข. ที่เลือก'},
                {title: 'จำนวนผู้ใช้ไฟฟ้าดับ<br>ที่มีสาเหตุจาก ฟข. อื่น<br>และกระทบกับ ฟข. ที่เลือก'},
                {title: 'จำนวนผู้ใช้ไฟนาที<br>ที่มีสาเหตุจาก ฟข. อื่น<br>และกระทบกับ ฟข. ที่เลือก'}
            ];
        var columnNameCauseEachDistrictMomentary = [
                {title: 'สาเหตุ'},
                {title: 'จำนวนครั้งไฟฟ้าดับ<br>ที่มีสาเหตุจาก ฟข. ที่เลือก'},
                {title: 'จำนวนครั้งไฟฟ้าดับที่มีสาเหตุจาก<br>และกระทบต่อ<br>ฟข. ที่เลือกเท่านั้น'},
                {title: 'จำนวนผู้ใช้ไฟฟ้าดับที่มีสาเหตุจาก<br>และกระทบต่อ<br>ฟข. ที่เลือกเท่านั้น'},
                {title: 'จำนวนครั้งไฟฟ้าดับ<br>ที่มีสาเหตุจาก ฟข. อื่น<br>และกระทบกับ ฟข. ที่เลือก'},
                {title: 'จำนวนผู้ใช้ไฟฟ้าดับ<br>ที่มีสาเหตุจาก ฟข. อื่น<br>และกระทบกับ ฟข. ที่เลือก'},
            ];
        var columnNameCauseAllDistrictSustain = [
                {title: 'สาเหตุ'},
                {title: 'จำนวนครั้งไฟฟ้าดับ<br>ทั้งหมดของสายป้อน'},
                {title: 'จำนวนผู้ใช้ไฟทั้งหมด<br>ที่ได้รับผลกระทบ'},
                {title: 'จำนวนผู้ใช้ไฟนาทีทั้งหมด<br>ที่ได้รับผลกระทบ'}
            ];
        var columnNameCauseAllDistrictMomentary = [
                {title: 'สาเหตุ'},
                {title: 'จำนวนครั้งไฟฟ้าดับ<br>ทั้งหมดของสายป้อน'},
                {title: 'จำนวนผู้ใช้ไฟทั้งหมด<br>ที่ได้รับผลกระทบ'},
            ];

        var columnName = [];
        var targetsColumnDefs = [];
        if (Number($("#selectDistrict option:selected").val()) > 0) {
            if (Number($("input[name='typeInterruption']:checked").val()) == 1) {
                columnName = columnNameCauseEachDistrictSustain;
                targetsColumnDefs = [0, 1, 2, 3, 4, 5, 6, 7];
            } else {
                columnName = columnNameCauseEachDistrictMomentary;
                targetsColumnDefs = [0, 1, 2, 3, 4, 5];
            }
        } else {
            if (Number($("input[name='typeInterruption']:checked").val()) == 1) {
                columnName = columnNameCauseAllDistrictSustain;
                targetsColumnDefs = [0, 1, 2, 3];
            } else {
                columnName = columnNameCauseAllDistrictMomentary;
                targetsColumnDefs = [0, 1, 2];
            }
        }

        table = $('#outageFeederTable').DataTable( {
            data: table_data,
            columns: columnName,
            // responsive: true,
            scrollX: true,
            columnDefs: [
                {
                    className: "text-center",
                    targets: targetsColumnDefs
                }
            ],
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
                    'pageSize': 'LEGAL',
                    'orientation': 'Landscape',
                    'customize': function(doc) {
                        doc.defaultStyle = {
                            font: 'THSarabun',
                            fonSize: 16
                        };
                    }
                }
            ],
            order: [[1, "desc"]],
            // destroy: true
        } );

        // new $.fn.dataTable.FixedHeader( table ); // solve problem that you refresh data then header is gone

        // table.on( 'responsive-resize', function ( e, datatable, columns ) {
        //     table
        //         .columns.adjust().draw()
        //         .responsive.recalc();
        // } );

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
        // $("#outageFeederTable").DataTable().destroy(); //this code does not work
        if ( $.fn.dataTable.isDataTable( '#outageFeederTable' ) ) {
            table.destroy();
            $('#outageFeederTable').empty();
        }

        $("#outageFeederTable").hide();
        $(".progressAndResponse").html("");
        // $(".progressAndResponse").html('<blockquote class="blockquote text-center"><p class="mb-0">...กำลังดำเนินการ...</p></blockquote>').show();
        $(".progressAndResponse").addClass("loader12").show();
        // $(".progressAndResponse").show();
        console.log($("#searchForm").serialize() + "&rankFeeder=" + $(":checkbox").prop("checked"));
        $.get("assets/php/top-indices-F-cause.php",
            $("#searchForm").serialize() + "&rankFeeder=" + $(":checkbox").prop("checked"),
            function(res){
                console.log(res);
                // console.log($("input[name='typeInterruption']:checked").val());
                // console.log(typeof(Number($("#selectDistrict option:selected").val())));
                // console.log($("#searchForm").serialize());
                var table_data = [];
                var interruption_type = "";
                if (res.length === 0) {
                    var no_res = '<blockquote class="blockquote text-center"><p class="mb-0">ไม่มีสถิติไฟฟ้าดับ</p></blockquote>';
                    $(".progressAndResponse").removeClass("loader12");
                    $(".progressAndResponse").html(no_res);
                } else {
                    if (Number($("#selectDistrict option:selected").val()) > 0) {//select district
                        
                        if (Number($("input[name='typeInterruption']:checked").val()) == 1) {// sustain interruption
                            $.each(res, function(index, event) {
                                table_data.push([
                                                    event.main_cause,
                                                    event.outageCount,
                                                    event.outageAndAffectedCount,
                                                    event.outageAndAffectedCustnum,
                                                    event.outageAndAffectedCustmin,
                                                    event.affectedCount,
                                                    event.affectedCustnum,
                                                    event.affectedCustmin
                                                ]);
                            });
                            interruption_type = "นาน";
                        } else {// momentary interruption
                            $.each(res, function(index, event) {
                                table_data.push([
                                                    event.main_cause,
                                                    event.outageCount,
                                                    event.outageAndAffectedCount,
                                                    event.outageAndAffectedCustnum,
                                                    event.affectedCount,
                                                    event.affectedCustnum
                                                ]);
                            });
                            interruption_type = "ชั่วครู่";
                        }
                        
                    } else { //select all district Number($("#selectDistrict option:selected").val()) = 0
                        
                        if (Number($("input[name='typeInterruption']:checked").val()) == 1) {// sustain interruption
                            $.each(res, function(index, event) {
                                table_data.push([
                                                    event.main_cause,
                                                    event.outageCount,
                                                    event.outageCustnum,
                                                    event.outageCustmin
                                                ]);
                            });
                            interruption_type = "นาน";
                        } else {// momentary interruption
                            $.each(res, function(index, event) {
                                table_data.push([
                                                    event.main_cause,
                                                    event.outageCount,
                                                    event.outageCustnum,
                                                ]);
                            });
                            interruption_type = "ชั่วครู่";
                        }

                    }
                    
                    var dateFrom = $("[name='dateFrom']").val();
                    var dateTo = $("[name='dateTo']").val();
                    var districtName = $("#selectDistrict option:selected").text();
                    // if ($(":checkbox").prop("checked")) { // district search
                    //     var caption = 'สถิติสายป้อนไฟฟ้าดับ กฟน. เขต' + districtName +  ' วันที่ ' + dateFrom + ' ถึง วันที่ ' + dateTo;
                    // } else { // feeder cause search               
                    var caption = 'สถิติสาเหตุสายป้อนไฟฟ้าดับ' + interruption_type + ' กฟน. เขต' + districtName +  ' วันที่ ' + dateFrom + ' ถึง วันที่ ' + dateTo;
                    // }
                    $('#outageFeederTable').append('<caption class="h5 text-center" style="caption-side: top">' + caption + '</caption>')
                    // $("caption").addClass("h5 text-center").css("caption-side","top").text(caption);
                    $(".progressAndResponse").removeClass("loader12");
                    $(".progressAndResponse").hide();
                    $("#outageFeederTable").show();
                    createTable(table_data);
                }
            }
        );
    });
    // /action when submitted

    // download customer district
    $("#downloadDistrictCust").on("click", function(event) {
        
        var createXLSLFormatObj = [];

        /* XLS Head Columns */
        var xlsHeader = ["month", "year", "district", "nocus"];

        /* XLS Rows Data */
        var xlsRows = [];
        console.log($("#searchForm").serialize() + "&unofficialData=" + $(":checkbox").prop("checked"));
        $.get("assets/php/formal-indices-F-downloadCust.php",
        $("#searchForm").serialize() + "&unofficialData=" + $(":checkbox").prop("checked"),// use "&unofficialData" because i will get customer from formal-indices-F-downloadCuse.php
        function(res) {
            console.log(res);
            xlsRows = res;
            console.log(xlsRows);
        
            createXLSLFormatObj.push(xlsHeader);
            $.each(xlsRows, function(index, value) {
                // console.log(value);
                var innerRowData = [];
                $.each(value, function(ind, val) {

                    innerRowData.push(val);
                });
                createXLSLFormatObj.push(innerRowData);
            });
            // console.log(createXLSLFormatObj);

            var base_name = $("#selectDistrict option:selected").text();

            /* File Name */
            var filename = base_name + "_cust.xlsx";

            /* Sheet Name */
            var ws_name = base_name + "_cust";

            if (typeof console !== 'undefined') console.log(new Date());
            var wb = XLSX.utils.book_new(),
                ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);

            /* Add worksheet to workbook */
            XLSX.utils.book_append_sheet(wb, ws, ws_name);

            /* Write workbook and Download */
            if (typeof console !== 'undefined') console.log(new Date());
            XLSX.writeFile(wb, filename);
            if (typeof console !== 'undefined') console.log(new Date());
        });
    });
    // /download customer district

});

