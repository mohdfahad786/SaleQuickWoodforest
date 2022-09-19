<!-- Top Bar Start -->

<div class="topbar">

    <form class="custom-form">

        <div class="form-group">

            <div class="toggle-sidebar">

                <span class="float-buttons"><i  class=" material-icons menu-icon">menu</i></span>

            </div>

            <!-- <span class="material-icons">search</span>

            <input type="text" class="form-control" placeholder=""> -->




        </div>

        <div class="form-group">

        <div class="notification-wrapper dropdown">
                <!-- <div class="noticfication-count float-buttons" data-toggle="dropdown"> -->




                <!-- <div class="noticfication-count float-buttons" data-toggle="dropdown">
                    <img src="<?php echo base_url('new_assets/img/notification.png'); ?>" alt="notification">

                    <span class="n-counts">10</span>

                </div> -->

                <!-- <div class="dropdown-menu dropdown-menu-right">
                    <div class="notification-content">
                        <div class="notification-header">
                            <span class="float-right clear-all-btn">
                                <a href="javascript:void(0)" onclick="" > Clear All </a>
                            </span>
                            <span>Notification</span>
                        </div>



                         <div class="notification-body " >
                            <div class="no-notification-msg"> There is no notification!! </div>
                            <div class="notification-body-inner" >

                        <div class="notification-item">
                                        <a href="<?php echo base_url('merchant/readnotofication/') ?>"  class="dropdown-item ">
                                            <span class="notify-details">Hi</span>
                                        </a>
                                    </div>


                                </div>
                            </div>

                        <div class="notification-body " >
                            <div class="notification-item">
                                <a href="javascript:void(0);" class="dropdown-item">
                                   <small>You have No Notification here...</small>
                                </a>
                            </div>
                        </div>


                    </div>
                </div> -->
            </div>
        </div>

    </form>

</div>

<script type="text/javascript">

    var XMLHttpRequestObject = false;

    var base_url = '//salequick.com/';

    var base_url_no_index = '//salequick.com/';

</script>

<!-- Top Bar End -->

<style>

  .notification-content .notification-body a .notify-details{

  margin-left: 0px;

  }

  .notify-details{text-align: right;}

  .notify-details >span:first-child {

  float: left;

  max-width: 134px;

  overflow: hidden;

  text-overflow: ellipsis;

  }

  .notify-details >span span {

  font-size: 11px;

  }

</style>



<script>

   function checknotification(NotiId)

   {



    $.ajax({

          type: 'POST',

          url: '<?php echo base_url('merchant/readnotofication'); ?>',

          data: {'id':NotiId },

          type:'post',

          success: function (dataJson){

              data = JSON.parse(dataJson)

              console.log(data)

              $('#saleChart').data('vals',data.item3);

              saleSummeryPdfTableConvertor($('#salesChartExportDt'),data.item3)

              var a=data.getDashboardData[0].TotalAmount;

              var b=data.getDashboardData[0].TotalAmountRe;

              var c=data.getDashboardData[0].TotalAmountPOS;

              // console.log(a+b+c)

              updateSaleOrderChart(a ,b ,c )

          }

        });

   }



   function clear_allnotification(merchantid)

   {

    $.ajax({

          type: 'POST',

          url: '<?php echo base_url('merchant/readallnotofication'); ?>',

          data: {'merchantid':merchantid },

          type:'post',

          success: function (data){

              //data = JSON.parse(dataJson)

              //console.log(data)

              if(data=='200')

              {

                 $('.notification-item').remove();

                 $('.n-counts').remove();



                 //$('.noticfication-count').data('toggle','rtgrtrt');

               // $(".notification-wrapper .noticfication-count float-buttons").removeAttr("data-toggle");

              }



          }

        });

   }



</script>