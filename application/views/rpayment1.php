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

<link rel="icon" type="image/png" href="img/favicon.png">
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
                           <div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 5px;">
                        <img src="https://salequick.com/logo/<?php echo $itemm[0]['logo']; ?>" style="width: calc(84px - 10px);height: calc(84px - 10px);margin-top: 0px;border-radius: 50%;" />
                      </div>
                              <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center;font-weight:600">$<?php echo number_format($amount,2)  ;?> <br />
                    
                    <?php echo ucwords($recurring_type)  ;?>
                    </h3>
                                </div>
              </div>
              <div style="background-color: #437ba8;overflow: hidden;">
                    <div style="width:80%;text-align:right;margin:20px auto;">
                              <div style="display:block;margin-bottom:10px;overflow: hidden;margin-top:0px;">
                          <div style="width:33.3%;float:left;text-align:center">
                            <span >Discription </span>
                            </div>
                          <div style="width:33.3%;float:left;text-align:center">
                            <span>Start Date </span>
                    
                          </div>
                            <div style="width:33.3%;float:left;text-align:center">
                            <span> <?php   $originalDate = $date_c;
$newDate = date("F d,Y", strtotime($originalDate)); echo $newDate;  ?> </span>
                        
                          </div>
                          <!--<span style="float:left">Start Date </span>
                        <span style="float:right">January 8,2020</span>-->
                    </div>
                      <div style="clear:both"></div>
                      <hr style="margin-top: 5px; margin-bottom: 10px; border: 0; border-top: 1px solid #eee;">
                        <div style="display:block;margin-bottom:25px;overflow: hidden;">
                        <div style="width:33.3%;float:left;text-align:center">
                            <span><?php echo $detail  ;?> </span>
                            </div>
                          <div style="width:33.3%;float:left;text-align:center">
                            <span>End Date</span>
                            </div>
                            <div style="width:33.3%;float:left;text-align:center">
                            <span>
                              <?php 

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
                        
                        
$newDatee = date("F d,Y", $datee); echo $newDatee;  ?> </span>
                            </div>
                      </div>
                        <span style="margin-right:-43px;margin-top: -30px; display: block;">
                          <?php echo $recurring_count  ;?>  Payment
                    </span>
                   
                </div>
              </div>
          </div>
                <div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
                  <div style="width:80%;margin:0 auto;overflow:hidden">
                    <div style="width:60%;margin:10px auto 20px;">
                        <input type="text" placeholder="Name On Card" style="font-size:16px;width: 100%;  height: 45px; border: 1px solid #7aabd4; border-radius: 30px;text-align: center;background: #ddd;"  />
                  </div>
                <div style="width:60%;margin:10px auto 20px;">
                      <input type="text" placeholder="Card Number" style="font-size:16px;width: 100%;  height: 45px; border: 1px solid #7aabd4; border-radius: 30px;text-align: center;background: #ddd;" />
                  </div>
                  <div style="width:60%;margin:10px auto 20px;overflow:hidden">
                      <input type="text" placeholder="Expriry Date" style="float:left;font-size:16px;width:200px;  height: 45px; border: 1px solid #7aabd4; border-radius: 30px;text-align: center;background: #ddd;" />
                      <input type="text" placeholder="CVV Number" style="float:left;font-size:16px;width:200px;margin-left: 25px;height: 45px; border: 1px solid #7aabd4; border-radius: 30px;text-align: center;background: #ddd;" />
                  </div>
                <div style="width:60%;margin:10px auto 20px; text-align:center;overflow:hidden">
  <form action="<?php echo base_url('rpayment');?>/<?php echo $this->uri->segment(2) ?>/<?php echo  $this->uri->segment(3) ?>" method="post">

                   <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($bct_id1) && !empty($bct_id1)) ? $bct_id1 : set_value('bct_id1');?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($bct_id2) && !empty($bct_id2)) ? $bct_id2 : set_value('bct_id2');?>" readonly required>
                       <!--  <button style="color: #fff;display: inline-block; font-size: 16px;font-weight: 400; padding: 15px 30px;z-index: 1;border-radius: 30px;border:0px;background-color: #79b949;font-family: inherit;">
                        Complete Payment Setup
                      </button> -->

                       <input  style="color: #fff;display: inline-block; font-size: 16px;font-weight: 400; padding: 15px 30px;z-index: 1;border-radius: 30px;border:0px;background-color: #79b949;font-family: inherit;" type="submit" name="submittt"  value="Complete Payment Setup">
  
  
  
  
</form>

                      </div>
                    <div style="clear:both"></div>
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
