<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>

<!-- Start Page Content -->
<div id="wrapper"> 
  <div class="page-wrapper pos-page"> 
      <?php
        if(isset($msg))
          echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$msg."</div> </div> </div> </div>";
      ?>
      <?php
        echo form_open('pos/'.$loc, array('id' => "my_form", 'class'=>"row", "onsubmit"=>"return virtualTerValidateForm()" ));
        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
      ?>   
    <!-- <form class="row" onsubmit="return validatePosForm()" id="pos_form" action="#"> -->
      <div class="col-12">
        <div class="back-title m-title">
            <?php echo '<span>'.($meta) .'</span>'?>
        </div>
      </div>
      <div class="col-7">
        <div class="card content-card">
          <div class="card-title">
            <div class="calc-screen">
              <div class="calc-dolar">$</div>
              <div class="calc-input">
                <input class="form-control" type="text" placeholder="Enter value here" id="t_amount" onKeyPress="return isNumberKey(event)"  autocomplete="off">
              </div>
            </div>
          </div>
          <div class="card-detail">
            <div class="calc-keys-wrapper">
              <table class="table text-center">
                <tbody>
                  <tr>
                    <td onclick="posCalcFn(this)" data-val="1" ><span class="b-btm-top"></span><span>1</span></td>
                    <td onclick="posCalcFn(this)" data-val="2" ><span class="b-btm-top"></span><span>2</span></td>
                    <td onclick="posCalcFn(this)" data-val="3" ><span class="b-btm-top"></span><span>3</span></td>
                    <td data-symbol="back" id="pos-del-btn" rowspan="2" valign="middle"><span class="material-icons"> arrow_back</span></td>
                  </tr>
                  <tr>
                    <td onclick="posCalcFn(this)" data-val="4" ><span class="b-btm-top"></span><span>4</span></td>
                    <td onclick="posCalcFn(this)" data-val="5" ><span class="b-btm-top"></span><span>5</span></td>
                    <td onclick="posCalcFn(this)" data-val="6" ><span class="b-btm-top"></span><span>6</span></td>
                  </tr>
                  <tr>
                    <td onclick="posCalcFn(this)" data-val="7" ><span class="b-btm-top"></span><span>7</span></td>
                    <td onclick="posCalcFn(this)" data-val="8" ><span class="b-btm-top"></span><span>8</span></td>
                    <td onclick="posCalcFn(this)" data-val="9" ><span class="b-btm-top"></span><span>9</span></td>
                    <td data-symbol="equal" id="pos-add-btn" rowspan="2" valign="middle"><span class="material-icons"> drag_handle</span></td>
                  </tr>
                  <tr>
                    <td onclick="posCalcFn(this)" data-val="00"  colspan="2"><span class="b-btm-top"></span><span>00</span></td>
                    <td onclick="posCalcFn(this)" data-val="0" ><span class="b-btm-top"></span><span>0</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-5 custom-form">
        <div class="card content-card">
          <div class="card-title">
            Current Sales
          </div>
          <div class="card-detail">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="">Amount</label>
                  <div class="input-group ">
                    <div class="input-group-addon">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" id="sub_amount" readonly placeholder="0.00" name="sub_amount">
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div id="added-amounts"> </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="">Tax</label>
                  <div class="input-group ">
                    <div class="input-group-addon">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" id="totaltax" readonly placeholder="0.00"  name="totaltax">
                  </div>
                  <div class="custom-checkbox">
                    <input type="checkbox" name="tax" id="carrent_sales_tax" data-tax="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>">
                    <label for="carrent_sales_tax">Apply Tax</label>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="">Total</label>
                  <div class="input-group ">
                    <div class="input-group-addon">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" id="amount" readonly  placeholder="0.00" name="amount" required>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <button type="button" class="btn btn-first" onclick="resetThis()">Reset</button>
                  <button type="submit" name="submit" class="btn btn-second">Charge</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- </form> -->
    <?php echo form_close(); ?> 
  </div>
</div>
<!-- End Page Content -->
<script>
function virtualTerValidateForm() {
    var x = document.forms["my_form"]["amount"].value;
    if (x == "") {
        alert("Amount must be filled out");
        return false;
    }
}
function resetThis(){
  $('#sidebar-menu  a.virtual-terminal').trigger('click');
}
</script>
<?php
include_once'footer_new.php';
?>