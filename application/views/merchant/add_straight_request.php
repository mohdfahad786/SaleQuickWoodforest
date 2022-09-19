<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>

<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper invoice-wrapper">  
      <?php

      if(isset($msg))
      echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$msg."</div> </div> </div> </div>";

      if($this->session->flashdata('error'))
      echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$this->session->flashdata("error")."</div> </div> </div> </div>";

        
      
        echo form_open('merchant/'.$loc, array('id' => "my_form",'class'=>"row inv-rec-wrapper",'enctype'=> 'multipart/form-data','name' => "myForm",'onsubmit' => "return validateForm()"));
        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
        $merchant_name = $this->session->userdata('merchant_name');
        $names = substr($merchant_name, 0, 3);
      ?>   
     <!--  <div class="row"> -->
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              Create Invoice
            </div>
            <div class="card-detail">
              <div class="row custom-form reset-col-p">
                <div class="col">
                  <div class="form-group">
                    <label for="">Invoice No</label>
                    <input class="form-control" name="invoice_no" id="invoice_no" pattern="[a-zA-Z\s]+" value="INV<?php echo strtoupper($names) ?>000<?php echo  $getDashboardData[0]['TotalOrders']+1; ?>"  readonly required type="text">
                  </div>
                  <div class="form-group">
                    <label for="">Reference</label>
                    <input class="form-control" placeholder="Ex.P.O. Number" name="reverence" id="reverence"   placeholder="Reference:" value="<?php echo (isset($reverence) && !empty($reverence)) ? $reverence : set_value('reverence');?>"  type="text">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">Customer Name</label>
                    <input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" required  placeholder="Full Name:" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required type="text" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="">Phone Number</label>
                    <input class="form-control" placeholder="Phone" name="mobile" id="phone" required value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>"  type="text">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">Email Address</label>
                    <input class="form-control"  name="email" id="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email " value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>"  type="text">
                  </div>
                  <div class="form-group">
                    <label for="">Due Date</label>
                    <input type="text" name="due_date" class="form-control"  id="invoiceDueDatePicker" placeholder="Due date" name="" autocomplete="off" required>
                  </div>
                </div>
              </div>
              <div class="row custom-form">
                <div class="col-4">
                  <div class="form-group">
                    <label for="">Title</label>
                    <input class="form-control" name="title" id="title"  placeholder="Title:" required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>" type="text">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              All Items
            </div>
            <div class="card-detail inv-recur-adder-form">
              <div class="all_items_wrapper_outer">
                <div class="all_items_wrapper">
                  <div class="row custom-form reset-col-p">
                    <div class="col">
                      <div class="form-group">
                        <label for="">Item Name</label>
                      </div>
                      <div class="form-group">
                        <input class="form-control item_name" name="Item_Name[]" placeholder="Item name" type="text" required="">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="">Quantity</label>
                      </div>
                      <div class="form-group">
                        <input class="form-control item_qty" placeholder="Quantity" name="Quantity[]" id="quantity_1" type="text" onKeyPress="return isNumberKey(event)" required>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="">Price ($)</label>
                      </div>
                      <div class="form-group">
                        <div class="input-group ">
                          <div class="input-group-addon">
                            <span class="input-group-text">$</span>
                          </div>
                          <input class="form-control item_price"  id="price_1" required  name="Price[]" placeholder="Price" type="text" autocomplete="off" onKeyPress="return isNumberKeydc(event)">
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="">Tax</label>
                      </div>
                      <div class="form-group">
                        <?php
                          $merchant_id = $this->session->userdata('merchant_id');
                          $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id,'status' => 'active')); 
                        ?>
                        <select name="Tax[]" class="form-control sel_item_tax tax" id="tax_1" >
                          <option rel="0" value="0" >No Tax</option>
                          <?php foreach ($data as $view) { ?>
                            <option rel="<?php echo $view['percentage']; ?>" value="<?php echo $view['id']; ?>"><?php echo $view['title']; ?>&nbsp;(<?php echo $view['percentage']; ?>%)</option>
                          <?php } ?>
                        </select>
                        <input type="hidden" class="form-control price item_tax" id="tax_amount_1" placeholder="Tax Amount"  name="Tax_Amount[]" value="0">
                        <input type="hidden" class="form-control hide_tax" id="tax_per_1" name="Tax_Per[]" value="0">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="">Total ($)</label>
                      </div>
                      <div class="form-group">
                        <div class="input-group ">
                          <div class="input-group-addon">
                            <span class="input-group-text">$</span>
                          </div>
                          <input class="form-control sub_total" placeholder="Total"  name="Total_Amount[]" id="total_amount_1" readonly type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item-adder new-item-adder" >
                <button type="button" class="btn btn-custom1">Add Item <span class="material-icons plus"> add </span></button>
              </div>
            </div>
            <div class="card-title"></div>
            <div class="invoice-total-wraper">
              <div class="row custom-form">
                <div class="col-4">
                  <div class="form-group">
                    <label for="">Attachment</label> 
                  </div>
                  <div class="form-group">
                    <input class="form-control item_name" name="file"  placeholder="file" type="file" > 
                  </div>
                </div>
                <div class="col form-inline">
                  <label for="">Sub Total</label>
                  <div class="input-group ">
                    <div class="input-group-addon">
                      <span class="input-group-text">$</span>
                    </div>
                      <input class="form-control " placeholder="0.00" name="sub_amount" id="sub_amount" type="text" readonly>
                  </div>
                </div>
              </div>
              <div class="row custom-form">
                <div class="col form-inline">
                  <label for="">Total Tax</label>
                  <div class="input-group ">
                    <div class="input-group-addon">
                      <span class="input-group-text">$</span>
                    </div>
                    <input class="form-control total_tax" name="total_tax" id="total_tax" placeholder="0.00" type="text" readonly>
                  </div>
                </div>
              </div>
              <div class="row custom-form">
                <div class="col form-inline">
                  <label for="">Total Amount</label>
                  <div class="input-group ">
                    <div class="input-group-addon">
                      <span class="input-group-text">$</span>
                    </div>
                    <input class="amount form-control" name="amount" placeholder="0.00" id="amount"  type="text" readonly >
                  </div>
                </div>
              </div>
              <div class="row custom-form inv-custom-btns">
                <div class="col form-inline">
                  <button type="reset" class="btn btn-second">Clear All</button>
                  <button type="submit" name="submit" class="btn btn-first">Send Request</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- </div> -->
      <?php echo form_close();?>
    </div>
  </div>
<!-- End Page Content -->
<?php
include_once'footer_new.php';
?>
