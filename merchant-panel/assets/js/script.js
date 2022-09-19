
//set transaction default date range
function setTransactionDefDate(){
if($("#daterangeFilter").length){
$("#daterangeFilter span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
$("#daterangeFilter input[name='start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
$("#daterangeFilter input[name='end_date']").val( moment().format("YYYY-MM-DD"));
}
}
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function(e) {
$('.profile-updater  .profile-icon img').attr('src', e.target.result);
}
reader.readAsDataURL(input.files[0]);
}
}
$(document)
.ready(function(){
if($('#daterangeFilter').length){
var daterangeFilter_config = {
  ranges: 
    {
      Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
      "Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
      "This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
    },opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
startDate: (($("#daterangeFilter input[name='start_date']").val().length > 0) ? ($("#daterangeFilter input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
endDate: (($("#daterangeFilter input[name='end_date']").val().length > 0) ? ($("#daterangeFilter input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
};
$('#daterangeFilter').daterangepicker(daterangeFilter_config, function(a, b) 
    {
      $("#daterangeFilter input[name='start_date']").val( a.format("YYYY-MM-DD"));
      $("#daterangeFilter input[name='end_date']").val( b.format("YYYY-MM-DD"));
      $("#daterangeFilter span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
      // setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
    }
);
}
})
.on('click','.toggle-sidebar .float-buttons',function(e){
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

$(function(){
Waves.attach('.float-buttons', ['waves-button']);
// Waves.attach('.float-buttons', ['waves-button', 'waves-float']);
Waves.attach('.flat-buttons', ['waves-button']);
Waves.init();
})