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
            <span>All Sandbox Payment</span>
          </div>
        </div>
      </div>
      <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row" method="post" action="<?php echo base_url('sandbox/all_sandbox_payment');?>">
              <div class="col">
                <div id="allSAndBoxPay_daterange" class="form-control date-range-style">
                    <span> <?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
                    </span>
                    <input  name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>">
                    <input  name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>">
                </div>
              </div>
              <div class="col">
                <select class="form-control" name="status" id="status">
                  <option value="">Select Status</option>
                  <?php
                    if(!empty($status) && isset($status))
                    {
                  ?>
                      <option value="pending" <?php echo (($status == 'pending')?'selected':"") ?>>Pending</option>
                      <option value="confirm" <?php echo (($status == 'confirm')?'selected':"") ?>>Confirm</option>
                  <?php
                    }
                  else
                    {?>
                      <option value="pending" >Pending</option>
                      <option value="confirm" >Confirm</option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="col-3 ">
                <button class="btn btn-first" type="submit" name="mysubmit" value="Search"><span>Search</span></button>
              </div>
            </form>
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
              <div class="pos-list-dtable reset-dataTable">
                <table id="allSandboxPay-dt" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th idth="22%">Invoice</th>
                          <th >Name</th>
                          <th width="22%">Phone</th>
                          <th width="13%">Amount</th>
                          <th width="13%">Status</th>
                          <th width="16%">Date</th>
                          <!-- <th width="5%" class="no-event"></th> -->
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
                          <td><?php echo $a_data['mobile'] ?></td>
                          <td><span class="status_success">$<?php echo number_format($a_data['amount'],2); ?></td>
                          <td>
                             <a href="#" class="<?php if($a_data['status']=='pending'){ echo 'pos_Status_pend';}elseif ($a_data['status']=='confirm'){echo 'pos_Status_c';}elseif ($a_data['status']=='declined'){echo 'pos_Status_cncl';}?>"><?php echo $a_data['status']; ?></a>
                           </td>
                          <td><?php echo $a_data['date'] ; ?></td>
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
