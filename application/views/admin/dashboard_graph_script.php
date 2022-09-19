<?php  
    $last_date = date("Y-m-d",strtotime("-29 days"));
    $date = date("Y-m-d");
?>
<script type="text/javascript"> 
    var userprefs = {
        goal: 'all',
        employee: 'all',
        merchant: '',
        fee: '',
        metric1: 'amount',
        metric2: 'conversions',
        units: 'days',
        start: '<?php echo $last_date; ?>',
        end: '<?php echo $date; ?>',
        timezone: 'America/New_York',
        plan_id: 3
    };

    // var dtConfigHiddenTable = {
    //     dom: 'B', destroy: true, order: [],
    //     "buttons":
    //     [{
    //         extend: 'collection',
    //         text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
    //         buttons: [
    //             {
    //                 extend: 'csv',
    //                 titleAttr: 'Download CSV report',
    //                 text: '<i class="fa fa-file-text-o" aria-hidden="true"></i> CSV Report'
    //             },
    //             {
    //                 extend: 'excelHtml5',
    //                 titleAttr: 'Download Excel report',
    //                 text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel Report',
                   
    //             },
    //             {
    //                 extend: 'pdfHtml5',
    //                 orientation: 'landscape',
    //                 titleAttr: 'Download PDF report',
    //                 text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF Report',
                    
    //             }
    //         ]
    //     }]
    // };

    // function saleSummeryPdfTableConvertor($wraper,jd,totals){
    //     var allRow='',tfoot='',nameCol=false;
    //     if(typeof totals != 'object')
    //         totals=JSON.parse(totals);
    //     if(parseInt(totals[0]['is_Customer_name'])) {
    //         var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');
    //         nameCol=true;
    //     } else {
    //         var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');
    //     }

    //     if(!jd) {
    //         allRow='<tr><td colspan="5" align="center">No data</td></tr>';
    //     } else {
    //         if(typeof jd != 'object')
    //             jsonData = JSON.parse(jd);
    //         else
    //             jsonData = jd;

    //         jsonData.forEach(function(val, i){
    //             if(allRow != '') {
    //                 allRow+=
    //                     '<tr><td>'+val.Amount
    //                     +'</td><td>'+val.Tax
    //                     +'</td><td>'+val.Tip
    //                     +'</td><td>'+val.Type
    //                     +'</td><td>'+val.Date
    //                     +'</td><td>'+val.Reference
    //                     +'</td></tr>';    
    //             } else {
    //                 allRow='<tr><td>'+val.Amount+'</td><td>'+val.Tax+'</td><td>'+val.Tip+'</td><td>'+val.Type+'</td><td>'+val.Date+'</td><td>'+val.Reference+'</td></tr>';    
    //             }
    //         });
    //     }

    //     newTable.find('tbody').html(allRow);
    //     // newTable.find('tbody').append(tfoot);
    //     $wraper.html(newTable);
    //     $wraper.find('table').DataTable(dtConfigHiddenTable);
    // }
</script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/graph/app.min.js"></script> -->

<script type="text/javascript">
    function imGraph(a, b) {
        console.log(a);
        console.log(b);return false;
        var c = {
            global: {
                useUTC: !1
            },
            chart: {
                type: 'areaspline',
                renderTo: "graph",
                height: 350,
                marginTop: 0,
                // marginBottom: 40,
                borderRadius: 0,
                backgroundColor: "#ffffff"
            },
            title: {
                text: null
            },
            colors: ["#ffffff00", "#00a6ff",'#ffffff00'],
            credits: {
                enabled: !1
            },
            legend: {
                enabled: !1
            },
            plotOptions: {
                area: {
                    lineWidth: 4,
                    fillOpacity: .1,
                    marker: {
                        lineColor: "#ffffff00",
                        lineWidth: 3,
                        symbol: 'circle'
                    },
                    shadow: !1
                },
                spline: {
                    lineWidth: 4,
                    marker: {
                        lineWidth: 3,
                        lineColor: '#ffffff',
                        symbol: 'circle'
                    }
                },
                column: {
                    lineWidth: 16,
                    shadow: !1,
                    borderWidth: 0,
                    groupPadding: .05
                }
            },
            xAxis: {
                type: "datetime",
                title: {
                    text: null
                },
                tickmarkPlacement: "off",
                dateTimeLabelFormats: {
                    day: "%b %e"
                },
                gridLineColor: "#eaeaea",
                gridLineWidth: 0,
                labels: {
                    style: {
                        color: "#9b9b9b"
                    }
                }
            },
            yAxis: [
                {
                    showFirstLabel: !1,
                    showLastLabel: !1,
                    tickPixelInterval: 50,
                    endOnTick: !1,
                    title: {
                        text: null
                    },
                    opposite: !0,
                    gridLineColor: "#eaeaea",
                    gridLineWidth: .5,
                    zIndex: -1,
                    labels: {
                        align: "left",
                        style: {
                            color: "#fff"
                        },
                        x: 4
                    }
                },
                {
                    showFirstLabel: !1,
                    showLastLabel: !1,
                    tickPixelInterval: 50,
                    endOnTick: !1,
                    title: {
                        text: null
                    },
                    gridLineColor: "#eaeaea",
                    gridLineWidth: .5,
                    zIndex: 2,
                    labels: {
                        align: "right",
                        style: {
                            color: "#9b9b9b"
                        },
                        x: -4
                    }
                }
            ],
            tooltip: {
                shadow: !1,
                borderRadius: 3,
                shared: !0,
                formatter: function(a) {
                    var b = parseInt(this.points[0].y) == this.points[0].y ? this.points[0].y : this.points[0].y.toFixed(2),
                    b =isNaN(b)?0:(b!=''?b:0),
                    // console.log(this),
                    c = (this.points[1] != undefined) ? (parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2)): 0,
                    fee = (this.points[2] != undefined) ? parseInt(this.points[2].y) == this.points[2].y ? this.points[2].y : this.points[2].y.toFixed(2) : 0,
                    d = '<span ><b>' + moment(this.x).format("dddd, MMM D, YYYY") + "</b></span>",
                    e = '<span style="color: #390390">' + a.chart.series[0].name + ":</span> <b> $" + parseFloat(b).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + "</b>",
                    f = '<span style="color: #08c08c">' + a.chart.series[1].name + ":</span> <b> $" + parseFloat(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") 
                    + "</b> <br/>" + '<span style="color: #C14242">' + "Fee  :" + '<b> $' + parseFloat(fee).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</b>' + '</span>';
                    return d + " <br /> " + f + " <br /> " + e
                    //  return d + " <br /> "  + f
                }
            },
            series: [
                {
                    type: "spline",
                        marker: {
                            lineWidth: 0,
                        },
                    states: {
                        hover: {
                            enabled: false
                        }
                    }
                }, {
                    type: "spline",
                    yAxis: 1
                }, {
                    type: "spline",
                    yAxis: 1,
                        marker: {
                            lineWidth: 0,
                        },
                    states: {
                        hover: {
                            enabled: false
                        }
                    }
                }
            ]
        };

        if ($('select[name="graph_metric1"]').length > 0) var d = $('select[name="graph_metric1"]').val(),
            e = $('select[name="graph_metric1"]').select2("data")[0].text,
            f = $('select[name="graph_metric2"]').val(),
            g = $('select[name="graph_metric2"]').select2("data")[0].text;
        else d = "tax", e = "Tax", f = "amount", g = "Amount";
            // else  f = "conversions", g = "Amount";
            var h = [],
            i = [],
            j = [];
            fee=[];
            for (var k in b)
                if (b[k].convrate = 0 == b[k].amount ? 0 : (b[k].tax / b[k].amount * 100).toFixed(2), b[k].cpa = 0 == b[k].tax ? 
                0 : b[k].cost / b[k].conversions, b[k].cpc = 0 == b[k].clicks ? 0 : b[k].cost / b[k].clicks, b[k].rpp = 0 == b[k].people ? 0
                : b[k].revenue / b[k].people, b[k].profit = b[k].revenue - b[k].cost, null != b[k].date && 0 != b[k].date.length) {
                    var l = parseFloat(b[k][d]);
                    h.push([moment(b[k].date).valueOf(), l]);
                    var l = parseFloat(b[k][f]);
                    i.push([moment(b[k].date).valueOf(), l])
                    var l = parseFloat(b[k].cost);
                    fee.push([moment(b[k].date).valueOf(), l])
                } else j = b[k];
                    0 == j.length && b[0] && (j = b[0]), c.series[0].name = e, c.series[0].data = h, c.series[0].pointStart = h[0][0].valueOf(), 
                    c.series[1].name = g, c.series[1].data = i, c.series[1].pointStart = i[0][0].valueOf(), c.series[2].name = "Fee", c.series[2].data = fee, c.series[2].pointStart = i[0][0].valueOf(), $("#" + a + " .placeholder")
                    .length > 0 ? c.chart.renderTo = $("#" + a + " .placeholder")[0] : c.chart.renderTo = $("#" + a)[0];
                    var m, n;
                    m = "cost" == d || "cpa" == d || "cpc" == d || "revenue" == d || "rpp" == d || "profit" == d ? format_money(j[d]) :
                    "convrate" == d ? format_rate(j[d] / 100) : add_commas(j[d]), n = "cost" == f || "cpa" == f || "cpc" == f || "revenue" == f ||
                    "rpp" == f || "profit" == f ? format_money(j[f]) : "convrate" == f ? format_rate(j[f] / 100) : add_commas(j[f]),
                    $(".metric1 h1").html(m), $(".metric1 h2").html(e), $(".metric2 h1").html(n), $(".metric2 h2").html(g),
                    graph = new Highcharts.Chart(c), graphData = b
    }
</script>