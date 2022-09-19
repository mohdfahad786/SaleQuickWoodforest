<?php
  include_once'header_new.php';
  include_once'nav_new.php';
  include_once'sidebar_new.php';
?>

<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper pos-list">      
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title"> 
            <span>View All Straight Payment Refund</span>
          </div>
        </div>
      </div>
      <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row filter-typesec" method="post" action="<?php echo base_url('refund/all_customer_request');?>">
              <div class="col mx-350">
                <div id="all_customer_refund_daterange" class="form-control date-range-style">
                    <span> <?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
                    </span>
                    <input  name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>">
                    <input  name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>">
                </div>
              </div>
              <!-- <div class="col">
                <select class="form-control" name="status" id="status" >
                  <option value="">Select Status</option>
                  <?php
                    // if(!empty($status) && isset($status))
                    // {
                  ?>
                      <option value="pending" <?php //echo (($status == 'pending')?'selected':"") ?>>Pending</option>
                      <option value="confirm" <?php //echo (($status == 'confirm')?'selected':"") ?>>Confirm</option>
                  <?php
                    // }
                  //else
                    // {?>
                      <option value="pending" >Pending</option>
                      <option value="confirm" >Confirm</option>
                  <?php
                    // }
                  ?>
                </select>
              </div> -->
              <div class="col">
                <input type="submit" name="mysubmit" class="btn btn-first" value="Search" />
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
         <div class="col-12">
              <?php
              if($this->session->flashdata('msg') )
              {
                echo $this->session->flashdata('msg'); 
              }
              ?>

        </div>
        <div class="col-12">
          <div class="card content-card">
            <div class="card-detail">
              <div class="row">
                <div class="col-12 text-success">
                  <?php
                    $count = 0;
                    if(isset($msg))
                    echo $msg;
                  ?>
                </div>
              </div>
              <div class="reset-dataTable">
                <table id="all_customer_refund_dt" class="display salequick-dt" style="width:100%">
                  <thead>
                      <tr>
                          <th>Invoice</th>
                          <th>Name</th>
                          <th>Merchant</th>
                          <th>Phone</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Due Date</th>
                          <th>Create Date</th>
                          <th class="no-event"></th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $i=1;
                      foreach($mem as $a_data)
                      {
                      $count++;
                    ?>
                      <tr>
                          <td><?php echo $a_data['payment_id'] ?></td>
                          <td><?php echo $a_data['name'] ?></td>
                          <td>
                            <?php 
                              $data = $this->admin_model->data_get_where_1('merchant', array('id' => $a_data['merchant_id'])); 
                              foreach ($data as $view) 
                              { 
                                echo $view['name']; ?>
                                <?php 
                              }
                            ?>
                          </td>
                          <td><?php echo $a_data['mobile'] ?></td>
                          <td>
                            <span class="status_success">
                              $<?php echo number_format($a_data['amount'],2); ?>
                            </span>
                          </td>
                          <td>
                              <?php
                                if($a_data['status']=='pending')
                                {
                                  $current_date = date("Y-m-d");
                                  $due_date =  $a_data['due_date'] ;
                                  if($current_date > $due_date) {
                                  echo '<span class="pos_Status_cncl"> Late  </span>';
                                  }
                                  else
                                  {
                                  echo '<span class="pending"> '.$a_data['status'].'  </span>';  
                                  }
                                }
                                elseif ($a_data['status']=='confirm')
                                {
                                  echo '<span class="pos_Status_c"> '.$a_data['status'] .' </span>';
                                }
                                elseif ($a_data['status']=='declined')
                                {
                                  echo '<span class="pos_Status_cncl"> '.$a_data['status'] .' </span>';
                                }
                                elseif($a_data['status']=='Chargeback_Confirm'){
                                  echo '<span class="pos_Status_cncl"> Refund  </span>';
                                }
                              ?>
                            <!-- <a href="#" class="<?php //if($a_data['status']=='pending'){ echo 'pos_Status_pend';}elseif ($a_data['status']=='confirm'){echo 'pos_Status_c';}elseif ($a_data['status']=='declined'){echo 'pos_Status_cncl';}?>">
                              <?php //echo $a_data['status']; ?>
                              </a> -->
                          </td>
                          <td><?php echo $a_data['due_date'] ; ?></td>
                          <td> <?php echo $a_data['date_c'] ; ?></td>
                          <td>
                            <?php
                                  if ($a_data['status'] == 'Chargeback_Confirm') 
                                  {
                            ?>
                                  <div class="dropdown dt-vw-del-dpdwn">
                                    <button type="button" data-toggle="dropdown">
                                      <i class="material-icons"> more_vert </i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item all_customer_refund_vw_btn" data-id="<?php echo $a_data['id'];  ?>" href="#"><span class="fa fa-eye"></span>  Receipt</a>
                                      <a class="dropdown-item pos_vw_refund" href="#"><span class="fa fa-eye"></span>  Refund</a>
                                    </div>
                                  </div>
                            <?php } else { ?>
                                  <a href="#" class="poslist_vw_btn pos_Status_c badge-btn" data-id="<?php echo $a_data['id'];  ?>" ><span class="fa fa-eye"></span> Receipt</a>
                            <?php } ?>
                          </td>
                        </tr>
                      <?php $i++;}?>
                  </tbody>
                </table>
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- End Page Content -->
<div id="all_pos_ref-modal" class="modal">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Payment Detail
        </h4> 
      </div> 
      <div class="modal-body"> 
        <div id="modal-loader" class="text-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
        </div>                         
        <div id="dynamic-content">
          <!-- <div class="form-group">
            <label >Invoice No:</label>
            <p class="form-control-static">POS_20190523070517</p>
          </div> -->
        </div>
      </div> 
    </div> 
  </div>
</div>
<script>

jQuery(function($){
  $('.all_customer_refund_vw_btn').on('click', function (e) {
      // stop - start
      e.preventDefault();
      var uid = $(this).data('id');   // it will get id of clicked row
      $('#all_pos_ref-modal').modal('show');
      $('#dynamic-content').html(''); // leave it blank before ajax call
      $('#modal-loader').show();      // load ajax loader
      $.ajax({
       url: "<?php  echo base_url('merchant/search_record_column1'); ?>",
       type: 'POST',
       data: 'id='+uid,
       dataType: 'html'
     })
      .done(function(data){
        // console.log(data);    
        $('#dynamic-content').html(data); // load response 
        $('#modal-loader').hide();      // hide ajax loader 
      })
      .fail(function(){
        $('#dynamic-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
        $('#modal-loader').hide();
      });
  })
})

</script>
<?php
include_once'footer_new.php';
?>
