/*! improvely 2017-07-09 */
function imGraph(a, b) {
    var c = {
        global: {
            useUTC: !1
        },
        chart: {
            renderTo: "graph",
            marginTop: 0,
            marginBottom: 40,
            borderRadius: 0,
            backgroundColor: "#ffffff"
        },
        title: {
            text: null
        },
        colors: ["#0088cc", "#339900"],
        credits: {
            enabled: !1
        },
        legend: {
            enabled: !1
        },
        plotOptions: {
            area: {
                lineWidth: 2.5,
                fillOpacity: .1,
                marker: {
                    lineColor: "#fff",
                    lineWidth: 1,
                    radius: 3.5,
                    symbol: "circle"
                },
                shadow: !1
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
            gridLineColor: "#eeeeee",
            gridLineWidth: 0,
            labels: {
                style: {
                    color: "#999999"
                }
            }
        },
        yAxis: [{
            showFirstLabel: !1,
            showLastLabel: !1,
            tickPixelInterval: 50,
            endOnTick: !1,
            title: {
                text: null
            },
            gridLineColor: "#eeeeee",
            gridLineWidth: .5,
            zIndex: 2,
            labels: {
                align: "right",
                style: {
                    color: "#999999"
                },
                x: -4
            }
        }, {
            showFirstLabel: !1,
            showLastLabel: !1,
            tickPixelInterval: 50,
            endOnTick: !1,
            title: {
                text: null
            },
            opposite: !0,
            gridLineColor: "#eeeeee",
            gridLineWidth: .5,
            zIndex: 1,
            labels: {
                align: "left",
                style: {
                    color: "#999999"
                },
                x: 4
            }
        }],
        tooltip: {
            shadow: !1,
            borderRadius: 3,
            shared: !0,
            formatter: function(a) {
                var b = parseInt(this.points[0].y) == this.points[0].y ? this.points[0].y : this.points[0].y.toFixed(2),
                    c = parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2),
                    d = '<span style="font-size: 10px">' + moment(this.x).format("dddd, MMM D, YYYY") + "</span>",
                    e = '<span style="color: #08c">' + a.chart.series[0].name + ":</span> <b>" + b + "</b>",
                    f = '<span style="color: #390">' + a.chart.series[1].name + ":</span> <b>" + c + "</b>";
                return d + " <br /> " + e + " <br /> " + f
            }
        },
        series: [{
            type: "column"
        }, {
            type: "area",
            yAxis: 1
        }]
    };
    if ($('select[name="graph_metric1"]').length > 0) var d = $('select[name="graph_metric1"]').val(),
        e = $('select[name="graph_metric1"]').select2("data")[0].text,
        f = $('select[name="graph_metric2"]').val(),
        g = $('select[name="graph_metric2"]').select2("data")[0].text;
    else d = "people", e = "People", f = "conversions", g = "Conversions";
    var h = [],
        i = [],
        j = [];
    for (var k in b)
        if (b[k].convrate = 0 == b[k].people ? 0 : (b[k].conversions / b[k].people * 100).toFixed(2), b[k].cpa = 0 == b[k].conversions ? 0 : b[k].cost / b[k].conversions, b[k].cpc = 0 == b[k].clicks ? 0 : b[k].cost / b[k].clicks, b[k].rpp = 0 == b[k].people ? 0 : b[k].revenue / b[k].people, b[k].profit = b[k].revenue - b[k].cost, null != b[k].date && 0 != b[k].date.length) {
            var l = parseFloat(b[k][d]);
            h.push([moment(b[k].date).valueOf(), l]);
            var l = parseFloat(b[k][f]);
            i.push([moment(b[k].date).valueOf(), l])
        } else j = b[k];
    0 == j.length && b[0] && (j = b[0]), c.series[0].name = e, c.series[0].data = h, c.series[0].pointStart = h[0][0].valueOf(), c.series[1].name = g, c.series[1].data = i, c.series[1].pointStart = i[0][0].valueOf(), $("#" + a + " .placeholder").length > 0 ? c.chart.renderTo = $("#" + a + " .placeholder")[0] : c.chart.renderTo = $("#" + a)[0];
    var m, n;
    m = "cost" == d || "cpa" == d || "cpc" == d || "revenue" == d || "rpp" == d || "profit" == d ? format_money(j[d]) : "convrate" == d ? format_rate(j[d] / 100) : add_commas(j[d]), n = "cost" == f || "cpa" == f || "cpc" == f || "revenue" == f || "rpp" == f || "profit" == f ? format_money(j[f]) : "convrate" == f ? format_rate(j[f] / 100) : add_commas(j[f]), $(".metric1 h1").html(m), $(".metric1 h2").html(e), $(".metric2 h1").html(n), $(".metric2 h2").html(g), graph = new Highcharts.Chart(c), graphData = b
}