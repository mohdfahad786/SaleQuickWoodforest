//GLOBAL VARIALES
	var aHtml='<div  id="aa" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div>',
			bHtml='<div  id="bb" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div>',
			cHtml='<div  id="cc" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div>',
			posInputValue="", posInput = ""
			lastYear=moment().subtract(1,"Year").format('YYYY'),
			currentYear=moment().format('YYYY'),
			emailRegx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
			sidebarScrollBar='',      
			dtConfigHiddenTable={
				dom: 'B', destroy: true, order: [],
				"buttons": [
					{extend: 'collection',
						text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
						buttons: ['csv','pdf','print'
						]
					}
				]
			};
//convert sale summery json to html table
	function saleSummeryPdfTableConvertor($wraper,jd,totals){
		console.log(totals)
		console.log('run')
		var allRow='',tfoot='',nameCol=false;
		totals=JSON.parse(totals);
		if(parseInt(totals[0]['is_Customer_name'])){
		var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th><th>Discount</th><th>Name</th><th>Items</th></thead><tbody></tbody></table>');
			nameCol=true;
		}
		else{
			var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th><th>Discount</th><th>Items</th></thead><tbody></tbody></table>');

		}
		// console.log(jd)
		// console.log(totals);
		// console.log(typeof jd)
		if(!jd){
			allRow='<tr><td colspan="8" align="center">No data</td></tr>';
		}
		else
		{
			if(typeof jd != 'object')
			jsonData=JSON.parse(jd);
			else
				jsonData=jd;
			jsonData.forEach(function(val, i){
				if(allRow != '')
				{
				 allRow+=
				 '<tr><td>'+val.Amount
				 +'</td><td>'+val.Tax
				 +'</td><td>'+val.Tip
				 +'</td><td>'+val.Type
				 +'</td><td>'+val.Date
				 +'</td><td>'+val.Reference
				 +'</td><td>'+val.Discount
				 + (nameCol? '</td><td>'+val.Name : '')
				 +'</td><td>'+val.Items
				 +'</td></tr>';    
				}
				else 
				{
				 allRow='<tr><td>'+val.Amount+'</td><td>'+val.Tax+'</td><td>'+val.Tip+'</td><td>'+val.Type+'</td><td>'+val.Date+'</td><td>'+val.Reference+'</td><td>'+val.Discount+ (nameCol ? '</td><td>'+val.Name : '')+'</td><td>'+val.Items+'</td></tr>';    
				}

			});
			// if(typeof totals != 'object')
			// jsontData=JSON.parse(totals);
			// else
			//   jsontData=totals;
			// console.log(jsontData[0]);
			// console.log(jsontData[0].Sum_Amount);
			// allRow +=$('<tr><td width="10%">Sum Amount</td><td width="80%" > '+ jsontData[0].Sum_Amount +'</td><td></td><td></td><td></td><td></td><td></td></tr>\
			//          <tr><td width="10%">Refund Amount</td><td width="80%" >'+ jsontData[0].Refund_Amount +' </td><td></td><td></td><td></td><td></td><td></td></tr>\
			//          <tr><td width="10%">Total Amount</td><td width="80%" > '+ jsontData[0].Total_Amount +'</td><td></td><td></td><td></td><td></td><td></td></tr>');
		}
		// dowanloadPdfFn(table);
		// console.log(allRow)
		newTable.find('tbody').html(allRow);
		// newTable.find('tbody').append(tfoot);
		$wraper.html(newTable);
		$wraper.find('table').DataTable(dtConfigHiddenTable);
	}
//sign up leaveFirstGoNextStp 
	function leaveFirstGoNextStp(){
		$('.steps-wrapper .row').removeClass('active');
		$('.steps-wrapper .row.second-step').addClass('active');
		$('.sign-up-form .form-steps').slideDown(300);
		$('.sign-up-form .form-steps .step').removeClass('active');
		$('.sign-up-form .form-steps .step[data-fStep="2"]').addClass('active');
		$('.sign-up-form .form-steps .step[data-fStep="1"] span').html('').addClass('fa fa-check');
		$('.sign-up-form .form-steps .step[data-fStep="1"]').addClass('completed');
	}
	function leave2ndGoNextStp(){
		$('.steps-wrapper .row').removeClass('active');
		$('.steps-wrapper .row.third-step').addClass('active');
		// $('.sign-up-form .form-steps').slideDown(300);
		$('.sign-up-form .form-steps .step').removeClass('active')
		$('.sign-up-form .form-steps .step[data-fStep="3"]').addClass('active')
		$('.sign-up-form .form-steps .step[data-fStep="2"] span').html('').addClass('fa fa-check');
		$('.sign-up-form .form-steps .step[data-fStep="2"]').addClass('completed')
	}
	function leave3rdGoNextStp(){
		$('.steps-wrapper .row').removeClass('active');
		$('.steps-wrapper .row.fourth-step').addClass('active');
		// $('.sign-up-form .form-steps').slideDown(300);
		$('.sign-up-form .form-steps .step').removeClass('active');
		$('.sign-up-form .form-steps .step[data-fStep="4"]').addClass('active');
		$('.sign-up-form .form-steps .step[data-fStep="3"] span').html('').addClass('fa fa-check');
		$('.sign-up-form .form-steps .step[data-fStep="3"]').addClass('completed');
	}
//imggraph-update sale-renge-graph
	// function saleChartFn(a, b,hgt) {
	// 		// console.log(a) for graph id
	// 		// console.log(b) //for graph data
	// 		if(typeof b =='undefined'){
	// 			console.log(b);
	// 			return;
	// 		}
	// 	var c = {//config
	// 					global: {
	// 							useUTC: !1
	// 					},
	// 					chart: {
	// 							type: 'spline',
	// 							height: (hgt? hgt : 201),
	// 							renderTo: "graph",
	// 							marginTop: 0,
	// 							// marginBottom: 40,
	// 							borderRadius: 0,
	// 							backgroundColor: "#ffffff"
	// 					},
	// 					title: {
	// 							text: null
	// 					},
	// 					colors: ["#fff", "#00a6ff",'#fff'],
	// 					credits: {
	// 							enabled: !1
	// 					},
	// 					legend: {
	// 							enabled: !1
	// 					},
	// 					plotOptions: {
	// 							area: {
	// 											lineWidth: 4,
	// 											fillOpacity: .1,
	// 											marker: {
	// 												lineColor: "#fff",
	// 												lineWidth: 3,
	// 												symbol: 'circle'
	// 											},
	// 											shadow: !1
	// 										},
	// 							spline: {
	// 												lineWidth: 4,
	// 												marker: {
	// 													lineWidth: 3,
	// 													lineColor: '#ffffff',
	// 													symbol: 'circle'
	// 												}
	// 											},
	// 						column: {
	// 										lineWidth: 16,
	// 										shadow: !1,
	// 										borderWidth: 0,
	// 										groupPadding: .05
	// 									}
	// 					},
	// 					xAxis: {
	// 							type: "datetime",
	// 							title: {
	// 									text: null
	// 							},
	// 							tickmarkPlacement: "off",
	// 							dateTimeLabelFormats: {
	// 									day: "%b %e"
	// 							},
	// 							gridLineColor: "#eaeaea",
	// 							gridLineWidth: 0,
	// 							labels: {
	// 									style: {
	// 											color: "#9b9b9b"
	// 									}
	// 							}
	// 					},
	// 					yAxis: [ {
	// 						showFirstLabel: !1,
	// 						showLastLabel: !1,
	// 						tickPixelInterval: 50,
	// 						endOnTick: !1,
	// 						title: {
	// 							text: null
	// 						},
	// 						opposite: !0,
	// 						gridLineColor: "#eaeaea",
	// 						gridLineWidth: .5,
	// 						zIndex: -1,
	// 						labels: {
	// 							align: "left",
	// 							style: {
	// 								color: "#fff"
	// 							},
	// 							x: 4
	// 						}
	// 					},
	// 					{
	// 						showFirstLabel: !1,
	// 						showLastLabel: !1,
	// 						tickPixelInterval: 50,
	// 						endOnTick: !1,
	// 						title: {
	// 							text: null
	// 						},
	// 						gridLineColor: "#eaeaea",
	// 						gridLineWidth: .5,
	// 						zIndex: 2,
	// 						labels: {
	// 							align: "right",
	// 							style: {
	// 								color: "#9b9b9b"
	// 							},
	// 							x: -4
	// 						}
	// 					}
	// 					],
	// 					tooltip: {
	// 							shadow: !1,
	// 							borderRadius: 3,
	// 							shared: !0,
	// 									formatter: function(a) {
	// var b = parseInt(this.points[0].y) == this.points[0].y ? this.points[0].y : this.points[0].y.toFixed(2),
	// 		b =isNaN(b)?0:(b!=''?b:0),
	// // console.log(this),
	// 	c = (this.points[1] != undefined) ? (parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2)): 0,
	// 	fee = (this.points[2] != undefined) ? parseInt(this.points[2].y) == this.points[2].y ? this.points[2].y : this.points[2].y.toFixed(2) : 0,
	// 	d = '<span ><b>' + moment(this.x).format("dddd, MMM D, YYYY") + "</b></span>",
	// 	e = '<span style="color: #390390">' + a.chart.series[0].name + ":</span> <b> $" + parseFloat(b).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + "</b>",
	// 	f = '<span style="color: #08c08c">' + a.chart.series[1].name + ":</span> <b> $" + parseFloat(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") 
	// 	+ "</b> <br/>" + '<span style="color: #C14242">' + "Avg Transaction  :" + '<b> $' + parseFloat(fee).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
	// 	 + '</b>' + '</span>';
	// 											return d + " <br /> " + f + " <br /> " + e
	// 										//  return d + " <br /> "  + f
	// 							}
	// 					},
	// 					series: [{
	// 							type: "spline"
	// 					}, {
	// 							type: "spline",
	// 							yAxis: 1
	// 					}, {
	// 							type: "spline",
	// 							yAxis: 1
	// 					}]
	// 			};
	// 	// config end here


	// 			if ($('select[name="graph_metric1"]').length > 0) var d = $('select[name="graph_metric1"]').val(),
	// 					e = $('select[name="graph_metric1"]').select2("data")[0].text,
	// 					f = $('select[name="graph_metric2"]').val(),
	// 					g = $('select[name="graph_metric2"]').select2("data")[0].text;
	// 		else d = "tax", e = "Tax", f = "amount", g = "Amount";
	// 			// else  f = "conversions", g = "Amount";
	// 			var h = [],
	// 					i = [],
	// 					j = [];
	// 			fee=[];
	// 			for (var k in b)
	// 					if (b[k].convrate = 0 == b[k].amount ? 0 : (b[k].tax / b[k].amount * 100).toFixed(2), b[k].cpa = 0 == b[k].tax ? 
	// 							0 : b[k].cost / b[k].conversions, b[k].cpc = 0 == b[k].clicks ? 0 : b[k].cost / b[k].clicks, b[k].rpp = 0 == b[k].people ? 0
	// 							 : b[k].revenue / b[k].people, b[k].profit = b[k].revenue - b[k].cost, null != b[k].date && 0 != b[k].date.length) 
	// 					{
	// 							var l = parseFloat(b[k][d]);
	// 							h.push([moment(b[k].date).valueOf(), l]);
	// 							var l = parseFloat(b[k][f]);
	// 							i.push([moment(b[k].date).valueOf(), l])
	// 							var l = parseFloat(b[k].cost);
	// 							fee.push([moment(b[k].date).valueOf(), l])
	// 					} 
	// 					else j = b[k];

	// 			0 == j.length && b[0] && (j = b[0]), c.series[0].name = e, c.series[0].data = h, c.series[0].pointStart = h[0][0].valueOf(), 
	// 			c.series[1].name = g, c.series[1].data = i, c.series[1].pointStart = i[0][0].valueOf(), c.series[2].name = "Fee", c.series[2].data = fee, c.series[2].pointStart = i[0][0].valueOf(), $("#" + a + " .placeholder")
	// 			.length > 0 ? c.chart.renderTo = $("#" + a + " .placeholder")[0] : c.chart.renderTo = $("#" + a)[0];
	// 			var m, n;
	// 			m = "cost" == d || "cpa" == d || "cpc" == d || "revenue" == d || "rpp" == d || "profit" == d ? format_money(j[d]) :
	// 			 "convrate" == d ? format_rate(j[d] / 100) : add_commas(j[d]), n = "cost" == f || "cpa" == f || "cpc" == f || "revenue" == f ||
	// 				"rpp" == f || "profit" == f ? format_money(j[f]) : "convrate" == f ? format_rate(j[f] / 100) : add_commas(j[f]),
	// 				 $(".metric1 h1").html(m), $(".metric1 h2").html(e), $(".metric2 h1").html(n), $(".metric2 h2").html(g),
	// 					graph = new Highcharts.Chart(c)
	// 					// , 
	// 					// graphData = b
	// 					// ,
	// 					// console.log(c);
	// 	}
//set transaction default date range
	function setTransactionDefDate(){
		if($("#allSAndBoxPay_daterange").length){
			$("#allSAndBoxPay_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
			$("#allSAndBoxPay_daterange input[name='start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
			$("#allSAndBoxPay_daterange input[name='end_date']").val( moment().format("YYYY-MM-DD"));
		}
		if($("#pos_list_daterange").length){
			$("#pos_list_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
			$("#pos_list_daterange input[name='start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
			$("#pos_list_daterange input[name='end_date']").val( moment().format("YYYY-MM-DD"));
		}
		if($("#inv_pos_list_daterange").length){
			$("#inv_pos_list_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
			$("#inv_pos_list_daterange input[name='start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
			$("#inv_pos_list_daterange input[name='end_date']").val( moment().format("YYYY-MM-DD"));
		}
		if($("#transaction_recurring_daterange").length){
			$("#transaction_recurring_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
			$("#transaction_recurring_daterange input[name='curr_payment_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
			$("#transaction_recurring_daterange input[name='end']").val( moment().format("YYYY-MM-DD"));
		}
		if($("#all_pos_refund_daterange").length){
			$("#all_pos_refund_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
			$("#all_pos_refund_daterange input[name='start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
			$("#all_pos_refund_daterange input[name='end_date']").val( moment().format("YYYY-MM-DD"));
		}
		if($("#all_customer_refund_daterange").length){
			$("#all_customer_refund_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
			$("#all_customer_refund_daterange input[name='start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
			$("#all_customer_refund_daterange input[name='end_date']").val( moment().format("YYYY-MM-DD"));
		}
	}
//page load
	function ensureActiveLinkAfterPageLoad(){
		// $("#sidebar-menu a").each(function() {
		// 		//remove hash from url
		// 				var locP=window.location.href;
		// 				var locPL=locP.length;
		// 				var hashI=parseInt(locP.lastIndexOf('#')) + 1;
		// 				if(locPL == hashI){
		// 						locP=locP.replace(/.$/, "");
		// 				}
		// 		//check to add class
		// 		if (this.href == locP) {
		// 				$(this).addClass("active");
		// 				$(this).parent().addClass("active"); // add active to li of the current link
		// 				$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
		// 				$(this).parent().parent().parent().parent().prev().click();
		// 				$(this).parent().parent().prev().click(); // click the item to make it drop
		// 		}
		// });
	}
//side menu
	// function toggleSideMenus($this){
	// 	if (!$this.hasClass("subdrop")) {
	// 			// hide any open menus and remove all other classes
	// 			$("ul", $this.parents("ul:first")).stop().slideUp(350);
	// 			$("a", $this.parents("ul:first")).removeClass("subdrop");
	// 			$("#sidebar-menu .pull-right i").removeClass("md-remove").addClass("md-add");

	// 			// open our new menu and add the open class
	// 			$this.next("ul").stop().slideDown(350);
	// 			$this.addClass("subdrop");
	// 			// $(".pull-right i", $this.parents(".has_sub:last")).removeClass("md-add").addClass("md-remove");
	// 			// $(".pull-right i", $this.siblings("ul")).removeClass("md-remove").addClass("md-add");
	// 	} else if ($this.hasClass("subdrop")) {
	// 			$this.removeClass("subdrop");
	// 			$this.next("ul").stop().slideUp(350);
	// 			// $(".pull-right i", $this.parent()).removeClass("md-remove").addClass("md-add");
	// 	}

	// }
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
						
//golbale fn - input validation 
	function validatePosForm() {
			var x = document.forms["pos_form"]["amount"].value;
			console.log(x)
			if (x == "") {
					alert("Amount must be filled out");
					return false;
			}
	}
	function getSelectionStart(o) {
		if (o.createTextRange) {
				var r = document.selection.createRange().duplicate();
				r.moveEnd('character', o.value.length);
				if (r.text == '') return o.value.length
				return o.value.lastIndexOf(r.text)
		} else return o.selectionStart;
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
	function isNumberKeyOnedc(el,evt,len)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		var newVal= el.value;
		var len=isNaN(len)? 2 : len;
		// console.log(newVal)
		if ((charCode != 46 && charCode > 31) 
			&& (charCode < 48 || charCode > 57)){
			 return false;
			}
		if(charCode == 46 && newVal.indexOf('.') != -1){
			 return false;
		 }
		if(newVal.indexOf('.') != -1)
		{
			var numArr=newVal.split('.');
			var caratPos = getSelectionStart(el);
			var dotPos = newVal.indexOf(".");
			if( caratPos > dotPos && dotPos>-1 && (numArr[1].length > 1)){
					return false;
			}
		}
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
	function signUpStepFirst($wrapper) {
		var phone = /[0-9]/;// Email address
		var trueFalse = 1;
		$wrapper.find('.form-control[required]').each(function() {
			var txtVal=$(this).val();
			// console.log(txtVal)
			//check empty
			if(!txtVal.length) {
				// console.log('run')
				$(this).closest('.form-group').addClass('mandatory');
				$(this).focus();
				trueFalse=0;
				return false;
			}
			//check if email
			if($(this).hasClass('email')) {
				if(!emailRegx.test(txtVal)) {
					$(this).closest('.form-group').addClass('incorrect');
					$(this).focus();
					trueFalse=0;
					return false;
				}
			}
			//check if email
			if($(this).hasClass('phone')) {
				if(!phone.test(txtVal)) {
					$(this).closest('.form-group').addClass('incorrect');
					$(this).focus();
					trueFalse=0;
					return false;
				}
			}
			//check if password
			if($(this).hasClass('p2')) {
				var p1=$wrapper.find('.password.p1').val();
				var p2=$wrapper.find('.password.p2').val();
				if(p1 != p2) {
					$(this).focus();
					$(this).closest('.form-group').addClass('not-match');
					console.log('false');
					trueFalse=0;
					return false;
				} else {
					console.log('matched')
					$(this).closest('.form-group').removeClass('not-match');
				}
			}
		})
		return trueFalse;
	}

	function signUpStepSecond($wrapper){
		var trueFalse= 1;
		$wrapper.find('.form-control[required]').each(function(){
				var txtVal=$(this).val();
				//check empty
					if(!txtVal.length)
					{
						// console.log('run')
						$(this).closest('.form-group').addClass('mandatory');
						$(this).focus();
						trueFalse=0;
						return false;
					}
				//check if email
					if($(this).hasClass('email'))
					{
						if(!emailRegx.test(txtVal))
						{
							$(this).closest('.form-group').addClass('incorrect');
							$(this).focus();
							trueFalse=0;
							return false;
						}
					}
				//check if email
					if($(this).hasClass('us-routing-c'))
					{
						if(txtVal != $('.us-routing').val().trim())
						{
							$(this).closest('.form-group').addClass('not-match');
							$(this).focus();
							trueFalse=0;
							return false;
						}
					}
				//check if email
					if($(this).hasClass('us-acc-no-c'))
					{
						if(txtVal != $('.us-acc-no').val().trim())
						{
							$(this).closest('.form-group').addClass('not-match');
							$(this).focus();
							trueFalse=0;
							return false;
						}
					}
		})
		return trueFalse;
	}
	function signUpStepThird($wrapper){
		var trueFalse= 1;
		$wrapper.find('.form-control[required]').each(function(){
			// console.log($(this));
			var txtVal=$(this).val();
			//check empty
			if(!txtVal.length)
			{
				// console.log('run')
				$(this).closest('.form-group').addClass('mandatory');
				$(this).focus();
				trueFalse=0;
				return false;
			}
			//check if email
			if($(this).hasClass('email'))
			{
				if(!emailRegx.test(txtVal))
				{
					$(this).closest('.form-group').addClass('incorrect');
					$(this).focus();
					trueFalse=0;
					return false;
				}
			}
		})
		return trueFalse;
	}
	function signUpStepFourth($wrapper){
		var trueFalse= 1;
		$wrapper.find('.form-control[required]').each(function(){
				var txtVal=$(this).val();
				//check empty
					if(!txtVal.length)
					{
						// console.log('run')
						$(this).closest('.form-group').addClass('mandatory');
						$(this).focus();
						trueFalse=0;
						return false;
					}
					//check if email
						if($(this).hasClass('email'))
						{
							if(!emailRegx.test(txtVal))
							{
								$(this).closest('.form-group').addClass('incorrect');
								$(this).focus();
								trueFalse=0;
								return false;
							}
						}
					if($(this).hasClass('acc2'))
					{
						var p1=$wrapper.find('.form-control.acc1').val();
						var p2=$wrapper.find('.form-control.acc2').val();
						if(p1 != p2)
						{
							$(this).focus();
							$(this).closest('.form-group').addClass('not-match');
							console.log('false');
							trueFalse=0;
							return false;
						}
						else{
							console.log('matched')
							$(this).closest('.form-group').removeClass('not-match');
						}
					}
				//check if routing
					if($(this).hasClass('us-routing-c'))
					{
						if(txtVal != $('.us-routing').val().trim())
						{
							$(this).closest('.form-group').addClass('not-match');
							$(this).focus();
							trueFalse=0;
							return false;
						}
					}
				//check if acc-no
					if($(this).hasClass('us-acc-no-c'))
					{
						if(txtVal != $('.us-acc-no').val().trim())
						{
							$(this).closest('.form-group').addClass('not-match');
							$(this).focus();
							trueFalse=0;
							return false;
						}
					}
		})
		return trueFalse;
	}
//invoicing recurring calculation
	function calculateTaxAmount($this){
		var $wrapper=$this.closest('.all_items_wrapper');
		var taxAmt=0,ttlAmtTax=0;
		
		var other_charges_type = $("#other_charges_type").val();
    var other_charges_value = parseFloat($("#other_charges_value").val());
    
		var ttlTaxWtTax=$wrapper.find('.item_tax[name="Tax_Amount[]"]').map(function(){
									 var newVal=this.value;
											 newVal=isNaN(newVal)? 0: (newVal != ''? newVal : 0);
											 taxAmt+=parseFloat(newVal);
									 return newVal;
								}).get();
		var ttlAmtWtTax=$wrapper.find('.sub_total[name="Total_Amount[]"]').map(function(){
									 var newVal=this.value;
											 newVal=isNaN(newVal)? 0: (newVal != ''? newVal : 0);
											 ttlAmtTax+=parseFloat(newVal);
									 return newVal;
								}).get();
								
								if(other_charges_type=='$'){
           var otherCharges = parseFloat(other_charges_value);
                }
                else if(other_charges_type=='%'){
                    var subTotal = (ttlAmtTax - taxAmt).toFixed(2);
                     var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                     
           
                }
// 		$('#sub_amount').val((ttlAmtTax - taxAmt).toFixed(2));
// 		$('#total_tax').val(taxAmt.toFixed(2));
// 		$('#amount').val(ttlAmtTax.toFixed(2));
		
		$('#sub_amount').val((ttlAmtTax - taxAmt).toFixed(2));
	if(other_charges_value > 0){	
     $('#other_charges').val(otherCharges.toFixed(2));
     $('#amount').val((ttlAmtTax + otherCharges).toFixed(2));
	}
	else
	{
	 $('#other_charges').val(0);
    // $('#amount').val(ttlAmtTax);
     $("#amount").val(ttlAmtTax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}
     
    $('#total_tax').val(taxAmt.toFixed(2));
    
    
		// console.log('calculateTaxAmount');
	}
	function calcTaxAmt($this){
		var $row=$this.closest('.custom-form');
		var tax = $row.find('.sel_item_tax option:selected').attr('rel');
		var qty =  $row.find('.item_qty').val();
		var amount =  $row.find('.item_price').val();
		tax=isNaN(tax)? 0: (tax != ''? tax : 0);
		qty=isNaN(qty)? 1: (qty != ''? qty : 1);
		amount=isNaN(amount)? 0: (amount != ''? amount : 0);

		var totalAmt = (qty*amount);

		var taxAmt = (tax*totalAmt)/100;
		taxAmt=isNaN(taxAmt)? 0: (taxAmt != ''? taxAmt : 0);

		var totalWtTx =  parseFloat(taxAmt) + parseFloat(totalAmt);
		$row.find('.sub_total').val(totalWtTx.toFixed(2));
		$row.find('.item_tax').val(taxAmt);
		$row.find('.hide_tax').val(tax);
		calculateTaxAmount($this)
	}

	//pos tax calculation
    function calc_tax() {
        var tax_value = ($("#tax_value").val()) ? $("#tax_value").val() : 0;
        var amount = ($("#amount").val()) ? $("#amount").val() : 0;
        var main_amount = ($("#main_amount").val()) ? $("#main_amount").val() : 0;
        
        var subTotal = parseFloat(main_amount) ;
        var calc_tax_val = parseFloat(subTotal * (tax_value / 100));
        calc_tax_val = parseFloat(calc_tax_val.toFixed(2));
        // console.log(calc_tax_val);
        if(calc_tax_val == 0) {
            $('.tax_section').addClass('d-none');
        } else {
            $('.tax_section').removeClass('d-none');
        }
    }
    
    //pos ocharges calculation
    function calc_ocharges() {
        var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
        var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
        var amount = ($("#amount").val()) ? $("#amount").val() : 0;
        var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
        if(orignal_amount!='') {
            amount = orignal_amount;   
        } else {
            amount = amount;
        }
        
        if(other_charges_type=='$'){
            var otherCharges = parseFloat(other_charges_value);
        } else if(other_charges_type=='%'){
            var subTotal = parseFloat(amount) ;
            var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
        }
        calc_otherCharges = parseFloat(otherCharges.toFixed(2));
        console.log(calc_otherCharges);
        if(calc_otherCharges == 0) {
            $('.ocharges_section').addClass('d-none');
        } else {
            $('.ocharges_section').removeClass('d-none');
        }
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
		//document.getElementById("t_amount").value = formatNumberg(posInputValue);
		document.getElementById("t_amount").value = formatNumberg(posInputValue);
		$('#t_amount').number(true, 2 );
			
		//	var z = document.getElementById("sub_amount");
		//	z.value = formatNumberg(posInputValue);
        document.getElementById("amount").value = formatNumberg(posInputValue);
        document.getElementById("orignal_amount").value = formatNumberg(posInputValue);
        document.getElementById("main_amount").value = formatNumberg(posInputValue);

        calc_tax();
        calc_ocharges();
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
	// function saleByYear(dataSaleByYearVals1,dataSaleByYearVals2)
	// {
	// 	// console.log(dataSaleByYearVals1)
	// 	// console.log(dataSaleByYearVals2)
	// 		Highcharts.chart('chart1', {
	// 			chart: {
	// 				type: 'line',
	// 				spacingBottom: 30,
	// 				height: 300

	// 			},
	// 			title: {
	// 				text: null
	// 			},
	// 			xAxis: {
	// 				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},
	// 				min: 0.5,
	// 				max: 10.5
	// 			},
	// 			yAxis: {
	// 				gridLineColor: '#eaeaea',
	// 				title: {
	// 					text: false
	// 				},
	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},
	// 				labels: {
	// 					formatter: function() {
	// 						return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
	// 					}
	// 				},
	// 			},
	// 			exporting: {
	// 				enabled: false
	// 			},
	// 			tooltip: {
	// 				formatter: function() {
	// 					return '<b>' + this.series.name + ': "' + this.x + '" </b><br/> <span style="color: #08c08c">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
	// 				}
	// 			},
	// 			credits: {
	// 				enabled: false
	// 			},

	// 		plotOptions: {
	// 				series: {
	// 					marker: {
	// 								lineWidth: 3,
	// 								lineColor: '#ffffff',
	// 								symbol: 'circle'
	// 							}
	// 						}
	// 					},
	// 					series: [{
	// 						lineWidth: 4,
	// 						name: 'Merchant-' + currentYear,
	// 						type: "line",
	// 						color: '#00a6ff',
	// 						// showInLegend: false,
	// 						data: dataSaleByYearVals1
	// 					},
	// 					{
	// 						lineWidth: 4,
	// 						name: 'Merchant-' + lastYear,
	// 						type: "line",
	// 						color: '#1956a6',
	// 						// showInLegend: false,
	// 						data: dataSaleByYearVals2 
	// 					}]
	// 		});
	// }
//sale chart default range
	function daterangeDefault(){
		$("#daterange span").data({'d1':moment().subtract(10, 'days').format("YYYY-MM-DD") ,'d2' : moment().format("YYYY-MM-DD")})
		$('#daterange span').html(moment().subtract(10, 'days').format('MMMM D, YYYY') +' - '+moment().format('MMMM D, YYYY'));
	}
//draw sales chart
	function salesChart(dataVals1){
			var dataVals=[],dataVals2=[
									{y: 10000,tax: 0,avg: 1000}, 
									{y: 12000,tax: 0,avg: 100}, 
									{y: 5000,tax: 0,avg: 200}, 
									{y: 12000,tax: 0,avg: 300}, 
									{y: 10000,tax: 0,avg: 400}, 
									{y: 5000,tax: 0,avg: 500}, 
									{y: 5000,tax: 0,avg: 200}, 
									{y: 12000,tax: 0,avg: 300}, 
									{y: 10000,tax: 0,avg: 400}, 
									{y: 5000,tax: 0,avg: 500}];
			
		var allDate=[];
		console.log(typeof dataVals1)
		dataVals1=JSON.stringify(dataVals1);
		// dataVals2=JSON.parse(dataVals1);
		//   console.log(typeof dataVals1)
		//   console.log(dataVals2)
			console.log(dataVals1)
			// console.log(dataVals1.length)
			// console.log(typeof dataVals1)
		$.each(dataVals1,function(index, value){
			// dataVals[index][y].push(value.)
			allDate.push(value.Date);
		})
		// allDate.sort(function(a,b){
		//   return new Date(a.date) - new Date(b.date);
		// });
		// console.log(allDate)

		var Xlabel=[moment().subtract(9,  "days").format("MMM DD"),moment().subtract(8,  "days").format("MMM DD"),moment().subtract(7,  "days").format("MMM DD"),moment().subtract(6,  "days").format("MMM DD"), moment().subtract(5,  "days").format("MMM DD"), moment().subtract(4,  "days").format("MMM DD"), moment().subtract(3,  "days").format("MMM DD"), moment().subtract(2,  "days").format("MMM DD") ,moment().subtract(1,  "days").format("MMM DD"),moment().format("MMM DD")];

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
					// minRange: allDate[0],
					// maxRange: allDate[allDate.length - 1],
					// categories: Xlabel,
					// labels: {
					//   style: {
					//     color: '#9b9b9b'
					//   }
					// },
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
					labels: {
						formatter: function() {
							return ((this.value/1000) > 1 ? ((this.value/1000) + 'k') : (this.value));
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
									marker: 
									{
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
// dashboard sale order chart updation fn
	// function updateSaleOrderChart(a,b,c){

	// 	var ab=$('#circularOrderCharts >div:nth-child(1) .order-chart-text');
	// 	var bb=$('#circularOrderCharts >div:nth-child(2) .order-chart-text');
	// 	var cb=$('#circularOrderCharts >div:nth-child(3) .order-chart-text');
	// 	$('#aa').remove();
	// 	$('#bb').remove();
	// 	$('#cc').remove();
	// 	var t1=isNaN(parseFloat(a)) ? 0: (isNaN(parseFloat(a)) == null ? 0: parseFloat(a));
	// 	var t2=isNaN(parseFloat(b)) ? 0: (isNaN(parseFloat(b)) == null ? 0: parseFloat(b));
	// 	var t3=isNaN(parseFloat(c)) ? 0: (isNaN(parseFloat(c)) == null ? 0: parseFloat(c));

	// 	var total_amount =  parseFloat(t1 + t2 + t3) ;

	// 	ab.find('.oc-no').html(t1);
	// 	bb.find('.oc-no').html(t2);
	// 	cb.find('.oc-no').html(t3);

	// 	var p1=(t1==0)?0:parseFloat((t1 / total_amount)*100);
	// 	var p2=(t2==0)?0:parseFloat((t2 / total_amount)*100);
	// 	var p3=(t3==0)?0:parseFloat((t3 / total_amount)*100);
	// 	// console.log(p1)
	// 	// console.log(p2)
	// 	// console.log(p3)
	// 	// console.log(total_amount)
	// 	ab.before($(aHtml).circliful({ percent: p1 }));
	// 	bb.before($(bHtml).circliful({ percent: p2 }));
	// 	cb.before($(cHtml).circliful({ percent: p3 }));

	// }
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
	// var dataTimeDayVals=
	//   [
	//     {y: 10000,tax: 0,avg: 1000}, 
	//     {y: 12000,tax: 0,avg: 100}, 
	//     {y: 5000,tax: 0,avg: 200}, 
	//     {y: 12000,tax: 0,avg: 300}, 
	//     {y: 10000,tax: 0,avg: 400}, 
	//     {y: 5000,tax: 0,avg: 500},
	//     {y: 10000,tax: 0,avg: 1000}, 
	//     {y: 12000,tax: 0,avg: 100}, 
	//     {y: 5000,tax: 0,avg: 200}, 
	//     {y: 12000,tax: 0,avg: 300}, 
	//     {y: 10000,tax: 0,avg: 400},  
	//     {y: 10000,tax: 0,avg: 400},
	//     {y: 5000,tax: 0,avg: 500}
	//   ]
	function salesTimeDayChart(dataTimeDayVals){
		// if($(window).width() >= 3000) {
		// 	var chart_width = 3687;
		// } else if ($(window).width() <= 2999 && $(window).width() >= 2500) {
  //           // var chart_width = 1663;
  //           var chart_width = 2338;
  //     	} else if ($(window).width() <= 2499 && $(window).width() >= 2000) {
  //     	// if ($(window).width() >= 2000) {
  //           var chart_width = 1663;
  //       } else if ($(window).width() <= 1999 && $(window).width() >= 1700) {
  //           var chart_width = 1438;
  //       } else if ($(window).width() <= 1699 && $(window).width() >= 1550) {
  //           var chart_width = 1326;
  //       } else if ($(window).width() <= 1549 && $(window).width() >= 1401) {
  //           var chart_width = 1138;
  //       } else if ($(window).width() <= 1400 && $(window).width() >= 1341) {
  //           var chart_width = 1009;
  //       } else if ($(window).width() <= 1340 && $(window).width() >= 1150) {
  //           var chart_width = 886;
  //       } else if ($(window).width() <= 1149 && $(window).width() >= 950) {
  //           var chart_width = 739;
  //       } else if ($(window).width() <= 949 && $(window).width() >= 850) {
  //           var chart_width = 838;
  //       } else if ($(window).width() <= 849 && $(window).width() >= 750) {
  //           var chart_width = 708;
  //       } else if ($(window).width() <= 749 && $(window).width() >= 600) {
  //           var chart_width = 611;
  //       } else if ($(window).width() <= 599 && $(window).width() >= 460) {
  //           var chart_width = 474;
  //       } else if ($(window).width() <= 459) {
  //           var chart_width = 413;
  //       }
      // console.log(dataTimeDayVals);
      Highcharts.chart('sales_time_of_day', {
        chart: {
          type: 'areaspline',
          spacingBottom: 30
          // width: chart_width

        },
        title: {
          text: null
        },
        xAxis: {
          categories: ['00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00', '12:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00'],

          labels: {
            style: {
              color: '#9b9b9b'
            }
          },
          min: 0
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
              return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
            }
          },
          //min: 5000
        },
        exporting: {
          enabled: false
        },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 4000
                },
                chartOptions: {
                    yAxis: {
                        labels: {
                            align: 'center'
                        }
                    }
                }
            }]
        },
        tooltip: {
          backgroundColor: '#fff',
          borderRadius: 10,
          formatter: function() {
            return '<b>' + this.x + '</b><br/>' + '<span style="color: #868e96">Amount' + ':</span> <span style="color:#FDAC42;font-weight:600;">$' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #868e96">' + 'Avg Transaction:</span> <span style="color:#AC5DD9;font-weight:600;">$' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #868e96">Tax:</span> <span style="color:#D0021B;font-weight:600;">$' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
          }
        },
        credits: {
          enabled: false
        },

        plotOptions: {
          // series: {
          //   lineWidth: 4,
          //   marker: {
          //     lineWidth: 3,
          //     lineColor: '#ffffff',
          //     symbol: 'circle'
          //   }
          // }
          areaspline: {
            fillOpacity: 0.1,
            marker: {
              fillColor: "#fff",
              lineWidth: 2,
              lineColor: null,
              // lineWidth: 3,
              symbol: 'circle'
            },
          }
        },
            series: [{
              // name: 'Time of Day',
              type: "areaspline",
              // color: '#00a6ff',
              showInLegend: false,
              data: dataTimeDayVals
            }]
      });
  }
//draw daily Gross Sale chart
	// var dailyGrossSaleVals1=
	//   [
	//     {y: 10000,tax: 0,avg: 1000}, 
	//     {y: 12000,tax: 0,avg: 100}, 
	//     {y: 5000,tax: 0,avg: 200}, 
	//     {y: 12000,tax: 0,avg: 300}, 
	//     {y: 10000,tax: 0,avg: 400}, 
	//     {y: 5000,tax: 0,avg: 500},
	//     {y: 10000,tax: 0,avg: 1000}, 
	//     {y: 12000,tax: 0,avg: 100}, 
	//     {y: 5000,tax: 0,avg: 200}, 
	//     {y: 12000,tax: 0,avg: 300}, 
	//     {y: 10000,tax: 0,avg: 400},  
	//     {y: 10000,tax: 0,avg: 400},
	//     {y: 5000,tax: 0,avg: 500}
	//   ]
	// var dailyGrossSaleVals2=
	//   [
	//     {y: 5000,tax: 0,avg: 1000}, 
	//     {y: 10000,tax: 0,avg: 100}, 
	//     {y: 8000,tax: 0,avg: 200}, 
	//     {y: 10000,tax: 0,avg: 300}, 
	//     {y: 12000,tax: 0,avg: 400}, 
	//     {y: 7000,tax: 0,avg: 500},
	//     {y: 9000,tax: 0,avg: 1000}, 
	//     {y: 10000,tax: 0,avg: 100}, 
	//     {y: 8000,tax: 0,avg: 200}, 
	//     {y: 9000,tax: 0,avg: 300}, 
	//     {y: 12000,tax: 0,avg: 400},  
	//     {y: 8000,tax: 0,avg: 400},
	//     {y: 10000,tax: 0,avg: 500}
	//   ]
	// function dailyGrossSaleChart(val1,val2){

	// 		Highcharts.chart('dailyGrossSale', {
	// 			chart: {
	// 				type: 'spline',
	// 				spacingBottom: 30,
	// 				height: 201

	// 			},
	// 			title: {
	// 				text: null
	// 			},
	// 			xAxis: {
	// 				categories: ['12:00 AM','01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM', '12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM'],

	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},
	// 				min: 0
	// 			},
	// 			yAxis: {
	// 				gridLineColor: '#eaeaea',
	// 				title: {
	// 					text: false
	// 				},
	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},

	// 				// tickInterval: 5000,
	// 				min: 0,
	// 				labels: {
	// 					formatter: function() {
	// 						return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
	// 					}
	// 				},
	// 				//min: 5000
	// 			},
	// 			exporting: {
	// 				enabled: false
	// 			},
	// 			tooltip: {
	// 				formatter: function() {
	// 					return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
	// 				}
	// 			},
	// 			credits: {
	// 				enabled: false
	// 			},

	// 		plotOptions: {
	// 				series: {
	// 								lineWidth: 4,
	// 					marker: {
	// 								lineWidth: 3,
	// 								lineColor: '#ffffff',
	// 								symbol: 'circle'
	// 							}
	// 						}
	// 					},
	// 					series: [{
	// 						name: 'Gross Sales- Today',
	// 						type: "spline",
	// 						color: '#00a6ff',
	// 						// showInLegend: false,
	// 						data: val1
	// 					},{
	// 						name: 'Gross Sales- Yesterday',
	// 						type: "spline",
	// 						color: '#1956a6',
	// 						// showInLegend: false,
	// 						data: val2
	// 					}]
	// 		});
	// }
//draw weekly Gross Sale chart
	// var weeklyGrossSaleVals1=
	//   [
	//     {y: 10000,tax: 0,avg: 1000}, 
	//     {y: 12000,tax: 0,avg: 100}, 
	//     {y: 5000,tax: 0,avg: 200}, 
	//     {y: 12000,tax: 0,avg: 300}, 
	//     {y: 10000,tax: 0,avg: 400}, 
	//     {y: 5000,tax: 0,avg: 500},
	//     {y: 10000,tax: 0,avg: 1000}
	//   ];
	// var weeklyGrossSaleVals2=
	//   [
	//     {y: 8000,tax: 0,avg: 1000}, 
	//     {y: 10000,tax: 0,avg: 100}, 
	//     {y: 4000,tax: 0,avg: 200}, 
	//     {y: 10000,tax: 0,avg: 300}, 
	//     {y: 8000,tax: 0,avg: 400}, 
	//     {y: 4000,tax: 0,avg: 500},
	//     {y: 8000,tax: 0,avg: 1000}
	//   ];
	// function weeklyGrossSaleChart(val1,val2){

	// 	Highcharts.chart('weeklyGrossSale', {
	// 			chart: {
	// 				type: 'spline',
	// 				spacingBottom: 30,
	// 				height: 201

	// 			},
	// 			title: {
	// 				text: null
	// 			},
	// 			xAxis: {
	// 				categories: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],

	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},
	// 				min: 0
	// 			},
	// 			yAxis: {
	// 				gridLineColor: '#eaeaea',
	// 				title: {
	// 					text: false
	// 				},
	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},

	// 				// tickInterval: 5000,
	// 				min: 0,
	// 				labels: {
	// 					formatter: function() {
	// 						return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
	// 					}
	// 				},
	// 				//min: 5000
	// 			},
	// 			exporting: {
	// 				enabled: false
	// 			},
	// 			tooltip: {
	// 				formatter: function() {
	// 					return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
	// 				}
	// 			},
	// 			credits: {
	// 				enabled: false
	// 			},

	// 		plotOptions: {
	// 				series: {
	// 								lineWidth: 4,
	// 					marker: {
	// 								lineWidth: 3,
	// 								lineColor: '#ffffff',
	// 								symbol: 'circle'
	// 							}
	// 						}
	// 					},
	// 					series: [{
	// 						name: 'Current Week',
	// 						type: "spline",
	// 						color: '#00a6ff',
	// 						// showInLegend: false,
	// 						data: val1
	// 					},{
	// 						name: 'Last Week',
	// 						type: "spline",
	// 						color: '#1956a6',
	// 						// showInLegend: false,
	// 						data: val2
	// 					}]
	// 		});
	// }
//draw yearly Gross Sale chart 
	// var yearlyGrossSaleVals1=[
	//             {y: 502.33,tax: 0,avg: 1000}, 
	//             {y: 154534.65,tax: 0,avg: 100}, 
	//             {y: 1.41,tax: 0,avg: 200}, 
	//             {y: 6.14,tax: 0,avg: 300}, 
	//             {y: 0,tax: 0,avg: 400}, 
	//             {y: 10000,tax: 0,avg: 500}, 
	//             {y: 0,tax: 0,avg: 600}, 
	//             {y: 70000,tax: 0,avg: 700}, 
	//             {y: 0,tax: 0,avg: 0}, 
	//             {y: 0,tax: 0,avg: 0}, 
	//             {y: 50000,tax: 0,avg: 0}, 
	//             {y: 0,tax: 0,avg: 0}
	//         ]
	// var yearlyGrossSaleVals2=[
	//             {y: 402.33,tax: 0,avg: 1000}, 
	//             {y: 124534.65,tax: 0,avg: 100}, 
	//             {y: 0.8,tax: 0,avg: 200}, 
	//             {y: 4.14,tax: 0,avg: 300}, 
	//             {y: 0.5,tax: 0,avg: 400}, 
	//             {y: 8000,tax: 0,avg: 500}, 
	//             {y: 0,tax: 0,avg: 600}, 
	//             {y: 50000,tax: 0,avg: 700}, 
	//             {y: 0,tax: 0,avg: 0}, 
	//             {y: 0,tax: 0,avg: 0}, 
	//             {y: 30000,tax: 0,avg: 0}, 
	//             {y: 0,tax: 0,avg: 0}
	//         ]
	// function yearlyGrossSaleChart(val1,val2)
	// {


	// 		Highcharts.chart('yearlyGrossSale', {
	// 			chart: {
	// 				type: 'line',
	// 				spacingBottom: 30,
	// 				height: 300

	// 			},
	// 			title: {
	// 				text: null
	// 			},
	// 			xAxis: {
	// 				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},
	// 				min: 0
	// 			},
	// 			yAxis: {
	// 				gridLineColor: '#eaeaea',
	// 				title: {
	// 					text: false
	// 				},
	// 				labels: {
	// 					style: {
	// 						color: '#9b9b9b'
	// 					}
	// 				},

	// 				// tickInterval: 30000,
	// 				labels: {
	// 					formatter: function() {
	// 						return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
	// 					}
	// 				},
	// 			},
	// 			exporting: {
	// 				enabled: false
	// 			},
	// 			tooltip: {
	// 				 /*  shared: true, */
	// 					// useHTML: true,
	// 					// headerFormat: '<b>{point.key}</b><table>',
	// 					// pointFormat: '<tr><td style="color: #08c08c;"><b>Amount</b></td><td> : $ '+('+{point.y}+').toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td></tr> '+
	// 					//               '<tr><td style="color: #C14242;"><b>Avg Transaction</b></td><td> : $ {point.avg}</td></tr> '+
	// 					//               '<tr><td style="color: #390390;"><b>Tax</b></td><td> : $ {point.tax}</td></tr> ',
	// 					//               // '<tr><td style="color: #C14242;"><b>Avg Transaction</b></td><td>$ {point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td></tr>'+
	// 					//               // '<tr><td style="color: #390390;"><b>Tax</b></td><td>$ {point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td></tr>',
	// 					// footerFormat: '</table>',
	// 					// valueDecimals: 2
	// 				/*
	// 				'<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> 
	// 				<span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + 
	// 				'</span>
	// 				<br/>
	// 				<span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
	// 				*/
	// 				formatter: function() {
	// 					return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
	// 				}
	// 			},
	// 			credits: {
	// 				enabled: false
	// 			},

	// 		plotOptions: {
	// 				series: {
	// 					marker: {
	// 								lineWidth: 3,
	// 								lineColor: '#ffffff',
	// 								symbol: 'circle'
	// 							}
	// 						}
	// 					},
	// 					series: [{
	// 						lineWidth: 4,
	// 						name: 'Yearly Gross Sales-'+ currentYear,
	// 						type: "line",
	// 						color: '#00a6ff',
	// 						// showInLegend: false,
	// 						data: val1
	// 					},{
	// 						lineWidth: 4,
	// 						name: 'Yearly Gross Sales-'+ lastYear,
	// 						type: "line",
	// 						color: '#1956a6',
	// 						// showInLegend: false,
	// 						data: val2
	// 					}]
	// 		});
	// }
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
///by default ready fn
	jQuery(function($) {
		$('.us-phone-no').mask("(999) 999-9999");
		//------------------------
		//-highlight active link
			ensureActiveLinkAfterPageLoad();
		//activate dashboard page
		// hash = location.hash;
		// console.log('hash',hash)
		// if(hash) {
		//   $('#sidebar-menu >ul').find(`a[data-hash=${hash}]`).trigger('click');
		// } else {
			// $('#sidebar-menu >ul>li:first-child>ul>li:first-child a').trigger('click');
		// }
		//login register v-center check
			loginRegFget();
		//tag input
		if( $("#multipleEmailOnly").length)
		{
				$("#multipleEmailOnly").tagsinput({
					maxTags: 3,
				});
				$('#multipleEmailOnly').on('beforeItemAdd', function(event) {
					if(!emailRegx.test(event.item)){
						event.cancel= true;
					}
				});
		}

		if( $("#multipleNotificationEmailOnly").length)
		{
				$("#multipleNotificationEmailOnly").tagsinput({
					//maxTags: 3,
				});
				$('#multipleNotificationEmailOnly').on('beforeItemAdd', function(event) {
					if(!emailRegx.test(event.item)){
						event.cancel= true;
					}
				});
		}


		//colopicker
			if ($('#styleInput').length) {
					jscolor.installByClassName("jscolor");
			}
		//------------------------
		//draw charts
			// if($('#chart1').length)
			// saleByYear();
			// if($('#saleChart').length)
			//   setTimeout(function(){
			//     updateSaleOrderChart($('#saleChart').data('vals'),$('#aa').data('vals'),$('#bb').data('vals'),$('#cc').data('vals'));
			//     // console.log($('#saleChart').data('vals')+$('#aa').data('vals')+$('#bb').data('vals')+$('#cc').data('vals'));
			//   },300)
			// salesChart();
			// if($('#sales_summery').length)
			// salesSummeryChart();
			// if($('#sales_time_of_day').length)
			// salesTimeDayChart();
			// if($('#dailyGrossSale').length)
			// dailyGrossSaleChart();
			// if($('#weeklyGrossSale').length)
			// weeklyGrossSaleChart();
			// if($('#yearlyGrossSale').length)
			// yearlyGrossSaleChart();
		//------------------------
		if($("#invDueDate").length){
				$("#invDueDate").val(moment().add(2,'Days').format('DD/MM/YYYY'));//for default date
				$("#invDueDate").datepicker();//claendar to change the date
			 }
		//------------------------
		// if($('#aa').length)
		// {
		//   $('#aa').circliful();
		//   $('#bb').circliful();
		//   $('#cc').circliful();
		// }
		//------------------------
		//----datatables --------
		 var dtTransactionsConfig={
					"processing": true,
					// "sAjaxSource":"data.php",
					"pagingType": "full_numbers",
					"pageLength": 25,
					"dom": 'lBfrtip', 
					 "order": [],
					"destroy": true,
					responsive: true,
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
		 var dtConfigOrderSort={
					"processing": true,
					// "sAjaxSource":"data.php",
					"pagingType": "full_numbers",
					"pageLength": 25,
					//"dom": 'lBfrtip',
					"order": [], 
					// "ordering": true,
					// "order": [[ 5, "desc" ]],
					"destroy": true,
					responsive: true,
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
				
				var dtConfigOrderSort_Report_e={
               "processing": true,
          // "sAjaxSource":"data.php",
          "pagingType": "full_numbers",
          "pageLength": 25,
          "dom": 'lBfrtip', 
          "order": [],
          // "ordering": true,
          // "order": [[ 7, "desc" ]],
          "destroy": true,
          responsive: true,
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
		 var dtConfigOrderSort2={
					"processing": true,
					// "sAjaxSource":"data.php",
					"pagingType": "full_numbers",
					"pageLength": 25,
					"dom": 'lBfrtip', 
					"order": [],
					// "ordering": true,
					// "order": [[ 7, "desc" ]],
					"destroy": true,
					responsive: true,
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
				"destroy": true,
				responsive: true,
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
			if($('#dt_pos_sale_list').length)
			$('#dt_pos_sale_list').DataTable(dtConfigOrderSort);
			
			if($('#dt_pos_sale_list_e').length)
            $('#dt_pos_sale_list_e').DataTable(dtConfigOrderSort_Report_e);

// 			if($('#dt_inv_pos_sale_list').length)
// 			$('#dt_inv_pos_sale_list').DataTable(dtConfigOrderSort2);

			if($('#transaction_recurring_dt').length)
			$('#transaction_recurring_dt').DataTable(dtConfigOrderSort);

			if($('#all_pos_refund_dt').length)
			$('#all_pos_refund_dt').DataTable(dtTransactionsConfig);

			if($('#all_customer_refund_dt').length)
			$('#all_customer_refund_dt').DataTable(dtTransactionsConfig);

			if($('#allSandboxPay-dt').length)
			$('#allSandboxPay-dt').DataTable(dtTransactionsConfig);

			if($('#dt_view_tax_list').length)
			$('#dt_view_tax_list').DataTable(dtConfig1);

			if($('#dt_all_Emp_list').length)
			$('#dt_all_Emp_list').DataTable(dtConfig1);

			if($('#dt_all_users_list').length)
			$('#dt_all_users_list').DataTable(dtConfig1);

		//tag iinput
			// var emailRegx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;// Email address
			// $('#multipleEmailOnly').on('beforeItemAdd', function(event) {
			//   if(!emailRegx.test(event.item)){
			//     event.cancel= true;
			//   }
			// });
		//select 2 -multiple select
		if($('#reportEmailTypes').length)
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
			$('.slimscrollleft').slimScroll({
					height: 'auto',
					position: 'right',
					size: "5px",
					color: '#98a6ad',
					wheelStep: 5
			});
		//phone mask
			if($("#signUpphone").length)
				$("#signUpphone").mask("(999) 999-9999");
			// if($("#social_scurity_no").length)
			// $("#social_scurity_no").mask("999-99-9999");
		//date picker
			if($('.sign-up-form .reg-dob').length){
					// $('.sign-up-form .reg-dob').val(moment().format("YYYY-MM-DD"));
					$('.sign-up-form .reg-dob').daterangepicker({
							singleDatePicker: true,
							showDropdowns: true,
							periods: ['day','month','year'],
							locale: {format: "YYYY-MM-DD"}
							}, function(start, end, label) {
					});
			}
		//signup
			if($("#phone").length)
				{
					$("#phone").mask("(999) 999-9999");
					$("#phone").on("blur", function() {
							var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );
							if( last.length == 5 ) {
									var move = $(this).val().substr( $(this).val().indexOf("-") + 1, 1 );
									var lastfour = last.substr(1,4);
									var first = $(this).val().substr( 0, 9 );
									$(this).val( first + move + '-' + lastfour );
							}
					});
				}
				
					if($("#s_phone").length)
				{
					$("#s_phone").mask("(999) 999-9999");
					$("#s_phone").on("blur", function() {
							var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );
							if( last.length == 5 ) {
									var move = $(this).val().substr( $(this).val().indexOf("-") + 1, 1 );
									var lastfour = last.substr(1,4);
									var first = $(this).val().substr( 0, 9 );
									$(this).val( first + move + '-' + lastfour );
							}
					});
				}
		//date picker
			if($('#invoiceDueDatePicker').length){
					$("#invoiceDueDatePicker").val(moment().add(2,'Days').format("YYYY-MM-DD"));
					$('#invoiceDueDatePicker').daterangepicker({
							singleDatePicker: true,
							showDropdowns: true,
							locale: {format: "YYYY-MM-DD"}
							}, function(start, end, label) {
					});
			}
		//date - range
		// setTransactionDefDate();
			if($('#allSAndBoxPay_daterange').length){
				var allSAndBoxPay_daterange_config = {
					ranges: {
							Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
							"Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
							"This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
					},opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
					startDate: (($("#allSAndBoxPay_daterange input[name='start_date']").val().length > 0) ? ($("#allSAndBoxPay_daterange input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
						endDate: (($("#allSAndBoxPay_daterange input[name='end_date']").val().length > 0) ? ($("#allSAndBoxPay_daterange input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
				};
				// console.log(allSAndBoxPay_daterange_config)
				$('#allSAndBoxPay_daterange').daterangepicker(allSAndBoxPay_daterange_config, function(a, b) 
					{
							$("#allSAndBoxPay_daterange input[name='start_date']").val( a.format("YYYY-MM-DD"));
							$("#allSAndBoxPay_daterange input[name='end_date']").val( b.format("YYYY-MM-DD"));
							$("#allSAndBoxPay_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
							// setTransactionDefDate($("#allSAndBoxPay_daterange span").data().d1,$("#allSAndBoxPay_daterange span").data().d2);
					});
			}
			if($('#pos_list_daterange').length){
				var pos_list_daterange_config = {
					ranges: {
							Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
							"Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
							"This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
					},opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
					startDate: (($("#pos_list_daterange input[name='start_date']").val().length > 0) ? ($("#pos_list_daterange input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
						endDate: (($("#pos_list_daterange input[name='end_date']").val().length > 0) ? ($("#pos_list_daterange input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
				};
				// console.log(pos_list_daterange_config)
				$('#pos_list_daterange').daterangepicker(pos_list_daterange_config, function(a, b) 
					{
							$("#pos_list_daterange input[name='start_date']").val( a.format("YYYY-MM-DD"));
							$("#pos_list_daterange input[name='end_date']").val( b.format("YYYY-MM-DD"));
							$("#pos_list_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
							// setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
					});
			}
			if($('#inv_pos_list_daterange').length){
				var inv_pos_list_daterange_config = {
					ranges: {
							Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
							"Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
							"This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
					},opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
					startDate: (($("#inv_pos_list_daterange input[name='start_date']").val().length > 0) ? ($("#inv_pos_list_daterange input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
						endDate: (($("#inv_pos_list_daterange input[name='end_date']").val().length > 0) ? ($("#inv_pos_list_daterange input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
				};
				// console.log(inv_pos_list_daterange_config)
				$('#inv_pos_list_daterange').daterangepicker(inv_pos_list_daterange_config, function(a, b) 
					{
							$("#inv_pos_list_daterange input[name='start_date']").val( a.format("YYYY-MM-DD"));
							$("#inv_pos_list_daterange input[name='end_date']").val( b.format("YYYY-MM-DD"));
							$("#inv_pos_list_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
							// setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
					});
			}
			if($('#transaction_recurring_daterange').length){
				var transaction_recurring_daterange_config = {
					ranges: {
							Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
							"Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
							"This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
					},opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
					startDate: (($("#transaction_recurring_daterange input[name='curr_payment_date']").val().length > 0) ? ($("#transaction_recurring_daterange input[name='curr_payment_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
						endDate: (($("#transaction_recurring_daterange input[name='end']").val().length > 0) ? ($("#transaction_recurring_daterange input[name='end']").val()) : moment().format("YYYY-MM-DD"))
				};
				// console.log(transaction_recurring_daterange_config)
				$('#transaction_recurring_daterange').daterangepicker(transaction_recurring_daterange_config, function(a, b) 
					{
							$("#transaction_recurring_daterange input[name='curr_payment_date']").val( a.format("YYYY-MM-DD"));
							$("#transaction_recurring_daterange input[name='end']").val( b.format("YYYY-MM-DD"));
							$("#transaction_recurring_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
							// setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
					});
			}
			if($('#all_pos_refund_daterange').length){
				var all_pos_refund_daterange_config = {
					ranges: {
							Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
							"Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
							"This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
					},opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
					startDate: (($("#all_pos_refund_daterange input[name='start_date']").val().length > 0) ? ($("#all_pos_refund_daterange input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
						endDate: (($("#all_pos_refund_daterange input[name='end_date']").val().length > 0) ? ($("#all_pos_refund_daterange input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
				};
				// console.log(all_pos_refund_daterange_config)
				$('#all_pos_refund_daterange').daterangepicker(all_pos_refund_daterange_config, function(a, b) 
					{
							$("#all_pos_refund_daterange input[name='start_date']").val( a.format("YYYY-MM-DD"));
							$("#all_pos_refund_daterange input[name='end_date']").val( b.format("YYYY-MM-DD"));
							$("#all_pos_refund_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
							// setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
					});
			}
			if($('#all_customer_refund_daterange').length){
				var all_customer_refund_daterange_config = {
					ranges: {
							Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
							"Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
							"This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
					},opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
					startDate: (($("#all_customer_refund_daterange input[name='start_date']").val().length > 0) ? ($("#all_customer_refund_daterange input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
						endDate: (($("#all_customer_refund_daterange input[name='end_date']").val().length > 0) ? ($("#all_customer_refund_daterange input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
				};
				// console.log(all_customer_refund_daterange_config)
				$('#all_customer_refund_daterange').daterangepicker(all_customer_refund_daterange_config, function(a, b) 
					{
							$("#all_customer_refund_daterange input[name='start_date']").val( a.format("YYYY-MM-DD"));
							$("#all_customer_refund_daterange input[name='end_date']").val( b.format("YYYY-MM-DD"));
							$("#all_customer_refund_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
							// setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
					});
			}
		if($('#daterange').length)
			daterangeInitializerFn();
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
			var data = $('#saleChart').data('vals');
			console.log(data)
			if (data == '')
				return;
			JSONToCSVConvertor(data, "csv Report", true);
		})
		.on('keydown','#social_scurity_no',function(event) {
			var ttlV=$(this).val();
			if ( event.keyCode != 46 && event.keyCode != 8 ) 
				{
					if(ttlV)
					{
						var ttlL=ttlV.length;
						if(ttlL == 3)
						{
							$(this).val(ttlV + '-');
						}
						else if(ttlL == 6)
						{
							$(this).val(ttlV + '-');
						}
					}
				}
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything

				}
				else {
						if($(this).val().length >= 11){
							return false;
						}
						// Ensure that it is a number and stop the keypress
						if (event.keyCode < 48 || event.keyCode > 57 ) {
								event.preventDefault(); 
						}   
				}
		})
		.on('click','#salesSumeryCsvBtn',function() {
			var data = $('#txt').val();
				if(data == '')
						return;
				JSONToCSVConvertor(data, "csv Report", true);
			
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
		.on('change','.card-detail .sel_item_tax',function(e){
			calcTaxAmt($(this))
		})
		.on('keyup blur','.card-detail .item_qty,.card-detail .item_price',function(e){
			calcTaxAmt($(this))
		})
		.on('click','.new-item-adder button',function(e){
			e.preventDefault();
			var $wraper=$(this).closest('.card-detail');
			var $itemLength=parseInt($(this).closest('.card-detail').find('.all_items_wrapper .custom-form').length) + 1;
			console.log($itemLength)
			var newElem=$wraper.find('.all_items_wrapper .custom-form:first-child').clone(true);
			newElem.find('.col').each(function(){
				$(this).find('.form-group:first-child').remove();
			})
			newElem.find('.item_row:last-child').append('<span class="remove-invoice-item" title="Remove This Row"> <img src="https://salequick.com/new_assets/img/delete.png" alt="del"> </span>');
			newElem.find('.item_name').attr('id','item_name_'+$itemLength).val('');
			newElem.find('.item_qty').attr('id','quantity_'+$itemLength).val(1);
			newElem.find('.item_price').attr('id','price_'+$itemLength).val(0);;
			newElem.find('.sel_item_tax').attr('id','tax_'+$itemLength).prop('selectedIndex',0);
			newElem.find('.item_tax').attr('id','tax_amount_'+$itemLength).val(0);;
			newElem.find('.hide_tax').attr('id','tax_per_'+$itemLength).val(0);;
			newElem.find('.sub_total').attr('id','total_amount_'+$itemLength).val('');;
			// newElem.find('.hide_tax').attr('id','tax_per_'+$itemLength);

			$wraper.find('.all_items_wrapper').append(newElem);
		})
		.on('click','.remove-invoice-item',function(e){
			e.preventDefault();
			$(this).closest('.custom-form').slideUp(function(){
				$(this).find('.item_qty').val(0);
				$(this).find('.item_price').val(0);
				$(this).find('.sel_item_tax').prop('selectedIndex',0);
				calcTaxAmt($(this));
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

			$('#amount').val(formatNumberg(posInputValue));
			$('#orignal_amount').val(formatNumberg(posInputValue));
			$('#main_amount').val(formatNumberg(posInputValue));

			calc_tax();
            calc_ocharges();
		})     
		// .on('click',"#pos-add-btn",function () {
		// 	var primaryincome1 = document.getElementById("t_amount").value;
		// 	var otherincome = ($("#amount").val()) ? $("#amount").val() : 0;
		// 	var totaltax1 = ($("#totaltax").val()) ? $("#totaltax").val() : 0;

		// 	var tax1 = ($("#carrent_sales_tax").is(':checked')) ? parseFloat($("#carrent_sales_tax").data('tax')) : 0;
		// 	if(primaryincome1!='')
		// 	{
		// 		primaryincome = primaryincome1;
		// 	}
		// 	else
		// 	{
		// 		primaryincome = '0';
		// 	}
		// 	// ---------------------------------------------------
		// 	//checking for addition of amount
		// 	if(parseFloat($('#t_amount').val()) > 0)
		// 	{
		// 		var all_amt = $('.all_item_amounts').text();
		//         // console.log(aa.trim());
		//         if(all_amt.trim() == '0') {
		//           $('.all_item_amounts').text($("#t_amount").val());
		//         } else {
		//           var amountFieldText = $('.all_item_amounts').text();
		//           var addedAmount = $("#t_amount").val();
		          
		//           if(amountFieldText.trim() == '') {
		//             $('.all_item_amounts').text(addedAmount);
		//           } else {
		//             $('.all_item_amounts').text(amountFieldText+' + '+addedAmount);
		//           }
		//         }
		// 		// if(!$('#added-amounts .form-group').length)
		// 		// {
		// 		// 	var addAmtField=$("<div class='form-group added-amt-label'><label class='col-md-12 col-form-label'>Added Amount</label></div> <div class='form-group'><div class='col-md-12'><div class='input-group'>  <span class='input-group-addon'><i class='fa fa-usd'></i></span> <input type='text' class='sub_amount form-control' readonly placeholder='0.00'  > </div>  </div></div>");
		// 		// 			addAmtField.find('input').val($("#t_amount").val());
		// 		// 			$("#added-amounts").prepend(addAmtField);
		// 		// }
		// 		// else
		// 		// {
		// 		// 	var addAmtField=$("<div class='form-group'><div class='col-md-12'><div class='input-group'>  <span class='input-group-addon'><i class='fa fa-usd'></i></span> <input type='text' class='sub_amount form-control' readonly placeholder='0.00'  > </div>  </div></div>");
		// 		// 			addAmtField.find('input').val($("#t_amount").val());
		// 		// 			$("#added-amounts .added-amt-label").after(addAmtField);
		// 		// }
		// 		$("#t_amount").val('');
		// 		$('#sub_amount').val('');
		// 		$('#added-amounts').scrollTop(0);
		// 		//caluslae tax
		// 		var tax =  parseFloat(tax1) * parseFloat(primaryincome) /100;
		// 		// console.log(tax)
		// 		var total = parseFloat(primaryincome) + parseFloat(tax);

		// 		var totalincome = parseFloat(total) + parseFloat(otherincome);
		// 		var totaltaxVals = parseFloat(tax) + parseFloat(totaltax1);
		// 		// console.log(totaltaxVals)
		// 		$("#amount").val(totalincome.toFixed(2));
		// 		$("#totaltax").val(totaltaxVals.toFixed(2));

		// 		posInputValue='';
		// 		posInput='';
		// 	}
		// 	//-----------------------------------------------------
		// })
	//pos data table events
		.on('click','.pos-list-dtable .pos_vw_recept',function(e){
			e.preventDefault();
			$('#view-modal').modal('show');
		})
		// .on('click','.pos-list-dtable .invoice_pos_list_item_vw_recept',function(e){
		//   e.preventDefault();
		//   $('#view-modal').modal('show');
		// })
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
		.on('click','.toggle-sidebar span',function(e){
			e.stopPropagation();
			$('body').toggleClass('sidebar-active');
		})
		.on('click','.page-wrapper',function(){
			if($(window).width() <= 1024){
				if($('body').hasClass('sidebar-active')){
					$('body').removeClass('sidebar-active')
				}
			}
		})
		.on('click','.topbar,#sidebar-menu a:not([href="#"])',function(){
			if($(window).width() <= 1024){
				if($('body').hasClass('sidebar-active')){
					$('body').removeClass('sidebar-active')
				}
			}
		})
		//stepper form function
		.on('click','.custom-stepper-form .first-step .stepper-submit',function(e){
			var $wrapper=$(this).closest('.first-step');
			// console.log(signUpStepFirst($wrapper));
			if(signUpStepFirst($wrapper)) {
				// console.log('1');return false;
				//call ajax &  submit step first
				var mSignupStepF={};
				// mSignupStepF.f_name=$wrapper.find('.form-control[name="mbname"]').val();
				mSignupStepF.email=$wrapper.find('.form-control[name="memail"]').val();
				// mSignupStepF.mobile=$wrapper.find('.form-control[name="mphone"]').val();
				mSignupStepF.password=$wrapper.find('.form-control[name="mpass"]').val();
				mSignupStepF.mconfpass=$wrapper.find('.form-control[name="mconfpass"]').val();
				// console.log(mSignupStepF)
				// var dataString = 'name='+ name + '&email=' + email + '&phone=' + phone;
				//alert (dataString);return false;
				$(this).find('span').addClass('fa fa-spinner fa-spin');
				mSignupStep1Fn(mSignupStepF);

			} else {
				//stay at first
			}
			//completed first step
		})
		.on('click','.custom-stepper-form .second-step .next-step',function(e){
			var $wrapper=$(this).closest('.second-step');
			// console.log(signUpStepSecond($wrapper));
			if(signUpStepSecond($wrapper))
			{
				//call ajax &  submit step first
				//go to third step
				var mSignupStepS={};
				$('.custom-stepper-form .second-step input,.custom-stepper-form .second-step select').each(function(){
				var newval=$(this).val();
				if($(this).hasClass('us-phone-no')){
				newval=newval.replace(/[\(\)-\s]/g,'');
				}
				mSignupStepS[$(this).attr('name')]= newval;
				})
				$(this).find('span').addClass('fa fa-spinner fa-spin');
				mSignupStep2Fn(mSignupStepS);
				// leave2ndGoNextStp();
			}
			else{
				//stay at first
			}
			//completed first step
		})
		// .on('click','.custom-stepper-form .third-step .next-step',function(e){
		// 	var $wrapper=$(this).closest('.third-step');
		// 	// console.log(signUpStepthird($wrapper));
		// 	if(signUpStepThird($wrapper))
		// 	{
		// 		//call ajax &  submit step first
		// 		// console.log()
		// 		//go to fourth step
		// 		var mSignupStepTh={};
		// 		$('.custom-stepper-form .third-step input,.custom-stepper-form .third-step select').each(function(){
		// 			var newval=$(this).val();
		// 					if($(this).hasClass('us-phone-no')){
		// 						newval=newval.replace(/[\(\)-\s]/g,'');
		// 					}
		// 					else if($(this).hasClass('us-ssn-no-enc')){
		// 						newval=$(this).data('val');
		// 					}
		// 			mSignupStepTh[$(this).attr('name')]= newval;
		// 		})
		// 		$(this).find('span').addClass('fa fa-spinner fa-spin');

		// 		mSignupStep3Fn(mSignupStepTh);
		// 		// leave3rdGoNextStp();
		// 	}
		// 	else{
		// 		//stay at first
		// 	}
		// 	//completed first step
		// })
		.on('click','.custom-stepper-form .third-step .next-step',function(e){
			// var $wrapper=$(this).closest('.third-step');
			var $wrapper=$(this).closest('.third-step').children('.busi_owner_inputs').children('.pointer');
			// console.log($wrapper);return false;
			// var mSignupStepTh = [];
			 // console.log(signUpStepthird($wrapper));
			if(signUpStepThird($wrapper)) {
				// alert('hello1');
				//call ajax &  submit step first
				// console.log()
				//go to fourth step
				var mSignupStepTh={};
				var ownerArr = [];
				var checkIndexCount = 0;
				$('.custom-stepper-form .third-step .first_busi_owner_section').each(function() {
					// console.log($(this).length);
					if( checkIndexCount == 0 ) {
						$(this).find('input, select').each(function(){
							var newval=$(this).val();
							if($(this).hasClass('us-phone-no')){
								newval=newval.replace(/[\(\)-\s]/g,'');

							} else if($(this).hasClass('us-ssn-no-enc')){
								newval=$(this).data('val');
							}
							mSignupStepTh[$(this).attr('name')]= newval;
						})
						checkIndexCount++;

					} else {
						var singleOwner = {};
						// console.log($(this));
						$(this).find('input, select').each(function() {
							var newval=$(this).val();
							// console.log($(this).attr('name'), newval);
							if($(this).attr('name') == 'fo_phone_arr'){
								newval=newval.replace(/[\(\)-\s]/g,'');
								// console.log(newval);

							} else if($(this).attr('name') == 'fossn_arr'){
								newval=$(this).data('val');
							}
							singleOwner[$(this).attr('name')] = newval;
						})
						// console.log(singleOwner);
						ownerArr.push(singleOwner);
					}
				})
				// return false;
				$(this).find('span').addClass('fa fa-spinner fa-spin');
				mSignupStepTh['ownerArr'] = ownerArr;
				// console.log(mSignupStepTh);return false;
				mSignupStep3FnNew(mSignupStepTh);

			} else {
				//stay at first
			}
			//completed first step
		})
		.on('click','.custom-stepper-form .fourth-step .submit-step',function(e){
			var $wrapper=$(this).closest('.fourth-step');
			// console.log(signUpStepFourth($wrapper));
			if(signUpStepFourth($wrapper))
			{
				//call ajax &  submit step first
				var mSignupStepFth={};
					$('.custom-stepper-form .fourth-step input,.custom-stepper-form .fourth-step select').each(function(){
						var newval=$(this).val();
								if($(this).hasClass('us-phone-no')){
									newval=newval.replace(/[\(\)-\s]/g,'');
								}
						mSignupStepFth[$(this).attr('name')]= newval;
					})
					$(this).find('span').addClass('fa fa-spinner fa-spin');

					mSignupStep4Fn(mSignupStepFth);
				//go to fourth step
				// console.log('false-run');
			}
			else{
				//stay at first
			}
			//completed first step
		})
		.on('click','.custom-stepper-form .third-step .back-step',function(e){
			var $wrapper=$(this).closest('.third-step');
			if(signUpStepThird($wrapper))
			{
				$('.sign-up-form .form-steps .step[data-fStep="2"]').addClass('active');
				$('.sign-up-form .form-steps .step[data-fStep="3"]').removeClass('active').addClass('completed')
			}
			else{
				$('.sign-up-form .form-steps .step[data-fStep="3"]').removeClass('active completed');
			}
				$('.sign-up-form .steps-wrapper  >.row').removeClass('active');
				$('.sign-up-form .steps-wrapper  >.row[data-fStep="2"]').addClass('active');
		})
		.on('click','.custom-stepper-form .fourth-step .back-step',function(e){
			var $wrapper=$(this).closest('.fourth-step');
			if(signUpStepFourth($wrapper))
			{
				$('.sign-up-form .form-steps .step[data-fStep="3"]').addClass('active');
				$('.sign-up-form .form-steps .step[data-fStep="4"] span').html('').addClass('fa fa-check');
				$('.sign-up-form .form-steps .step[data-fStep="4"]').removeClass('active').addClass('completed');
			}
			else{
				$('.sign-up-form .form-steps .step[data-fStep="4"]').removeClass('active completed');
			}
			$('.sign-up-form .steps-wrapper >.row').removeClass('active');
			$('.sign-up-form .steps-wrapper >.row[data-fStep="3"]').addClass('active');
		})
		.on('focus','input.encrypted-field',function(){
			$(this).val($(this).data('val'));
		})
		.on('blur','input.encrypted-field',function(){
			var inpVal=$(this).val(),encPlaceh='';
			if(inpVal.length)
			{
				$(this).data('val',$(this).val().trim());
				var ttlL=$(this).val().trim().length;
				// console.log(ttlL)
				for (var i = 0; i < ttlL; i++) 
				{
					if(!$(this).hasClass('no-dash')){
						if(i != 3 && i != 6)
						encPlaceh+='x';
						else
						encPlaceh+='-';
					}
					else{
						encPlaceh+='x';
					}
				}
				// console.log(encPlaceh)
				$(this).val(encPlaceh);
			}
			else{
				$(this).data('val','');
			}
		})
		.on('keydown click','.sign-up-form .steps-wrapper .form-group .form-control',function(){
			$('.sign-up-form .steps-wrapper .form-group').removeClass('not-match mandatory incorrect');
		})
	//sidebar menu toggle
		.on('click','#sidebar-menu li a',function(e){
			var $this=$(this),$thisLink=$(this);
			toggleSideMenus($this);
		})
		.on('focus','input.us-ssn-no-enc',function(){
			$(this).attr('maxlength',9);
			$(this).val($(this).data('val'));
		})
		.ready(function(){
			$('input.us-ssn-no-enc').each(function(){
				if($(this).val()){
					$(this).trigger('blur');
				}
			})
		})
		.on('blur','input.us-ssn-no-enc',function(){
			$(this).attr('maxlength',11);
			var inpVal=$(this).val(),encPlaceh='';
			if(inpVal.length)
			{
				$(this).data('val',$(this).val().trim());
				var ttlL=$(this).val().trim().length;
				// console.log(ttlL)
				for (var i = 0; i < ttlL; i++) 
				{
					if(i == 3 || i == 6)
					{
						encPlaceh+='-';
					}
					else if(i<= 5)
					{
						encPlaceh+='x';
					}
					else{
						i = ttlL;
						encPlaceh+=inpVal.substr(5, ttlL-1);
					}
				}
				// console.log(encPlaceh)
				$(this).val(encPlaceh);
			}
			else{
				$(this).data('val','');
			}
		})