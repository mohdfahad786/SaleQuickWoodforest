<!DOCTYPE html>

<html dir="ltr" lang="en">
<head>
    
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="SaleQuick">
<meta name="keywords" content="SaleQuick">
<meta name="author" content="SaleQuick">
<!-- Facebook Pixel Code -->


<!-- Title -->

<title>:: Sale Quick ::</title>

<!-- Favicon Icon -->

<link rel="icon" type="image/png" href="https://salequick.com/front1/images/logo-w.png">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

    <style>
.table {
  font-family: 'Fira Sans', sans-serif;
}
.table-striped>tbody>tr:nth-of-type(odd) {
/* background-color: #7aabd4;*/
   
}
th {
  text-align: right;
  font-weight: normal !important;
}
.midle {
  width: 80%;
  margin: 0 auto;
}
.midle3 {
  width: 80%;
  margin: 0 auto;
}
.midle2 {
  width: 60%;
}

.midle4 {
  width: 280px;
  margin: 0 auto; 
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
  /*border: 1px solid #7aabd4;*/
  border: none !important;
  border-bottom: 1px solid #eee !important;
  font-size: 16px;
  font-weight: 400;
  margin-left: 30px;
  margin-top: 10px;
  margin-bottom: 10px;
  color: #000;
}
.input1 {
  width: 30%;
}
.table-bordered>tbody>tr>th {
  text-align: right;
  color: #868484;
  font-size: 18px;
  margin-top: 10px;
  margin-bottom: 10px;
}
.table-bordered {
  border: none !important;
}


.payment_icon{ 
  background:url(https://salequick.com/email/images/payment_icon2.png); 
  background-repeat:no-repeat; 
  /*background-position:right center;*/
  background-position: 90% 53%; 
  padding-right: 76px !important;
}





 @media screen and (max-width: 600px) {
.midle {
  width: 100%
}
.midle3 {
  width: 100%
}
.midle2 {
  width: 100%
}

.midle4 {
  width: 100%
  margin: 0 auto; 
}
.input1 {
  width: 45%;
}
.Item_Name {
  max-width: 60px;
  word-wrap: break-word;
  word-break: break-word;
  white-space: unset;
}


}
</style>
    </head>
<body style="padding: 0px;margin: 0;font-family: 'Fira Sans', sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">
    <div style="max-width: 900px;margin: 0 auto;">
              <div style="color:#fff;">
              <div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">



                  <div class="" style="width:80%;margin:0 auto;">
                            <div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 5px;display: flex;align-items: center;justify-content: center;">
                        <img src="https://salequick.com/logo/<?php echo $itemm[0]['logo']; ?>" style="width: calc(84px - 10px);height: calc(84px - 10px);margin-top: 0px;border-radius: 50%;" />
                      </div>
                              <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center;font-weight:600">Sign up for recurring Payment  with <?php echo  $itemm[0]['business_name']; ?></h3>
                            <hr style="margin-top: 20px;  margin-bottom: 20px; border: 0;border-top: 1px solid #eee;" />

        <?php if($resend!='') { ?>
                            
                          <div style="float:left;width:45%;padding:0 15px;text-align:right;">

                        <span>
                           <?php echo $invoice_no ;?>
                        </span>
                    </div>
                        <div style="float:left;width:45%;padding:0 15px;text-align:left;">
                          <span>
                            <?php   $originalDate = $date_c;
$newDate = date("F d,Y", strtotime($originalDate)); echo $newDate;  ?>
                        </span>
                    </div>
                          </div>
              </div>
              <div style="background-color: #437ba8;overflow: hidden;">
                      <h2 class="m-b-20" style="font-size:30px;margin:20px 0;text-align:center">
                     
                      $<?php echo number_format($amount,2)  ;?> <?php echo ucwords($recurring_type)  ;?>    <span style="font-size:16px;font-weight:400;padding-left:15px;"><?php echo $recurring_count  ;?>  Payment</span>
                </h2>
                  </div>
          </div>

                <div style="padding: 40px 0 40px;overflow:hidden;background:#fff">

<div class="midle3" style="text-align:right;margin:20px auto;">
        <div style="display:block;margin-bottom:25px;" class="table-responsive1">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered" >
            <tr>
              <th scope="col">Item Name</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">Tax</th>
              <th scope="col">Amount</th>
            </tr>
             <?php



foreach ($item as $rowp) { 

$item_name =  str_replace(array('\\', '/'), '', $rowp['item_name']);

$quantity =  str_replace(array('\\', '/'), '', $rowp['quantity']);

$price =  str_replace(array('\\', '/'), '', $rowp['price']);

$tax =  str_replace(array('\\', '/'), '', $rowp['tax']);

$tax_id =  str_replace(array('\\', '/'), '', $rowp['tax_id']);

$total_amount =  str_replace(array('\\', '/'), '', $rowp['total_amount']);

 $item_name1 = json_decode($item_name);

   $quantity1 = json_decode($quantity);

 $price1 = json_decode($price);

  $tax1 = json_decode($tax);

  $tax_id1 = json_decode($tax_id);

  $total_amount1 = json_decode($total_amount);

  $i = 0; 
  
  

 foreach ($item_name1 as $rowpp) {
  //if($quantity1[$i] > 0 ){
if($quantity1[$i] > 0 && $item_name1[$i]!='Labor'){
 ?>
            <tr>
              <td class="Item_Name"><?php echo $item_name1[$i] ;?></td>
              <td><?php echo $quantity1[$i] ;?></td>
              <td>$ <?php echo number_format($price1[$i],2) ;?></td>
              <td><?php
              
             // echo  $tax1[$i]; 
             
        $tax_a = $total_amount1[$i] - ($price1[$i]*$quantity1[$i]);
        
         if( $price1[$i]*$quantity1[$i] >= $total_amount1[$i] ){
             
             echo '0.00';
         }
         else
         {
              echo  number_format($tax_a,2)  ;
         }
               
               ?></td>
              <td>$<?php   echo $number = number_format($total_amount1[$i],2);
              


              
              ;?></td>
            </tr>
            <?php

  } $i++; } 


   $j = 0; 
   $data = array();
    $data1 = array();

 foreach ($item_name1 as $rowpp) {
 if($quantity1[$j] > 0 && $item_name1[$j]=='Labor'){
     
    $data[] =  $price1[$j];
    $data1[] =  $quantity1[$j];
 ?>
          
            <?php

 } 



 $j++; } 

//print_r($keys = $data);
//print_r($values = $data1);

//print_r(array_combine($qun,$ppr));

//function array_combine_($keys, $values)
//{
 //   $result = array();
  //  foreach ($keys as $i => $k) {
  //      $result[$k][] = $values[$i];
  //  }
  //  array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
   // return    $result;
   
  // print_r($result);
   
//}

//print_r(array_combine_($ppr, $qun));



$Array1 = $data;
$Array2 = $data1;

// Build the result here
$Array3 = [];

// There is no validation, the code assumes that $Array2 contains
// the same number of items as $Array1 or more
foreach ($Array1 as $index => $key) {
    // If the key $key was not encountered yet then add it to the result
    if (! array_key_exists($key, $Array3)) {
        $Array3[$key] = 0;
    }

    // Add the value associate with $key to the sum in the results array
    $Array3[$key] += $Array2[$index];
}

//print_r($Array3);

foreach ($Array3 as $index => $person) {
?>
 <tr>
              <td class="Item_Name">Labor</td>
              <td class="Item_Name"><?php echo $person ;?></td>
              <td class="Item_Name">$<?php echo $index ;?></td>
              <td class="Item_Name">0</td>
               <td class="Item_Name">$<?php echo number_format($index*$person,2) ;?></td>
             </tr>

  
  <?php 

}


} 



 ?>
            <tr  >
              <td colspan="3">Total Amount </td>
              <td colspan="2">$<?php echo number_format($amount,2) ;?></td>
            </tr>
              </td>
            
              </tr>
          </table>
</div>
</div>
                  <div style="width:80%;margin:0 auto;overflow:hidden">

                   <!--  <div style="float:left;width:50%;">
                      <h5 style="text-align:left;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Description</h5>
                  </div>
                <div style="float:left;width:50%;">
                      <h5 style="text-align:right;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Price</h5>
                  </div>
 -->



                   <!--  <div style="clear:both"></div>
                <hr style="border: 0; border-top: 1px solid #eee;" />
                      <div style="float:left;width:50%;">
                      <h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">Tire Rotaion</h5>
                  </div>
                  <div style="float:left;width:30%;">
                      <h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;font-weight:400;"><?php echo $recurring_count  ;?>  Payment</h5>
                  </div>

                <div style="float:left;width:20%;">
                      <h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $<?php echo number_format($amount,2)  ;?></b></h5>
                  </div> -->

                        <div class="clearfix" style="clear:both"></div>
                <hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #eee;" />
                        <div style="float:left;width:50%;text-align:right;margin-left:50%;">
                    <div style="display:block;margin-bottom:20px;overflow: hidden;margin-top:0px;">
                        <span style="float:left">Start Date </span>
                        <span style="float:right">
                     <?php   $originalDate = $date_c;
$newDate = date("F d,Y", strtotime($originalDate)); echo $newDate;  ?></span>
                    </div>
                    <div style="clear:both"></div>
                    <hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #eee;" />
                    <div style="display:block;margin-bottom:25px;overflow: hidden;">
                        <span style="float:left;">End Date</span>
                        <span style="float:right;"><b> <?php 

                          $start_date = $date_c;
                     $dateee = strtotime($start_date);
                     $b = 7*$recurring_count;
                      
                     $a = "+".$b.  "day";
                     $month_count = $recurring_count;
                     $month = "+".$month_count.  "months";
                     
                     $month_count1 = 3*$recurring_count;
                     $month1 = "+".$month_count1.  "months";
                     
                     $month_count2 = 6*$recurring_count;
                     $month2 = "+".$month_count2.  "months";
                     
                     $month_count3 = 12*$recurring_count;
                     $month3 = "+".$month_count1.  "months";

                          if($recurring_type =='weekly')

                          {
                          $datee = strtotime($a, $dateee);
                        }
                        elseif($recurring_type =='monthly')
                        {
                             $datee = strtotime($month, $dateee);
                        }
                        
                        
                        elseif($recurring_type =='quarterly')
                        {
                             $datee = strtotime($month1, $dateee);
                        }
                        
                        elseif($recurring_type =='half yearly')
                        {
                             $datee = strtotime($month1, $dateee);
                        }
                         elseif($recurring_type =='yearly')
                        {
                             $datee = strtotime($month1, $dateee);
                        }
                        
 if(!empty($recurring_count)){                      
$newDatee = date("F d,Y", $datee); echo $newDatee; } ?></b></span>
                      </div>
                 <form action="<?php echo base_url('rpayment');?>/<?php echo $this->uri->segment(2) ?>/<?php echo  $this->uri->segment(3) ?>" method="post">

 <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($bct_id1) && !empty($bct_id1)) ? $bct_id1 : set_value('bct_id1');?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($bct_id2) && !empty($bct_id2)) ? $bct_id2 : set_value('bct_id2');?>" readonly required>
                   <!--  <button style="color: #fff;display: inline-block; font-size: 16px;font-weight: 400; padding: 15px 30px;z-index: 1;border-radius: 30px;border:0px;background-color: #79b949;font-family: inherit;">
                    Setup auto charge
                      </button> -->

 
  <input  style="color: #fff;display: inline-block; font-size: 16px;font-weight: 400; padding: 15px 30px;z-index: 1;border-radius: 30px;border:0px;background-color: #79b949;font-family: inherit;" type="submit" name="submitt"  value="Setup auto charge">
  <br/>
  
  
  
</form>
 <?php } else { ?>
 	 <h1 style="text-align: center; border-radius: 50%; margin: 10px auto 20px; padding: 10px;"><?php echo $this->session->flashdata('pmsg'); ?></h1>
 	<?php } ?>
                </div>
                </div>
              </div>
             
              <footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
              <div style="text-align:center;width:80%;margin:0 auto">
                    <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">Feel free to contact us any time with  question and concerns</h5>
                  <p><a style="color:#4a91f9;cursor:pointer;"><?php echo $itemm[0]['email']; ?></a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;"><?php echo $itemm[0]['mob_no']; ?></a></p>
                <br />
                  <!--<p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>-->
                  <!--<p style="color: #868484;">You are receiving something because purchased something at Company name</p>-->
                  <p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
                  <p style="text-align:right"><a href="https://salequick.com/terms_and_condition">Terms</a>&nbsp;|<a href="https://salequick.com/privacy_policy">Privacy</a></p>
                </div>
            </footer>
        </div>
    </body>
</html>
