
var graph, graphData;
$(document).ready(function() {
    // added by steve
        var userprefs = {
            goal: 'all',
            employee: 'all',
            merchant: '41',
            fee: '10',
            metric1: 'amount',
            metric2: 'conversions',
            units: 'days',
            start: moment().subtract(9, 'days'),
            end: moment(),
            timezone: 'America/New_York',
            plan_id: 3
        };
    // var a = "We've detected that you have an ad blocker enabled, which may block some of your reports from loading. Please disable your ad blocker on this domain.",
        b = function() {
            setTimeout(function() {
                if (document.getElementsByClassName) {
                    var b = document.getElementsByClassName("afs_ads"),
                        c = b[b.length - 1];
                  //  c && 0 != c.innerHTML.length && 0 !== c.clientHeight || alert(a)
                }
            }, 2e3)
        };
    window.addEventListener ? window.addEventListener("load", b, !1) : window.attachEvent("onload", b);
    var c = "How could this page be better? We read every idea, suggestion and complaint.";
    $("#feedback textarea").val(c), $("#feedback textarea").blur(function() {
        "" == $(this).val() && $(this).val(c)
    }), $("#feedback textarea").focus(function() {
        $(this).val() == c && $(this).val("")
    }), $("#feedback form").submit(function() {
        if ($(this).find("textarea").val() == c) return !1;
        var a = $(this).find("textarea").val(),
            b = window.location.href;
        $(this).find('input[type="submit"]').attr("disabled", "disabled").val("Sending...");
        var d = {
            message: a,
            url: b
        };
        return $.ajax({
            type: "POST",
            url: "/api/feedback",
            data: d,
            dataType: "json",
            success: function() {
                $("#feedback").html("Thank you! Your feedback has been sent.")
            }
        }), !1
    }), $("#overdue_modal .btn-later").click(function() {
        $("#overdue_modal").hide(), set_cookie("hide_overdue", 1, (new Date).getTime())
    });
    var d = get_cookie("hide_overdue");
    null == d && $("#overdue_modal").show(), $("#alerts").click(function() {
        news = "", $("#alerts li.news").each(function() {
            news += $(this).attr("id").replace("news_", "") + ","
        }), $.get("/api/news?news=" + news.slice(0, -1))
    }), $('th, a[rel="tooltip"], btn[rel="tooltip"], div[rel="tooltip"], select[rel="tooltip"], span[rel="tooltip"]').tooltip({
        container: "body"
    }), $("#timeline").on("click", ".icon-delete-target", function() {
        var a = $(this).attr("id").split("_"),
            b = a[0],
            c = a[1],
            d = "visit";
        "goal" == b && (d = "conversion");
        var e = confirm("Are you sure you want to delete this " + d + "?"); 
        if (e) {
            var f = "/api/delete?type=" + b + "&id=" + c;
            $.getJSON(f, function(a) {
                window.location.reload()
            })
        }
    }), $(".timeline-icon .fa-stack-1x").mouseenter(function() {
        var a = $(this).data("title");
        $(this).removeClass(a), $(this).addClass("fa-trash-o")
    }), $(".timeline-icon .fa-stack-1x").mouseleave(function() {
        var a = $(this).data("title");
        $(this).removeClass("fa-trash-o"), $(this).addClass(a)
    }), $("#toggle_advanced").click(function() {
        $("#advanced").toggle(), 'Show advanced settings <i class="fa fa-angle-double-down"></i>' == $(this).html() ? $(this).html('Hide advanced settings <i class="fa fa-angle-double-up"></i>') : $(this).html('Show advanced settings <i class="fa fa-angle-double-down"></i>')
    }), $(".export").click(function() {
        $(this).html();
        $(this).attr("disabled", "disabled")
    });
    var e = {
        ranges: {
            Today: [new Date, new Date],
            Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 Days": [moment().subtract(6, "days"), new Date],
            "Last 30 Days": [moment().subtract(29, "days"), new Date],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
        },
        opens: "right",
     
          "alwaysShowCalendars": true,
        locale: {
            format: "YYYY-MM-DD"
        },
        startDate: userprefs.start,
        endDate: userprefs.end 
    };
    if ($("#daterange").daterangepicker(e, function(a, b) {
            $("#daterange span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY")),
             "undefined" != typeof getTable && getTable(a.format("YYYY-MM-DD"), b.format("YYYY-MM-DD")),
              "undefined" != typeof getGraph && getGraph(a.format("YYYY-MM-DD"), b.format("YYYY-MM-DD")),
               "undefined" != typeof getMetrics && getMetrics(a.format("YYYY-MM-DD"), b.format("YYYY-MM-DD")),
                "undefined" != typeof getTabs && getTabs(a.format("YYYY-MM-DD"), b.format("YYYY-MM-DD")) , 
                "undefined" != typeof onSelectChange3 && 
            onSelectChange3(a.format("YYYY-MM-DD"), b.format("YYYY-MM-DD"))
        }), 
        $("#goalfilter").multiselect({
            includeSelectAllOption: !0,
            selectAllValue: "all",
            selectAllText: "Select All",
            enableFiltering: !0,
            enableCaseInsensitiveFiltering: !0,
            enableHTML: !0,
            buttonClass: "btn selectbox",
            maxHeight: 300,
            buttonText: function(a, b) {
                if (0 === a.length) return '<i class="fa fa-flag"></i> <b>Goal:</b> All Goals';
                if (1 === a.length) {
                    var c = "";
                    return a.each(function() {
                        c = $(this).text()
                    }), '<i class="fa fa-flag"></i> <b>Goal:</b> ' + c
                }
                return '<i class="fa fa-flag"></i> <b>Goal:</b> Multiple Goals'
            }
        }).on("change", function() {
            var a = $(this).find("option:selected"),
                b = [];
            a.length > 0 && a.each(function() {
                b.push($(this).val())
            }), b.length > 0 ? userprefs.goal = b.join("^") : userprefs.goal = "all", $(".ovbox .num").html('<i class="fa fa-spinner fa fa-spin"></i>'), "undefined" != typeof getTable && getTable(), "undefined" != typeof getGraph && getGraph(), "undefined" != typeof getMetrics && getMetrics(), "undefined" != typeof getTabs && getTabs()
        }), "all" != userprefs.goal && userprefs.goal.indexOf("^") < 0) $("#goalfilter").multiselect("select", userprefs.goal);
    else if ("all" != userprefs.goal)
        for (var f = userprefs.goal.split("^"), g = 0; g < f.length; g++) $("#goalfilter").multiselect("select", f[g]);
    $(".glyphicon-search").removeClass("glyphicon glyphicon-search").addClass("fa fa-search"), $(".glyphicon-remove-circle").removeClass("glyphicon glyphicon-remove-circle").addClass("fa fa-remove"), $(".multiselect-container .input-group-addon").hide(), $(".multiselect-container .input-group-btn").hide(), 

$('#graph select[name="graph_metric1"]').val(userprefs.metric1).select2({
        minimumResultsForSearch: 1 / 0,
        templateSelection: function(a) {
            return $('<span><i class="fa fa-square" style="color: #08c"></i> &nbsp;' + a.text + "</span>")
        }
    }).on("change", function() {
        userprefs.metric1 = $(this).val(), "undefined" != typeof getGraph && getGraph(), "undefined" != typeof getMetrics && getMetrics()
    }),

     $('#graph select[name="graph_metric2"]').val(userprefs.metric2).select2({
        minimumResultsForSearch: 1 / 0,
        templateSelection: function(a) {
            return $('<span><i class="fa fa-circle" style="color: #390"></i> &nbsp;' + a.text + "</span>")
        }
    }).on("change", function() {
        userprefs.metric2 = $(this).val(), "undefined" != typeof getGraph && getGraph(), "undefined" != typeof getMetrics && getMetrics()
    }), $('#graph select[name="graph_units"]').val(userprefs.units).select2({
        minimumResultsForSearch: 1 / 0,
        templateSelection: function(a) {
            return $('<span><i class="fa fa-calendar" style="color: #666"></i> &nbsp;' + a.text + "</span>")
        }
    }).on("change", function() {
        userprefs.units = $(this).val(), "undefined" != typeof getGraph && getGraph(), "undefined" != typeof getMetrics && getMetrics()
    }), $("#graph .graph_download").on("click", function() {
        "undefined" != typeof downloadGraph && downloadGraph()
    })
}), countries = {
    A1: "Anonymous Proxy",
    A2: "Satellite Provider",
    AF: "Afghanistan",
    AL: "Albania",
    DZ: "Algeria",
    AS: "American Samoa",
    AD: "Andorra",
    AO: "Angola",
    AI: "Anguilla",
    AQ: "Antarctica",
    AG: "Antigua and Barbuda",
    AR: "Argentina",
    AM: "Armenia",
    AW: "Aruba",
    AU: "Australia",
    AT: "Austria",
    AZ: "Azerbaijan",
    BS: "Bahamas",
    BH: "Bahrain",
    BD: "Bangladesh",
    BB: "Barbados",
    BY: "Belarus",
    BE: "Belgium",
    BZ: "Belize",
    BJ: "Benin",
    BM: "Bermuda",
    BT: "Bhutan",
    BO: "Bolivia",
    BA: "Bosnia and Herzegovina",
    BW: "Botswana",
    BV: "Bouvet Island",
    BR: "Brazil",
    IO: "British Indian Ocean Territory",
    BN: "Brunei Darussalam",
    BG: "Bulgaria",
    BF: "Burkina Faso",
    BI: "Burundi",
    KH: "Cambodia",
    CM: "Cameroon",
    CA: "Canada",
    CV: "Cape Verde",
    KY: "Cayman Islands",
    CF: "Central African Republic",
    TD: "Chad",
    CL: "Chile",
    CN: "China",
    CX: "Christmas Island",
    CC: "Cocos (Keeling) Islands",
    CO: "Colombia",
    KM: "Comoros",
    CG: "Congo",
    CD: "Congo, the Democratic Republic of the",
    CK: "Cook Islands",
    CR: "Costa Rica",
    CI: "Cote D'Ivoire",
    HR: "Croatia",
    CU: "Cuba",
    CY: "Cyprus",
    CZ: "Czech Republic",
    DK: "Denmark",
    DJ: "Djibouti",
    DM: "Dominica",
    DO: "Dominican Republic",
    EC: "Ecuador",
    EG: "Egypt",
    SV: "El Salvador",
    GQ: "Equatorial Guinea",
    ER: "Eritrea",
    EE: "Estonia",
    ET: "Ethiopia",
    EU: "European Union",
    FK: "Falkland Islands (Malvinas)",
    FO: "Faroe Islands",
    FJ: "Fiji",
    FI: "Finland",
    FR: "France",
    GF: "French Guiana",
    PF: "French Polynesia",
    TF: "French Southern Territories",
    GA: "Gabon",
    GM: "Gambia",
    GE: "Georgia",
    DE: "Germany",
    GH: "Ghana",
    GI: "Gibraltar",
    GR: "Greece",
    GL: "Greenland",
    GD: "Grenada",
    GP: "Guadeloupe",
    GU: "Guam",
    GT: "Guatemala",
    GN: "Guinea",
    GW: "Guinea-Bissau",
    GY: "Guyana",
    HT: "Haiti",
    HM: "Heard Island and Mcdonald Islands",
    VA: "Holy See (Vatican City State)",
    HN: "Honduras",
    HK: "Hong Kong",
    HU: "Hungary",
    IS: "Iceland",
    IN: "India",
    ID: "Indonesia",
    IR: "Iran, Islamic Republic of",
    IQ: "Iraq",
    IE: "Ireland",
    IL: "Israel",
    IT: "Italy",
    JM: "Jamaica",
    JP: "Japan",
    JO: "Jordan",
    KZ: "Kazakhstan",
    KE: "Kenya",
    KI: "Kiribati",
    KP: "Korea, Democratic People's Republic of",
    KR: "Korea, Republic of",
    KW: "Kuwait",
    KG: "Kyrgyzstan",
    LA: "Lao People's Democratic Republic",
    LV: "Latvia",
    LB: "Lebanon",
    LS: "Lesotho",
    LR: "Liberia",
    LY: "Libyan Arab Jamahiriya",
    LI: "Liechtenstein",
    LT: "Lithuania",
    LU: "Luxembourg",
    MO: "Macao",
    MK: "Macedonia, the Former Yugoslav Republic of",
    MG: "Madagascar",
    MW: "Malawi",
    MY: "Malaysia",
    MV: "Maldives",
    ML: "Mali",
    MT: "Malta",
    MH: "Marshall Islands",
    MQ: "Martinique",
    MR: "Mauritania",
    MU: "Mauritius",
    YT: "Mayotte",
    MX: "Mexico",
    FM: "Micronesia, Federated States of",
    MD: "Moldova, Republic of",
    MC: "Monaco",
    MN: "Mongolia",
    ME: "Montenegr",
    MS: "Montserrat",
    MA: "Morocco",
    MZ: "Mozambique",
    MM: "Myanmar",
    NA: "Namibia",
    NR: "Nauru",
    NP: "Nepal",
    NL: "Netherlands",
    AN: "Netherlands Antilles",
    NC: "New Caledonia",
    NZ: "New Zealand",
    NI: "Nicaragua",
    NE: "Niger",
    NG: "Nigeria",
    NU: "Niue",
    NF: "Norfolk Island",
    MP: "Northern Mariana Islands",
    NO: "Norway",
    OM: "Oman",
    PK: "Pakistan",
    PW: "Palau",
    PS: "Palestinian Territory, Occupied",
    PA: "Panama",
    PG: "Papua New Guinea",
    PY: "Paraguay",
    PE: "Peru",
    PH: "Philippines",
    PN: "Pitcairn",
    PL: "Poland",
    PT: "Portugal",
    PR: "Puerto Rico",
    QA: "Qatar",
    RE: "Reunion",
    RO: "Romania",
    RU: "Russian Federation",
    RW: "Rwanda",
    SH: "Saint Helena",
    KN: "Saint Kitts and Nevis",
    LC: "Saint Lucia",
    PM: "Saint Pierre and Miquelon",
    VC: "Saint Vincent and the Grenadines",
    WS: "Samoa",
    SM: "San Marino",
    ST: "Sao Tome and Principe",
    SA: "Saudi Arabia",
    SN: "Senegal",
    CS: "Serbia and Montenegro",
    SC: "Seychelles",
    SL: "Sierra Leone",
    SG: "Singapore",
    SK: "Slovakia",
    SI: "Slovenia",
    SB: "Solomon Islands",
    SO: "Somalia",
    ZA: "South Africa",
    GS: "South Georgia and the South Sandwich Islands",
    ES: "Spain",
    LK: "Sri Lanka",
    SD: "Sudan",
    SR: "Suriname",
    SJ: "Svalbard and Jan Mayen",
    SZ: "Swaziland",
    SE: "Sweden",
    CH: "Switzerland",
    SY: "Syrian Arab Republic",
    TW: "Taiwan, Province of China",
    TJ: "Tajikistan",
    TZ: "Tanzania, United Republic of",
    TH: "Thailand",
    TL: "Timor-Leste",
    TG: "Togo",
    TK: "Tokelau",
    TO: "Tonga",
    TT: "Trinidad and Tobago",
    TN: "Tunisia",
    TR: "Turkey",
    TM: "Turkmenistan",
    TC: "Turks and Caicos Islands",
    TV: "Tuvalu",
    UG: "Uganda",
    UA: "Ukraine",
    AE: "United Arab Emirates",
    GB: "United Kingdom",
    US: "United States",
    UM: "United States Minor Outlying Islands",
    UY: "Uruguay",
    UZ: "Uzbekistan",
    VU: "Vanuatu",
    VE: "Venezuela",
    VN: "Viet Nam",
    VG: "Virgin Islands, British",
    VI: "Virgin Islands, U.S.",
    WF: "Wallis and Futuna",
    EH: "Western Sahara",
    YE: "Yemen",
    ZM: "Zambia",
    ZW: "Zimbabwe"
}, states = {
    AA: "Armed Forces",
    AE: "Armed Forces",
    AL: "Alabama",
    AK: "Alaska",
    AZ: "Arizona",
    AR: "Arkansas",
    CA: "California",
    CO: "Colorado",
    CT: "Connecticut",
    DE: "Delaware",
    DC: "District Of Columbia",
    FL: "Florida",
    GA: "Georgia",
    HI: "Hawaii",
    ID: "Idaho",
    IL: "Illinois",
    IN: "Indiana",
    IA: "Iowa",
    KS: "Kansas",
    KY: "Kentucky",
    LA: "Louisiana",
    ME: "Maine",
    MD: "Maryland",
    MA: "Massachusetts",
    MI: "Michigan",
    MN: "Minnesota",
    MS: "Mississippi",
    MO: "Missouri",
    MT: "Montana",
    NE: "Nebraska",
    NV: "Nevada",
    NH: "New Hampshire",
    NJ: "New Jersey",
    NM: "New Mexico",
    NY: "New York",
    NC: "North Carolina",
    ND: "North Dakota",
    OH: "Ohio",
    OK: "Oklahoma",
    OR: "Oregon",
    PA: "Pennsylvania",
    RI: "Rhode Island",
    SC: "South Carolina",
    SD: "South Dakota",
    TN: "Tennessee",
    TX: "Texas",
    UT: "Utah",
    VT: "Vermont",
    VA: "Virginia",
    WA: "Washington",
    WV: "West Virginia",
    WI: "Wisconsin",
    WY: "Wyoming"
};