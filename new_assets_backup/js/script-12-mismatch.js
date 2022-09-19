
//GLOBAL VARIALES
  var posInputValue="", posInput = ""
      lastYear=moment().subtract(1,"Year").format('YYYY'),
      currentYear=moment().format('YYYY'),
      sidebarScrollBar='';
//login register make v-center
  function vCenterRequired($elem){
    var winH=$(window).height() - 30 ;
    var elemH=$elem.outerHeight(true) ;
    if(elemH > winH){
      return false
    }
    else{
      return true;
    }
  }
//apply v-center
  function loginRegFget(){
    if(vCenterRequired($('.login-register'))){
       $('.login-register').addClass('v-center');
     }
     else{
       $('.login-register').removeClass('v-center');
     }
  }
     
//sale chart default range
  function daterangeDefault(){
      $('#daterange span').html(moment().subtract(9, 'days').format('MMMM D, YYYY') +' - '+moment().format('MMMM D, YYYY'));
  }
        
//golbale fn - input validation 
  function validatePosForm() {
      var x = document.forms["pos_form"]["amount"].value;
      console.log(x)
      if (x == "") {
          alert("Amount must be filled out");
          return false;
      }
  }
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      {
        return false;
      }
      return true;
  }
  function formatNumber(posInput) {
   if(isNaN(parseFloat(posInput))) {
       return "0.00"; //if the input is invalid just set the value to 0.00
   }
   var num = parseFloat(posInput);
   return (num / 100).toFixed(2); //move the decimal up to places return a X.00 format
  }
  function isNumberKeydc(evt)
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
       return false;
    return true;
  }
  function formatNumberg(posInput) {
       if(isNaN(parseFloat(posInput))) {
           return "0.00"; //if the input is invalid just set the value to 0.00
       }
       var num = parseFloat(posInput);
       return (num / 100).toFixed(2); //move the decimal up to places return a X.00 format
  }
  function getKeyValue(keyCode) {
   if(keyCode > 57) { //also check for numpad keys
       keyCode -= 48;
   }
   if(keyCode >= 48 && keyCode <= 57) {
       return String.fromCharCode(keyCode);
   }
  }
//stepper form check validation
	function stepperFormFunction(){

	}
//pos calculation
  function posCalcFn(btn){
    // console.log($(btn).data())
    var x = $(btn).data().val;
    var y = $(btn).data().val;
    var doc=document.getElementById("t_amount").value;
    doc+=x;
    posInputValue+=x
    posInput=posInputValue;
    document.getElementById("t_amount").value = formatNumberg(posInputValue);
      
    var z = document.getElementById("sub_amount");
    z.value = formatNumberg(posInputValue);
  }
 
//json to csv converter
  function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

    var CSV = '';
    //Set Report title in first row or line

    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
      var row = "";

        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {

            //Now convert each value to string and comma-seprated
            row += index + ',';
          }

          row = row.slice(0, -1);

        //append Label row with line break
        CSV += row + '\r\n';
      }

    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
      var row = "";

        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
          row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);

        //add a line break after each row
        CSV += row + '\r\n';
      }

      if (CSV == '') {
        alert("Invalid data");
        return;
      }

    //Generate a file name
    var fileName = "MyReport_";
    //this will remove the   from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g, "_");

    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    

    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");
    link.href = uri;

    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";

    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

//draw sale by year chart
  var dataSaleByYearVals1=[
              {y: 502.33,tax: 0,avg: 1000}, 
              {y: 154534.65,tax: 0,avg: 100}, 
              {y: 1.41,tax: 0,avg: 200}, 
              {y: 6.14,tax: 0,avg: 300}, 
              {y: 0,tax: 0,avg: 400}, 
              {y: 0,tax: 0,avg: 500}, 
              {y: 0,tax: 0,avg: 600}, 
              {y: 70000,tax: 0,avg: 700}, 
              {y: 0,tax: 0,avg: 0}, 
              {y: 0,tax: 0,avg: 0}, 
              {y: 50000,tax: 0,avg: 0}, 
              {y: 0,tax: 0,avg: 0}
          ]
  var dataSaleByYearVals2=[
              {y : 0, tax: 50, avg: 1 }, 
              {y : 5000,tax: 23,avg: 0}, 
              {y : 0,tax: 51,avg: 0}, 
              {y : 5000,tax: 20,avg: 1}, 
              {y : 4000,tax: 55,avg: 100}, 
              {y : 3000,tax: 0,avg: 0}, 
              {y : 80000,tax: 55,avg: 0}, 
              {y : 900,tax: 0,avg: 0}, 
              {y : 0,tax: 0,avg: 0}, 
              {y : 0,tax: 0,avg: 0}, 
              {y : 80000,tax: 0,avg: 0}, 
              {y : 50000,tax: 0,avg: 0 }
            ];
  function saleByYear()
  {
      Highcharts.chart('chart1', {
        chart: {
          type: 'line',
          spacingBottom: 30,
          height: 300

        },
        title: {
          text: null
        },
        xAxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0.5,
          max: 10.5
        },
        yAxis: {
          gridLineColor: '#eaeaea',
          title: {
            text: false
          },
          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          labels: {
            formatter: function() {
              return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
            }
          },
        },
        exporting: {
          enabled: false
        },
        tooltip: {
          formatter: function() {
            return '<b>' + this.series.name + ': "' + this.x + '" </b><br/> <span style="color: #08c08c">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

    	plotOptions: {
          series: {
            marker: {
                  lineWidth: 3,
                  lineColor: '#ffffff',
                  symbol: 'circle'
                }
              }
            },
            series: [{
              lineWidth: 4,
              name: 'Merchant-' + currentYear,
              type: "line",
              color: '#00a6ff',
              // showInLegend: false,
              data: dataSaleByYearVals1
            },
            {
              lineWidth: 4,
              name: 'Merchant-' + lastYear,
              type: "line",
              color: '#1956a6',
              // showInLegend: false,
              data: dataSaleByYearVals2 
            }]
      });
  }
//draw sales chart
  var dataVals1=[
                  {y: 10000,tax: 0,avg: 1000}, 
                  {y: 12000,tax: 0,avg: 100}, 
                  {y: 5000,tax: 0,avg: 200}, 
                  {y: 12000,tax: 0,avg: 300}, 
                  {y: 10000,tax: 0,avg: 400}, 
                  {y: 5000,tax: 0,avg: 500}, 
                  {y: 5000,tax: 0,avg: 200}, 
                  {y: 12000,tax: 0,avg: 300}, 
                  {y: 10000,tax: 0,avg: 400}, 
                  {y: 5000,tax: 0,avg: 500}
              ]
  function salesChart(){

      Highcharts.chart('saleChart', {
        chart: {
          type: 'spline',
          spacingBottom: 30,
          height: 201

        },
        title: {
          text: null
        },
        xAxis: {
          categories: [moment().subtract(9,  "days").format("MMM DD"),moment().subtract(8,  "days").format("MMM DD"),moment().subtract(7,  "days").format("MMM DD"),moment().subtract(6,  "days").format("MMM DD"), moment().subtract(5,  "days").format("MMM DD"), moment().subtract(4,  "days").format("MMM DD"), moment().subtract(3,  "days").format("MMM DD"), moment().subtract(2,  "days").format("MMM DD") ,moment().subtract(1,  "days").format("MMM DD"),moment().format("MMM DD")],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0.5,
          max: 9
        },
        yAxis: {
          gridLineColor: '#eaeaea',
          title: {
            text: false
          },
          labels: {
            style: {
              color: '#9b9b9b'
            }
          },

          // tickInterval: 2000,
          //step: 9000,
          labels: {
            formatter: function() {
              return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
            }
          },
          //min: 5000
        },
        exporting: {
          enabled: false
        },
        tooltip: {
          formatter: function() {
            return '<b>' + this.series.name + ': "' + this.x + '" </b><br/> <span style="color: #08c08c">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

      plotOptions: {
          series: {
                  lineWidth: 4,
            marker: {
                  lineWidth: 3,
                  lineColor: '#ffffff',
                  symbol: 'circle'
                }
              }
            },
            series: [{

              name: 'Sales Chart',
              type: "spline",
              color: '#00a6ff',
              showInLegend: false,
              data: dataVals1
            }]
      });
  }
//draw sales summery chart
  var dataSummeryVals=[
                  {y: 10000,tax: 0,avg: 1000}, 
                  {y: 12000,tax: 0,avg: 100}, 
                  {y: 5000,tax: 0,avg: 200}, 
                  {y: 12000,tax: 0,avg: 300}, 
                  {y: 10000,tax: 0,avg: 400}, 
                  {y: 5000,tax: 0,avg: 500},
                  {y: 12000,tax: 0,avg: 100}, 
                  {y: 5000,tax: 0,avg: 200}, 
                  {y: 12000,tax: 0,avg: 300}, 
                  {y: 10000,tax: 0,avg: 400}, 
                  {y: 5000,tax: 0,avg: 500}
              ]
  function salesSummeryChart(){

      Highcharts.chart('sales_summery', {
        chart: {
          type: 'spline',
          spacingBottom: 30,
          height: 201

        },
        title: {
          text: null
        },
        xAxis: {
          categories: ['Apr 4th', 'Apr 5th','Apr 6th','Apr 7th','Apr 8th','Apr 9th','Apr 10th','Apr 11th','Apr 12th','Apr 13th','Apr 14th'],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0.5
        },
        yAxis: {
          gridLineColor: '#eaeaea',
          title: {
            text: false
          },
          labels: {
            style: {
              color: '#9b9b9b'
            }
          },

          tickInterval: 5000,
          min: 0,
          labels: {
            formatter: function() {
              return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
            }
          },
          //min: 5000
        },
        exporting: {
          enabled: false
        },
        tooltip: {
          formatter: function() {
            return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

      plotOptions: {
          series: {
                  lineWidth: 4,
            marker: {
                  lineWidth: 3,
                  lineColor: '#ffffff',
                  symbol: 'circle'
                }
              }
            },
            series: [{

              name: 'Sales Summery',
              type: "spline",
              color: '#00a6ff',
              showInLegend: false,
              data: dataSummeryVals
            }]
      });
  }
//draw sales Time of Day chart
  var dataTimeDayVals=
    [
      {y: 10000,tax: 0,avg: 1000}, 
      {y: 12000,tax: 0,avg: 100}, 
      {y: 5000,tax: 0,avg: 200}, 
      {y: 12000,tax: 0,avg: 300}, 
      {y: 10000,tax: 0,avg: 400}, 
      {y: 5000,tax: 0,avg: 500},
      {y: 10000,tax: 0,avg: 1000}, 
      {y: 12000,tax: 0,avg: 100}, 
      {y: 5000,tax: 0,avg: 200}, 
      {y: 12000,tax: 0,avg: 300}, 
      {y: 10000,tax: 0,avg: 400},  
      {y: 10000,tax: 0,avg: 400},
      {y: 5000,tax: 0,avg: 500}
    ]
  function salesTimeDayChart(){

      Highcharts.chart('sales_time_of_day', {
        chart: {
          type: 'spline',
          spacingBottom: 30,
          height: 201

        },
        title: {
          text: null
        },
        xAxis: {
          categories: ['04:00 AM', '05:00 AM', '06:00 AM', '07:00 AM', '08:00 AM', '09:00 AM' ,'10:00 AM' ,'11:00 AM' ,'12:00 PM' ,'01:00 PM' ,'02:00 PM' ,'03:00 PM' ,'04:00 PM'],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0.5
        },
        yAxis: {
          gridLineColor: '#eaeaea',
          title: {
            text: false
          },
          labels: {
            style: {
              color: '#9b9b9b'
            }
          },

          tickInterval: 5000,
          min: 0,
          labels: {
            formatter: function() {
              return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
            }
          },
          //min: 5000
        },
        exporting: {
          enabled: false
        },
        tooltip: {
          formatter: function() {
            return '<b>'  + '"' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

      plotOptions: {
          series: {
                  lineWidth: 4,
            marker: {
                  lineWidth: 3,
                  lineColor: '#ffffff',
                  symbol: 'circle'
                }
              }
            },
            series: [{

              name: 'Time of Day',
              type: "spline",
              color: '#00a6ff',
              showInLegend: false,
              data: dataTimeDayVals
            }]
      });
  }
//draw daily Gross Sale chart
  var dailyGrossSaleVals1=
    [
      {y: 10000,tax: 0,avg: 1000}, 
      {y: 12000,tax: 0,avg: 100}, 
      {y: 5000,tax: 0,avg: 200}, 
      {y: 12000,tax: 0,avg: 300}, 
      {y: 10000,tax: 0,avg: 400}, 
      {y: 5000,tax: 0,avg: 500},
      {y: 10000,tax: 0,avg: 1000}, 
      {y: 12000,tax: 0,avg: 100}, 
      {y: 5000,tax: 0,avg: 200}, 
      {y: 12000,tax: 0,avg: 300}, 
      {y: 10000,tax: 0,avg: 400},  
      {y: 10000,tax: 0,avg: 400},
      {y: 5000,tax: 0,avg: 500}
    ]
  var dailyGrossSaleVals2=
    [
      {y: 5000,tax: 0,avg: 1000}, 
      {y: 10000,tax: 0,avg: 100}, 
      {y: 8000,tax: 0,avg: 200}, 
      {y: 10000,tax: 0,avg: 300}, 
      {y: 12000,tax: 0,avg: 400}, 
      {y: 7000,tax: 0,avg: 500},
      {y: 9000,tax: 0,avg: 1000}, 
      {y: 10000,tax: 0,avg: 100}, 
      {y: 8000,tax: 0,avg: 200}, 
      {y: 9000,tax: 0,avg: 300}, 
      {y: 12000,tax: 0,avg: 400},  
      {y: 8000,tax: 0,avg: 400},
      {y: 10000,tax: 0,avg: 500}
    ]
  function dailyGrossSaleChart(){

      Highcharts.chart('dailyGrossSale', {
        chart: {
          type: 'spline',
          spacingBottom: 30,
          height: 201

        },
        title: {
          text: null
        },
        xAxis: {
          categories: ['12:00 AM', '01:00 AM', '02:00 AM', '03:00 AM', '04:00 AM', '05:00 AM' ,'06:00 AM' ,'07:00 AM' ,'08:00 AM' ,'09:00 AM' ,'10:00 AM' ,'11:00 AM' ,'12:00 PM'],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0.5
        },
        yAxis: {
          gridLineColor: '#eaeaea',
          title: {
            text: false
          },
          labels: {
            style: {
              color: '#9b9b9b'
            }
          },

          tickInterval: 5000,
          min: 0,
          labels: {
            formatter: function() {
              return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
            }
          },
          //min: 5000
        },
        exporting: {
          enabled: false
        },
        tooltip: {
          formatter: function() {
            return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

      plotOptions: {
          series: {
                  lineWidth: 4,
            marker: {
                  lineWidth: 3,
                  lineColor: '#ffffff',
                  symbol: 'circle'
                }
              }
            },
            series: [{
              name: 'Daily Gross Sales-'+currentYear,
              type: "spline",
              color: '#00a6ff',
              // showInLegend: false,
              data: dailyGrossSaleVals1
            },{
              name: 'Daily Gross Sales-'+lastYear,
              type: "spline",
              color: '#1956a6',
              // showInLegend: false,
              data: dailyGrossSaleVals2
            }]
      });
  }
//draw weekly Gross Sale chart
  var weeklyGrossSaleVals1=
    [
      {y: 10000,tax: 0,avg: 1000}, 
      {y: 12000,tax: 0,avg: 100}, 
      {y: 5000,tax: 0,avg: 200}, 
      {y: 12000,tax: 0,avg: 300}, 
      {y: 10000,tax: 0,avg: 400}, 
      {y: 5000,tax: 0,avg: 500},
      {y: 10000,tax: 0,avg: 1000}
    ]
  var weeklyGrossSaleVals2=
    [
      {y: 8000,tax: 0,avg: 1000}, 
      {y: 10000,tax: 0,avg: 100}, 
      {y: 4000,tax: 0,avg: 200}, 
      {y: 10000,tax: 0,avg: 300}, 
      {y: 8000,tax: 0,avg: 400}, 
      {y: 4000,tax: 0,avg: 500},
      {y: 8000,tax: 0,avg: 1000}
    ]
  function weeklyGrossSaleChart(){

    Highcharts.chart('weeklyGrossSale', {
        chart: {
          type: 'spline',
          spacingBottom: 30,
          height: 201

        },
        title: {
          text: null
        },
        xAxis: {
          categories: [moment().subtract(6,  "days").format("MMM DD"), moment().subtract(5,  "days").format("MMM DD"), moment().subtract(4,  "days").format("MMM DD"), moment().subtract(3,  "days").format("MMM DD"), moment().subtract(2,  "days").format("MMM DD") ,moment().subtract(1,  "days").format("MMM DD"),moment().format("MMM DD") ],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0.5
        },
        yAxis: {
          gridLineColor: '#eaeaea',
          title: {
            text: false
          },
          labels: {
            style: {
              color: '#9b9b9b'
            }
          },

          tickInterval: 5000,
          min: 0,
          labels: {
            formatter: function() {
              return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
            }
          },
          //min: 5000
        },
        exporting: {
          enabled: false
        },
        tooltip: {
          formatter: function() {
            return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

      plotOptions: {
          series: {
                  lineWidth: 4,
            marker: {
                  lineWidth: 3,
                  lineColor: '#ffffff',
                  symbol: 'circle'
                }
              }
            },
            series: [{
              name: 'Weekly Gross Sales-'+currentYear,
              type: "spline",
              color: '#00a6ff',
              // showInLegend: false,
              data: weeklyGrossSaleVals1
            },{
              name: 'Weekly Gross Sales-'+lastYear,
              type: "spline",
              color: '#1956a6',
              // showInLegend: false,
              data: weeklyGrossSaleVals2
            }]
      });
  }
//draw yearly Gross Sale chart 
  var yearlyGrossSaleVals1=[
              {y: 502.33,tax: 0,avg: 1000}, 
              {y: 154534.65,tax: 0,avg: 100}, 
              {y: 1.41,tax: 0,avg: 200}, 
              {y: 6.14,tax: 0,avg: 300}, 
              {y: 0,tax: 0,avg: 400}, 
              {y: 10000,tax: 0,avg: 500}, 
              {y: 0,tax: 0,avg: 600}, 
              {y: 70000,tax: 0,avg: 700}, 
              {y: 0,tax: 0,avg: 0}, 
              {y: 0,tax: 0,avg: 0}, 
              {y: 50000,tax: 0,avg: 0}, 
              {y: 0,tax: 0,avg: 0}
          ]
  var yearlyGrossSaleVals2=[
              {y: 402.33,tax: 0,avg: 1000}, 
              {y: 124534.65,tax: 0,avg: 100}, 
              {y: 0.8,tax: 0,avg: 200}, 
              {y: 4.14,tax: 0,avg: 300}, 
              {y: 0.5,tax: 0,avg: 400}, 
              {y: 8000,tax: 0,avg: 500}, 
              {y: 0,tax: 0,avg: 600}, 
              {y: 50000,tax: 0,avg: 700}, 
              {y: 0,tax: 0,avg: 0}, 
              {y: 0,tax: 0,avg: 0}, 
              {y: 30000,tax: 0,avg: 0}, 
              {y: 0,tax: 0,avg: 0}
          ]
  function yearlyGrossSaleChart()
  {


      Highcharts.chart('yearlyGrossSale', {
        chart: {
          type: 'line',
          spacingBottom: 30,
          height: 300

        },
        title: {
          text: null
        },
        xAxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0.5
        },
        yAxis: {
          gridLineColor: '#eaeaea',
          title: {
            text: false
          },
          labels: {
            style: {
              color: '#9b9b9b'
            }
          },

          tickInterval: 30000,
          labels: {
            formatter: function() {
              return this.value ;
            }
          },
        },
        exporting: {
          enabled: false
        },
        tooltip: {
           /*  shared: true, */
            // useHTML: true,
            // headerFormat: '<b>{point.key}</b><table>',
            // pointFormat: '<tr><td style="color: #08c08c;"><b>Amount</b></td><td> : $ '+('+{point.y}+').toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td></tr> '+
            //               '<tr><td style="color: #C14242;"><b>Avg Transaction</b></td><td> : $ {point.avg}</td></tr> '+
            //               '<tr><td style="color: #390390;"><b>Tax</b></td><td> : $ {point.tax}</td></tr> ',
            //               // '<tr><td style="color: #C14242;"><b>Avg Transaction</b></td><td>$ {point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td></tr>'+
            //               // '<tr><td style="color: #390390;"><b>Tax</b></td><td>$ {point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td></tr>',
            // footerFormat: '</table>',
            // valueDecimals: 2
/*
'<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> 
<span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + 
'</span>
<br/>
<span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
*/
          formatter: function() {
            return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

      plotOptions: {
          series: {
            marker: {
                  lineWidth: 3,
                  lineColor: '#ffffff',
                  symbol: 'circle'
                }
              }
            },
            series: [{
              lineWidth: 4,
              name: 'Yearly Gross Sales-'+ currentYear,
              type: "line",
              color: '#00a6ff',
              // showInLegend: false,
              data: yearlyGrossSaleVals1
            },{
              lineWidth: 4,
              name: 'Yearly Gross Sales-'+ lastYear,
              type: "line",
              color: '#1956a6',
              // showInLegend: false,
              data: yearlyGrossSaleVals2
            }]
      });
  }
//image uploader
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('.profile-updater  .profile-icon img').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
//added all function readyFns function to iniialize as per need
  function readyFns(){
    //------------------------
    //draw charts
      if($('#chart1').length)
      saleByYear();
      if($('#saleChart').length)
      salesChart();
      if($('#sales_summery').length)
      salesSummeryChart();
      if($('#sales_time_of_day').length)
      salesTimeDayChart();
      if($('#dailyGrossSale').length)
      dailyGrossSaleChart();
      if($('#weeklyGrossSale').length)
      weeklyGrossSaleChart();
      if($('#yearlyGrossSale').length)
      yearlyGrossSaleChart();
    //------------------------
      // $('#invoiceDueDate').datetimepicker();
    //------------------------
    if($('#aa').length)
    {
      $('#aa').circliful();
      $('#bb').circliful();
      $('#cc').circliful();
    }
    //------------------------
    //----datatables --------
      var dtTransactionsConfig={
          "processing": true,
          // "sAjaxSource":"data.php",
          "pagingType": "full_numbers",
          "pageLength": 25,
          "dom": 'lBfrtip', 
          language: {
            search: '', searchPlaceholder: "Search",
            oPaginate: {
               sNext: '<i class="fa fa-angle-right"></i>',
               sPrevious: '<i class="fa fa-angle-left"></i>',
               sFirst: '<i class="fa fa-step-backward"></i>',
               sLast: '<i class="fa fa-step-forward"></i>'
               }
           }   ,
          "buttons": [
            {
              extend: 'collection',
              text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
              buttons: [
              'copy',
              'excel',
              'csv',
              'pdf',
              'print'
              ]
            }
          ]
        }
      var dtConfig1={
        "processing": true,
        "pagingType": "full_numbers",
        "pageLength": 10,
        "dom": 'frtip', 
        language: {
          search: '', searchPlaceholder: "Search",
          oPaginate: {
             sNext: '<i class="fa fa-angle-right"></i>',
             sPrevious: '<i class="fa fa-angle-left"></i>',
             sFirst: '<i class="fa fa-step-backward"></i>',
             sLast: '<i class="fa fa-step-forward"></i>'
             }
         }   
      }
      $('#dt_pos_sale_list').DataTable(dtTransactionsConfig);
      $('#dt_inv_pos_sale_list').DataTable(dtTransactionsConfig);
      $('#dt_view_tax_list').DataTable(dtConfig1);
      $('#dt_all_Emp_list').DataTable(dtConfig1);
      $('#dt_all_users_list').DataTable(dtConfig1);

    //sale chart default date range
      if($('#daterange').length)
        daterangeDefault()
  }

///by default ready fn
  jQuery(function($) {
    //------------------------
    //login register v-center check
      loginRegFget();
    //------------------------
    //draw charts
      if($('#chart1').length)
      saleByYear();
      if($('#saleChart').length)
      salesChart();
      if($('#sales_summery').length)
      salesSummeryChart();
      if($('#sales_time_of_day').length)
      salesTimeDayChart();
      if($('#dailyGrossSale').length)
      dailyGrossSaleChart();
      if($('#weeklyGrossSale').length)
      weeklyGrossSaleChart();
      if($('#yearlyGrossSale').length)
      yearlyGrossSaleChart();
    //------------------------
      $("#invDueDate").val(moment().add(2,'Days').format('DD/MM/YYYY'));//for default date
      $("#invDueDate").datepicker();//claendar to change the date
    //------------------------
    if($('#aa').length)
    {
      $('#aa').circliful();
      $('#bb').circliful();
      $('#cc').circliful();
    }
    //------------------------
    //----datatables --------
     var dtTransactionsConfig={
          "processing": true,
          // "sAjaxSource":"data.php",
          "pagingType": "full_numbers",
          "pageLength": 25,
          "dom": 'lBfrtip', 
          language: {
            search: '', searchPlaceholder: "Search",
            oPaginate: {
               sNext: '<i class="fa fa-angle-right"></i>',
               sPrevious: '<i class="fa fa-angle-left"></i>',
               sFirst: '<i class="fa fa-step-backward"></i>',
               sLast: '<i class="fa fa-step-forward"></i>'
               }
           }   ,
          "buttons": [
            {
              extend: 'collection',
              text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
              buttons: [
              'copy',
              'excel',
              'csv',
              'pdf',
              'print'
              ]
            }
          ]
        }
      var dtConfig1={
        "processing": true,
        "pagingType": "full_numbers",
        "pageLength": 10,
        "dom": 'frtip', 
        language: {
          search: '', searchPlaceholder: "Search",
          oPaginate: {
             sNext: '<i class="fa fa-angle-right"></i>',
             sPrevious: '<i class="fa fa-angle-left"></i>',
             sFirst: '<i class="fa fa-step-backward"></i>',
             sLast: '<i class="fa fa-step-forward"></i>'
             }
         }   
      }
      $('#dt_pos_sale_list').DataTable(dtTransactionsConfig);
      $('#dt_inv_pos_sale_list').DataTable(dtTransactionsConfig);
      $('#dt_view_tax_list').DataTable(dtConfig1);
      $('#dt_all_Emp_list').DataTable(dtConfig1);
      $('#dt_all_users_list').DataTable(dtConfig1);
    //tag iinput
      var emailRegx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;// Email address
      $("#multipleEmailOnly").tagsinput({
        maxTags: 3,
      });
      $('#multipleEmailOnly').on('beforeItemAdd', function(event) {
        if(!emailRegx.test(event.item)){
          event.cancel= true;
        }
      });
    //select 2 -multiple select
      $('#reportEmailTypes').select2();
    //sale chart default date range
      if($('#daterange').length)
        daterangeDefault()
    //wave button
      Waves.init();
      // Waves.attach('#tgl-flat-icon');
      Waves.attach('.float-buttons', ['waves-button']);
      // Waves.attach('.float-icon-light', ['waves-circle', 'waves-float', 'waves-light']);
    //slimScroll
      	sidebarScrollBar=$('.notification-wrapper .notification-body-inner').slimScroll({
            height: 'auto',
            position: 'right',
            size: "5px",
            color: '#98a6ad',
            wheelStep: 5
        });
  })
//window on resize
  $(window)
    .on('resize',function(){
      //login register v-center check
        loginRegFget();
    })
//live events
  $(document)
    .on('focus','.bootstrap-tagsinput input',function(){
      $(this).closest('.form-group').addClass('focused');
    })
    .on('blur','.bootstrap-tagsinput input',function(){
      $(this).closest('.form-group').removeClass('focused');
    })
  	.on('click','#downloadCsvBtn',function() {
      var data = dataVals1;
      console.log(data )
      if (data == '')
        return;
      JSONToCSVConvertor(data, "csv Report", true);
    })
    .on('click','#salesSumeryCsvBtn',function() {
      var data = [dataSummeryVals,dataTimeDayVals];
      console.log(data )
      $.each(data, function( index, value ) {
        if (value == '')
          return;
        JSONToCSVConvertor(value, "csv Report", true);
      })
    })
    .on('click','#salestrendsCsvBtn',function() {
      var data = [dailyGrossSaleVals,weeklyGrossSaleVals,yearlyGrossSaleVals];
      console.log(data )
      $.each(data, function( index, value ) {
        if (value == '')
          return;
        console.log(value)
        JSONToCSVConvertor(value, "csv Report", true);
      })
    })
    .on('change','#saleQuickPfIcon',function(e){
      console.log($(this).val())
      readURL(this);
    })
    .on('click','.profile-updater .upload-btn',function(e){
      $('#saleQuickPfIcon').trigger('click');
    })
    .on('click','.item-adder button',function(e){
      e.preventDefault();
      var $wraper=$(this).closest('.card-detail')
      var newElem=$wraper.find('.all_items_wrapper .custom-form:first-child').clone(true);
      newElem.find('.col').each(function(){
        $(this).find('.form-group:first-child').remove();
      })
      newElem.find('.col:last-child .form-group').append('<span class="remove-invoice-item"> <img src="assets/img/delete.png" alt="del"> </span>');
      $wraper.find('.all_items_wrapper').append(newElem);
    })
    .on('click','.remove-invoice-item',function(e){
      e.preventDefault();
      $(this).closest('.custom-form').slideUp(function(){
        $(this).remove();
      })
    })
  //pos events
    .on('keyup',"#t_amount",function () {
      $("#sub_amount").val($(this).val());
    })
    .on('keydown',"#t_amount",function(e) {     
        //handle backspace key
        if(e.keyCode == 8 && posInput.length > 0) {
           posInput = posInput.slice(0,posInput.length-1); //remove last digit
           $(this).val(formatNumber(posInput));
        }
        else {
           var key = getKeyValue(e.keyCode);
           if(key) {
               posInput += key; //add actual digit to the input string
               $(this).val(formatNumber(posInput)); //format input string and set the input box value to it
           }
        }
        posInputValue=posInput;
        return false;
    })
    .on('click',"#pos-del-btn",function () {
      posInputValue = posInputValue.slice(0,posInputValue.length-1); //remove last digit
      posInput=posInputValue;

      var str = $('#t_amount').val();
      $('#t_amount').val(formatNumberg(posInputValue));
      $('#sub_amount').val(formatNumberg(posInputValue));
    })     
    .on('click',"#pos-add-btn",function () {
      var primaryincome1 = document.getElementById("t_amount").value;
      var otherincome = ($("#amount").val()) ? $("#amount").val() : 0;
      var totaltax1 = ($("#totaltax").val()) ? $("#totaltax").val() : 0;

      var tax1 = ($("#carrent_sales_tax").is(':checked')) ? 1 : 0;
      if(primaryincome1!='')
      {
        primaryincome = primaryincome1;
      }
      else
      {
        primaryincome = '0';
      }
      // ---------------------------------------------------
      //checking for addition of amount
      if(parseFloat($('#t_amount').val()) > 0)
      {
        if(!$('#added-amounts .form-group').length)
        {
          var addAmtField=$("<div class='form-group added-amt-label'><label class='col-md-12 col-form-label'>Added Amount</label></div> <div class='form-group'><div class='col-md-12'><div class='input-group'>  <span class='input-group-addon'><i class='fa fa-usd'></i></span> <input type='text' class='sub_amount form-control' readonly placeholder='0.00'  > </div>  </div></div>");
              addAmtField.find('input').val($("#t_amount").val());
              $("#added-amounts").prepend(addAmtField);
        }
        else
        {
          var addAmtField=$("<div class='form-group'><div class='col-md-12'><div class='input-group'>  <span class='input-group-addon'><i class='fa fa-usd'></i></span> <input type='text' class='sub_amount form-control' readonly placeholder='0.00'  > </div>  </div></div>");
              addAmtField.find('input').val($("#t_amount").val());
              $("#added-amounts .added-amt-label").after(addAmtField);
        }
        $("#t_amount").val('');
        $('#sub_amount').val('');
        $('#added-amounts').scrollTop(0);
        //caluslae tax
        var tax =  parseFloat(tax1) * parseFloat(primaryincome) /100;
        // console.log(tax)
        var total = parseFloat(primaryincome) + parseFloat(tax);

        var totalincome = parseFloat(total) + parseFloat(otherincome);
        var totaltaxVals = parseFloat(tax) + parseFloat(totaltax1);
        // console.log(totaltaxVals)
        $("#amount").val(totalincome.toFixed(2));
        $("#totaltax").val(totaltaxVals.toFixed(2));

        posInputValue='';
        posInput='';
      }
      //-----------------------------------------------------
    })
  //pos data table events
    .on('click','.pos-list-dtable .pos_vw_recept',function(e){
      e.preventDefault();
      $('#view-modal').modal('show');
    })
    .on('click','.pos-list-dtable .invoice_pos_list_item_vw_recept',function(e){
      e.preventDefault();
      $('#view-modal').modal('show');
    })
    .on('click','.pos-list-dtable .invoice_pos_list_item_del',function(e){
      e.preventDefault();
      // $('#view-modal').modal('show');
    })
    .on('click','tbody tr .dt-delete-c-row', function (e) {
      e.preventDefault();
      // add function to delete row
    })
    .on('change','.start_stop_tax input[type="checkbox"]', function (e) {
      // stop - start
      e.preventDefault();
      if($(this).is(':checked')){
        $(this).closest('.start_stop_tax').addClass('active');
      }
      else{
        $(this).closest('.start_stop_tax').removeClass('active');
      }
    })
    .on('click','#paymentCheckoutBtn',function(e){
      $('#paymentCheckout').modal('show');
    })
    .on('click','.toggle-sidebar span',function(){
      $('body').toggleClass('sidebar-active');
    })
    .on('click','.page-wrapper',function(){
      if($(window).width() < 768){
        if($('body').hasClass('sidebar-active')){
          $('body').removeClass('sidebar-active')
        }
      }
    })
   	//stepper form function
   	.on('click','.custom-stepper-form .stepper-back',function(e){
   		var activeStep=$(this).closest('.form-step').data('fstep');
   			prevStep=parseInt(activeStep) - 1;
   		var $wrapper=$(this).closest('.custom-form');
   		if(prevStep > 0){
   			$wrapper.find('.steps-content .form-step').removeClass('active');
   			$wrapper.find('.form-steps .step').removeClass('active');
   			$wrapper.find('.steps-content .form-step').each(function(){
   				if(parseInt($(this).data('fstep')) == prevStep){
   					$(this).addClass('active');
   				}
   			})
   			$wrapper.find('.form-steps .step').each(function(){
   				if(parseInt($(this).data('fstep')) == prevStep){
   					$(this).addClass('active');
   				}
   			})
   		}
   	})
   	.on('click','.custom-stepper-form .stepper-next',function(e){
   		var activeStep=$(this).closest('.form-step').data('fstep');
   			nextStep=parseInt(activeStep) + 1;

   		var $wrapper=$(this).closest('.custom-form');
   		var ttlStep=$wrapper.find('.form-steps .step').length;
   		if(nextStep <= ttlStep){
   			$wrapper.find('.steps-content .form-step').removeClass('active');
   			$wrapper.find('.form-steps .step').removeClass('active');
   			$wrapper.find('.steps-content .form-step').each(function(){
   				if(parseInt($(this).data('fstep')) == nextStep){
   					$(this).addClass('active');
   				}
   			})
   			$wrapper.find('.form-steps .step').each(function(){
   				if(parseInt($(this).data('fstep')) == nextStep){
   					$(this).addClass('active');
   				}
   			})
   		}
   	})
   	.on('click','.custom-stepper-form .stepper-submit',function(e){
   		stepperFormFunction();
   	})
  //load the page without refresh
    // .on('click','#sidebar-menu ul li a',function(e){
    //   e.preventDefault();
    //   console.log($(this).attr('href'))
    //   $("#wrapper").load($(this).attr('href')
    //     , function(response,status,xhr) {
    //          readyFns();
    //   })
    // })