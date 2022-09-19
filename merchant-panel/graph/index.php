<!DOCTYPE html>
<html lang="en">
  <head>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta charset="utf-8">
    <title>Improvely</title>
    
    <script type="text/javascript">
    var userprefs = {
      goal: 'all',
      metric1: 'people',
      metric2: 'conversions',
      units: 'days',
      start: '2017-11-15',
      end: '2017-12-14',
      timezone: 'America/New_York',
      plan_id: 3
    };
    </script>

        <link href="app.min.css" rel="stylesheet" />
    <script src="app1.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- start Mixpanel -->
    <script type="text/javascript">(function(c,a){window.mixpanel=a;var b,d,h,e;b=c.createElement("script");b.type="text/javascript";b.async=!0;b.src=("https:"===c.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.1.min.js';d=c.getElementsByTagName("script")[0];d.parentNode.insertBefore(b,d);a._i=[];a.init=function(b,c,f){function d(a,b){var c=b.split(".");2==c.length&&(a=a[c[0]],b=c[1]);a[b]=function(){a.push([b].concat(Array.prototype.slice.call(arguments,0)))}}var g=a;"undefined"!==typeof f?
g=a[f]=[]:f="mixpanel";g.people=g.people||[];h="disable track track_pageview track_links track_forms register register_once unregister identify name_tag set_config people.identify people.set people.increment".split(" ");for(e=0;e<h.length;e++)d(g,h[e]);a._i.push([b,c,f])};a.__SV=1.1})(document,window.mixpanel||[]);
mixpanel.init("eefb86c233fd45d58ffbbb6437a1cd96");</script>
    <!-- end Mixpanel -->

  </head>
<body>

  <div class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
  <div class="container">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-nav-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar" style="background: #fff"></span>
        <span class="icon-bar" style="background: #fff"></span>
        <span class="icon-bar" style="background: #fff"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="top-nav-collapse">

      <ul class="nav navbar-nav"> 
        <li class="dropdown project">

                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-folder-open"></i> <span style="font-weight: normal">Project:</span> 
              Web Shop              <span class="caret"></span>
            </a>
          
                   <ul class="dropdown-menu">
            <li class="heading">
              <div class="pull-right"><a href="/">Project List</a></div>
              Switch Project
            </li>
            
              
              <li class="project" style="padding: 0">
                                  <a style="display: block; float: right; text-align: right; color: #08c; padding: 10px 15px 10px 5px" href="/project/webshop"><i class="fa fa-cog"></i> Settings</a>                                <a style="clear: none; display: block; padding: 10px 5px 10px 15px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; width: 190px; padding-right: 0" href="/reports/webshop/overview"><i class="fa fa-folder"></i> Web Shop</a>                
              </li>
                                    <li class="footer">
              <form method="get" action="/project/new">                <input type="submit" value="Create A New Project" class="btn btn-success btn-sm" />
              </form>
            </li>
                      </ul>
          
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right"> 

        
        
        <li class="dropdown alerts" id="alerts">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell"></i> 
            <span class="label label-info">4</span>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Recent Updates</li>

                          <li id="news_17" class="news">
                <a href="https://www.improvely.com/blog/2017/05/16/new-conversion-notification-options/">
                  <i class="fa fa-circle" style="color: #5bc0de"></i>&nbsp; 
                  New Conversion Notification Options                </a>
              </li>

                          <li id="news_16" class="news">
                <a href="https://www.improvely.com/blog/2017/02/12/new-feature-update-historical-costs/">
                  <i class="fa fa-circle" style="color: #5bc0de"></i>&nbsp; 
                  New Feature: Update Historical Costs                </a>
              </li>

                          <li id="news_15" class="news">
                <a href="https://www.improvely.com/blog/2016/08/23/new-feature-customer-notes/">
                  <i class="fa fa-circle" style="color: #5bc0de"></i>&nbsp; 
                  New Feature: Customer Notes                </a>
              </li>

                          <li id="news_14" class="news">
                <a href="https://www.improvely.com/blog/2016/06/24/new-metric-converted-people/">
                  <i class="fa fa-circle" style="color: #5bc0de"></i>&nbsp; 
                  New Metric: Converted People                </a>
              </li>

            
          </ul>
        </li>    
          

                <li class="dropdown profile">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-cog fa-lg"></i>
            Account Settings
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="/plan"><i class="fa fa-credit-card"></i> Plan &amp; Billing Info</a></li>
            <li><a href="/users"><i class="fa fa-users"></i> Manage Users</a></li>
                        <!--<li><a href="/domains"><i class="fa fa-globe"></i> Tracking Domains</a></li>-->
                                    <li><a href="/api"><i class="fa fa-key"></i> API Credentials</a></li>
          </ul>
        </li>
        
        <li class="dropdown profile">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="https://www.gravatar.com/avatar/cbea0da6158fb08afead8143a5d461a2?s=24&d=identicon" 
              style="border: 1px solid #ccc; border-radius: 2px; position: absolute; top: 12px; left: 15px" />
            <span style="margin-left: 33px">
            joe@mysite.com            </span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="/profile"><i class="fa fa-user"></i> My Profile</a></li>
                        <li><a href="https://www.improvely.com/referral_program"><i class="fa fa-user-plus"></i> Refer a Friend</a></li>
                        <li><a href="/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
          </ul>
        </li>

      </ul>

    </div>
    
  </div> <!-- /container -->    
</div> <!-- /navbar -->


<div class="navbar navbar-subnav">
  <div class="container">

    <ul class="nav navbar-nav navbar-sub"> 

      
      <li><a href="/reports/webshop/overview"><i class="fa fa-th-large"></i> Dashboard</a></li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bar-chart"></i> <span>Reports</span> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="/reports/webshop/all"><i class="fa fa-globe"></i> All Traffic</a></li>
          <li><a href="/reports/webshop/ads"><i class="fa fa-bullhorn"></i> Ad Traffic</a></li>
          <li><a href="/reports/webshop/organic"><i class="fa fa-share-alt"></i> Organic Traffic</a></li>
          <li><a href="/reports/webshop/search"><i class="fa fa-search"></i> Search Traffic</a></li>
          <li><a href="/reports/webshop/links"><i class="fa fa-link"></i> Tracking Links</a></li>
                    <li><a href="/reports/webshop/affiliate_links"><i class="fa fa-share"></i> Affiliate Outlinks</a></li>
                    <li><a href="/reports/webshop/funnels"><i class="fa fa-filter"></i> Conversion Funnels</a></li>
        </ul>
      </li>      

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-exclamation-triangle"></i> <span>Click Fraud</span> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="/reports/webshop/fraud"><i class="fa fa-exclamation-triangle"></i> Fraud Alerts</a></li>
          <li><a href="/reports/webshop/ips"><i class="fa fa-globe"></i> Top IPs</a></li>
          <li><a href="/reports/webshop/spikes"><i class="fa fa-line-chart"></i> Spike Analysis</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-wrench"></i> <span>Tools</span> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
                    <li><a href="/tools/webshop/import"><i class="fa fa-upload"></i> Import PPC Costs</a></li>
          <li><a href="/tools/webshop/affiliate/import"><i class="fa fa-money"></i> Import Affiliate Commissions</a></li>
          <li><a href="/tools/webshop/links"><i class="fa fa-link"></i> Manage Tracking Links</a></li>
                    <li><a href="/reports/webshop/people/explore"><i class="fa fa-users"></i> People Explorer</a></li>
          <li><a href="/reports/webshop/realtime"><i class="fa fa-eye"></i> Realtime Spy</a></li>
        </ul>
      </li>

      
    </ul>

        <ul class="nav navbar-nav navbar-right" style="margin-right: 0">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle btn-success btn btn-sm" data-toggle="dropdown" style="font-weight: bold; margin: 9px 0; padding: 4px 10px; background: #5eb95e">
          <i class="fa fa-plus"></i> Create New <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" style="margin-top: -9px">
          <li><a href="/tools/webshop/link_builder"><i class="fa fa-link"></i> Tracking Link</a></li>
          <li><a href="/tools/webshop/link_builder?ab=true"><i class="fa fa-random"></i> A/B Split Test</a></li>
          <li><a href="/tools/webshop/affiliate/link_builder"><i class="fa fa-share"></i> Affiliate Outlink</a></li>
                    <li><a href="/tools/webshop/funnel_builder"><i class="fa fa-filter"></i> Funnel Report</a></li>
                              <li><a href="/user"><i class="fa fa-user"></i> User</a></li>
                            </ul>
      </li>
    </ul>
        
  </div> <!-- /container -->    
</div> <!-- /navbar -->

            
  <div class="container">
    <script type="text/javascript">
currency_symbol = '$';
</script>

<div class="row">

	<div class="col-md-12">

		<div id="daterange" class="selectbox pull-right">
			<i class="fa fa-calendar"></i>
			<span>November 15, 2017 - December 14, 2017</span> <b class="caret"></b>
		</div>
	
		<div class="pull-right" style="margin-right: 10px">
			<select name="goal" id="goalfilter" style="width: 150px" multiple="multiple">
								<option value="sale">Sale</option>
							</select>
		</div>

		<div class="transparent-header">
			<h2>Web Shop</h2>
			<h1>Ad Performance</h1>
		</div>

	</div>

</div>

<div class="row" style="margin-bottom: 20px">
	<div class="col-md-12">

		<div class="breadcrumbs">
			<ul class="breadcrumb-alt">

						<li><a href="?tab=channel">All Sources</a></li>
			
					</ul>
		</div>	

	</div>
</div>

<div class="row" style="margin-bottom: 20px">
	<div class="col-md-12">
		<div class="page page-white">
			<div id="graph" class="graph">

    <div class="pull-right">

        <select name="graph_metric1" style="width: 140px">
            <option value="people">People</option>
            <option value="clicks">Visits</option>
            <option value="converted_people">Conv. People</option>
            <option value="conversions">Conversions</option>
            <option value="convrate">Conversion Rate</option>
            <option value="cost">Cost</option>
            <option value="cpa">CPA</option>
            <option value="cpc">CPC</option>
            <option value="revenue">Revenue</option>
            <option value="rpp">RPP</option>
            <option value="profit">Profit</option>
        </select>

        <select name="graph_metric2" style="width: 140px">
            <option value="people">People</option>
            <option value="clicks">Visits</option>
            <option value="converted_people">Conv. People</option>
            <option value="conversions">Conversions</option>
            <option value="convrate">Conversion Rate</option>
            <option value="cost">Cost</option>
            <option value="cpa">CPA</option>
            <option value="cpc">CPC</option>
            <option value="revenue">Revenue</option>
            <option value="rpp">RPP</option>
            <option value="profit">Profit</option>
        </select>

        <!--
        <select name="graph_units" style="width: 100px; display: none">
            <option value="days">Days</option>
            <option value="weeks">Weeks</option>
            <option value="months">Months</option>
        </select>
        -->

        <btn class="btn btn-default btn-sm graph_download" rel="tooltip" title="Download Excel CSV" style="margin-left: 7px; background: #fff; border-width: 1px"><i class="fa fa-download"></i></btn>

    </div>

    <div class="pull-left metric1">
        <h1 style="font-weight: normal; color: #08c; margin: 0; font-size: 30px; line-height: 1.1em"></h1>
        <h2 style="font-weight: normal; color: #ababab; margin: 0; letter-spacing: .15em; text-transform: uppercase; line-height: 1.5em; font-size: 12px">People</h2>
    </div>

    <div class="pull-left metric2" style="margin-left: 30px">
        <h1 style="font-weight: normal; color: #390; margin: 0; font-size: 30px; line-height: 1.1em"></h1>
        <h2 style="font-weight: normal; color: #ababab; margin: 0; letter-spacing: .15em; text-transform: uppercase; line-height: 1.5em; font-size: 12px">Conversions</h2>
    </div>

    <div class="placeholder" style="clear: both; margin: 0 -10px -10px -10px"></div>

</div>		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">

		<ul class="nav nav-tabs nav-tabs-toplevel" style="border-bottom: 2px solid #ccc">
									<li class="active"><a href="?tab=source&filters[ad]=1" style="font-weight: normal">Source</a></li>
									<li><a href="?tab=name&filters[ad]=1" style="font-weight: normal">Campaign</a></li>
									<li><a href="?tab=medium&filters[ad]=1" style="font-weight: normal">Medium</a></li>
									<li><a href="?tab=content&filters[ad]=1" style="font-weight: normal">Content</a></li>
									<li><a href="?tab=url&filters[ad]=1" style="font-weight: normal">Landing Page</a></li>
									<li><a href="?tab=billed_keyword&filters[ad]=1" style="font-weight: normal">Keyword</a></li>
									<li><a href="?tab=searched_keyword&filters[ad]=1" style="font-weight: normal">Search</a></li>
									<li><a href="?tab=referring_domain&filters[ad]=1" style="font-weight: normal">Domain</a></li>
									<li><a href="?tab=referrer&filters[ad]=1" style="font-weight: normal">Referrer</a></li>
									<li><a href="?tab=device&filters[ad]=1" style="font-weight: normal">Device</a></li>
									<li><a href="?tab=country&filters[ad]=1" style="font-weight: normal">Country</a></li>
									<li><a href="?tab=day&filters[ad]=1" style="font-weight: normal">Day</a></li>
									<li><a href="?tab=hour&filters[ad]=1" style="font-weight: normal">Hour</a></li>
					</ul>

		<div class="page page-white" style="padding: 0">

			<table id="report" class="table-striped">
				<thead>
					<tr>
						<th title="Click a link to add a filter" style="text-align: left; width: 100%">Source</th>
						<th title="Number of unique people">People</th>
						<th title="Number of site visits">Visits</th>
						<th title="Converted People: Number of unique people that reached one of your goals">CP</th>
						<th title="Conversions: Number of times one of your goals was reached">Conv.</th>
						<th title="Conversion Rate: Percentage of people that reached one of your goals">CR</th>
						<th title="Total PPC cost from these ad clicks">Cost</th>
						<th title="Cost Per Acquisition: Average cost to acquire one goal conversion">CPA</th>
						<th title="Cost Per Click (Visit)" class="hidden-sm hidden-xs hidden-md">CPC</th>
						<th title="Revenue from goal conversions">Revenue</th>
						<th title="Revenue Per Person" class="hidden-sm hidden-xs hidden-md">RPP</th>
						<th title="Revenue minus cost">Profit</th>
					</tr>
				</thead>
				<tbody>
					<tr class="loading">
						<td colspan="11" style="text-align: center">
			
							<div class="message">
								<div class="progress"><div class="progress-bar progress-bar-striped active" style="width: 100%;"></div></div>
								Your report is being generated. This may take up to several minutes...
							</div>
						</td>
					</tr>
					<tr class="nodata">
						<td colspan="11" style="text-align: center">
							<div class="message">
																	There is no data to display for the selected date range. 

																		Have you installed the 
									<a href="/code/webshop">Improvely Tracking Code</a>									on your site, and updated your ads with 
									<a href="/tools/webshop/link_builder">tracking links</a>?
									
															</div>
						</td>
					</tr>
					<tr class="timeout">
						<td colspan="11" style="text-align: center">
							<div class="message">
								Report generation has timed out. 
							</div>
						</td>
					</tr>									
				</tbody>
				<tfoot>
				</tfoot>
			</table>

		</div>

		<a href="/api/report.xls?type=ad&amp;tab=channel"><button class="btn btn-primary" style="margin-top: 20px"><i class="fa fa-download"></i> &nbsp; Download Excel CSV</button></a>
	</div>
</div>

<script type="text/javascript">

var updates = 0;
var loading = $('#report tbody .loading').hide().clone();
var nodata = $('#report tbody .nodata').hide().clone();
var timeout = $('#report tbody .timeout').hide().clone();

$(document).ready(function() {
	getTable();
	getGraph();
});

function getGraph(start, end) {

	$('#graph .placeholder').html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px">Loading...</div>');
	$('#graph h1, #graph h2').html('&nbsp;');
	$('#graph .metric1 h1').html('<i class="fa fa-spinner fa-spin"></i>');

	var jsonurl = 'gra.json?filters[ad]=1';
	jsonurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
	jsonurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2 + '&units=' + userprefs.units;

	if (typeof location.search == 'string' && location.search.length > 0)
		jsonurl += '&' + location.search.substring(1);

	if (typeof start != 'undefined' && typeof end != 'undefined' && start != null & end != null)
		jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end);

	$.getJSON(jsonurl, function(data) {
		if (data.length != 0) imGraph('graph', data);
	});

}

function downloadGraph() {
	var dlurl = '/api/graph.xls?filters[ad]=1';
	dlurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
	dlurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2;
	if (typeof location.search == 'string' && location.search.length > 0)
		dlurl += '&' + location.search.substring(1);
	window.location = dlurl;
}

function getTable(start, end) {

	$('#report tbody').html(loading.html());
	$('#report tfoot').html('');

	var jsonurl = 'report.json';
	if (typeof location.search == 'string' && location.search.length > 0)
		jsonurl += '?' + location.search.substring(1) + '&type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal);
	else
		jsonurl += '?type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal);

	if (typeof start != 'undefined' && typeof end != 'undefined' && start != null && end != null)
		jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end);

	$.post(jsonurl, function(data) {

		var html = '', clicks = 0, people = 0, conversions = 0, converted_people = 0, revenue = 0, cost = 0;
		
		if (data.length == 0) {
			$('#report tbody').html(nodata.html());
		} else {

			for (var row in data) {

				var label = data[row]['label'];
				if (data[row]['label'] == null || data[row]['label'] == '') {
					label = '[ No Source ]';				}

				
				html += '<tr>';

								var url = '?tab=source&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']);

				html += '<td style="text-align: left" class="ellipsis">';

				
									if (label.length > 40 && (label.substr(0, 7) == 'http://' || label.substr(0,8) == 'https://'))
						html += '<a href="' + url + '" title="' + label + '">' + label + '</a>';
					else
						html += '<a href="' + url + '">' + label + '</a>';
				
				html += '</td>';

								var url = '/reports/webshop/people?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']);
				html += '<td><a href="' + url + '">' + add_commas(data[row]['people']) + '</a></td>';

								var url = '/reports/webshop/clicks?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']);
				html += '<td><a href="' + url + '">' + add_commas(data[row]['clicks']) + '</a></td>';

								var url = '/reports/webshop/conversions?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']) + '&goal=' + encodeURIComponent(userprefs.goal);
				html += '<td><a href="' + url + '">' + add_commas(data[row]['converted_people']) + '</a></td>';

								var url = '/reports/webshop/conversions?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']) + '&goal=' + encodeURIComponent(userprefs.goal);
				html += '<td><a href="' + url + '">' + add_commas(data[row]['conversions']) + '</a></td>';

				html += '<td>' + format_rate(data[row]['converted_people'] / data[row]['people']) + '</td>';
				html += '<td>' + format_money(data[row]['cost']) + '</td>';
				html += '<td>' + format_money(data[row]['cost'] / data[row]['conversions']) + '</td>';
				html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(data[row]['cost'] / data[row]['clicks']) + '</td>';
				html += '<td>' + format_money(data[row]['revenue']) + '</td>';
				html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(data[row]['revenue'] / data[row]['people']) + '</td>';
				html += '<td>' + format_money(data[row]['revenue'] - data[row]['cost']) + '</td>';
				
				html += '</tr>';

				clicks += parseInt(data[row]['clicks']);
				people += parseInt(data[row]['people']);
				converted_people += parseInt(data[row]['converted_people']);
				conversions += parseInt(data[row]['conversions']);
				revenue += parseFloat(data[row]['revenue']);
				cost += parseFloat(data[row]['cost']);

			}

			$('#report tbody').html(html);

							if (updates == 0) {
				    $("#report").tablesorter({ 
				        textExtraction: function(node) { 
				        	var decoded = $('<div/>').html(currency_symbol).text();
				            return node.innerHTML.replace(/<\/?[^>]+>/gi, '').replace(',', '').replace(currency_symbol, '').replace(decoded, '');
				        },
				        sortList: [[1,1]]
				    }); 
				} else {
					$('#report').trigger("update");
					$('#report').trigger("sorton",[[[1,1]]]);
				}
			
			updates++;

		}

		html = '<tr>';
		html += '<td style="text-align: left"><b>Totals:</b></td>';
		html += '<td>' + add_commas(people) + '</td>';
		html += '<td>' + add_commas(clicks) + '</td>';			
		html += '<td>' + add_commas(converted_people) + '</td>';
		html += '<td>' + add_commas(conversions) + '</td>';
		html += '<td>' + format_rate(converted_people / people) + '</td>';
		html += '<td>' + format_money(cost) + '</td>';
		html += '<td>' + format_money(cost / conversions) + '</td>';
		html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(cost / clicks) + '</td>';
		html += '<td>' + format_money(revenue) + '</td>';
		html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(revenue / people) + '</td>';
		html += '<td>' + format_money(revenue - cost) + '</td>';
		html += '</tr>';
		$('#report tfoot').html(html);

	}, 'json').fail(function() {
		$('#report tbody').html(timeout.html());
	});

}

</script>

    <div class="row">
      <div class="col-md-12">

      
        <div id="feedback">
          <form action="" class="form-horizontal" method="post">
            <div class="row">
              <div class="col-md-10" style="padding-right: 5px">
                <textarea name="feedback" class="form-control"></textarea>
              </div>
              <div class="col-md-2" style="text-align: center">
                <input type="submit" name="submit" value="Send Feedback" class="btn btn-success" style="width: 100%" />
              </div>
            </div>
          </form>
        </div>

        <div id="footer">
          <div class="pull-right" style="text-align: right; padding-top: 5px">
            Copyright &copy; 2017 <a href="http://www.awio.com/">Awio Web Services LLC</a>            <br />
            <a href="https://www.improvely.com/terms">Terms of Service</a> &nbsp;&middot;&nbsp; <a href="https://www.improvely.com/docs">Knowledge Base</a> &nbsp;&middot;&nbsp; <a href="mailto:hello@improvely.com">Contact Us</a>
          </div>
          <a href="https://www.improvely.com/"><img alt="Improvely Logo" src="/images/logo-white-tiny.png" /></a>        </div>

      
      </div>
    </div>
  </div>

  
  
  <div class="container"><div class="row"><div class="col-md-12">
    <div class="afs_ads" style="color: #ccc; font-size: 10px; text-align: right; padding: 5px 0">ip-10-150-59-89</div>
  </div></div></div>

  </body>
</html>
