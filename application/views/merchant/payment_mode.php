<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>

<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper view-tax-page">   
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title">
            <span>View Payment Mode List</span>
            <a class="btn btn-custom1" href="<?php echo base_url('merchant/add_payment_mode'); ?>"><span>Add Payment Mode </span> <span class="material-icons">add</span></a>
          </div>
        </div>
      </div>
      <div class="row">
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
                <table id="dt_view_tax_list" class="display salequick-dt" style="width:100%">
                  <thead>
                      <tr>
                          <th data-priority="0">St No.</th>
                          <th >Name</th>
                         
                          <th>Status</th>
                          <th class="no-event"></th>
                          <th class="no-event" data-priority="1"></th>
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
                          <td><?php echo $i; ?></td>
                          <td><?php echo $a_data['name'] ?></td>
                          <td><a href="#" class="<?php if($a_data['status']=='1') { echo 'pos_Status_c'; } elseif( $a_data['status']=='0'){ echo 'pos_Status_cncl'; } ?>"><?php if($a_data['status']=='1') { echo 'Active';} if($a_data['status']=='0') { echo 'Block';}   ?></a></td>
                          <td>
                            <a href="<?php  echo site_url('merchant/edit_payment_mode/' . $a_data['id']) ?>" class="tax-edit-btn">Edit</a>
                            
                          </td>
                          <td>

                          <a title="Delete" href="<?php  echo base_url('merchant/delete_payment_mode/' . $a_data['id']) ?>" class="tax-edit-btn"><i class="fa fa-trash text-danger"></i></a>

                            <!-- <div  class="start_stop_tax  <?php if($a_data['status']=='1') { echo 'active'; }?>" 
                              rel="<?php echo $a_data['id'];?>">
                            <label class="switch switch_type1" role="switch">
                                <input type="checkbox" class="switch__toggle" <?php if($a_data['status']=='active') { echo 'checked'; } elseif( $a_data['status']=='block'){ echo ''; } ?>>
                                <span class="switch__label">|</span>
                              </label>
                              <span class="msg">
                                <span class="stop">Stop</span>
                                <span class="start">Start</span>
                              </span>
                            </div> -->
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

<?php
include_once'footer_new.php';
?>
