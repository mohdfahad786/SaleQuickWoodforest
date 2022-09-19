<!DOCTYPE html>

<html dir="ltr" lang="en">
<head>

<!-- Meta Tags -->

<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="SaleQuick">
<meta name="keywords" content="SaleQuick">
<meta name="author" content="SaleQuick">

<!-- Facebook Pixel Code -->


<!-- Title -->

<title>:: Sale Quick ::</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<style>

.wrapper {
  position: relative;
  width: 400px;
  height: 200px;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.signature-pad {
  position: absolute;
  left: 0;
  top: 0;
  width:400px;
  height:200px;
  background-color: white;
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
                              <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center;font-weight:600">
                        $<?php echo number_format($amount,2)  ;?><br />
                          <?php echo ucwords($recurring_type)  ;?>
                    </h3>
                            </div>
              </div>
              <div style="background-color: #437ba8;overflow: hidden;">
                    <div style="width:80%;text-align:right;margin:20px auto;">
                              <div style="display:block;margin-bottom:10px;overflow: hidden;margin-top:0px;">
                          <div style="width:33.3%;float:left;text-align:center">
                            <span>Discription</span>
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
                            <span><?php echo $detail  ;?></span>
                            </div>
                          <div style="width:33.3%;float:left;text-align:center">
                            <span>End Date</span>
                            </div>
                            <div style="width:33.3%;float:left;text-align:center">
                            <span><?php 

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
                        
                        
$newDatee = date("F d,Y", $datee); echo $newDatee;  ?>  </span>
                            </div>
                      </div>
                        <span style="margin-right:-43px;margin-top: -30px; display: block;">
                          <?php echo $recurring_count  ;?> Payment
                    </span>
                    </div>
              </div>
          </div>
                <div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
                  <div style="width:80%;margin:0 auto;overflow:hidden">
                    <div style="width:60%;margin:10px auto 20px;text-align:center">
                      <!-- <img src="https://salequick.com/logo/<?php echo $itemm[0]['logo']; ?>"  style="width: 64px; height: 64px;margin:0px auto;" /> -->


<div class="wrapper">
  <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
</div>

<button id="save-png" >Save as PNG</button>
<button id="save-jpeg" style="display: none">Save as JPEG</button>
<button id="save-svg" style="display: none">Save as SVG</button> 
<button id="draw">Draw</button>
<button id="erase">Erase</button>
<button id="clear">Clear</button>

                  </div>
               
                <hr style="margin-top: 5px; margin-bottom: 20px; border: 0; border-top: 1px solid #eee;">
              
                <div style="width:60%;margin:10px auto 20px; text-align:center;overflow:hidden">

                   <form action="<?php echo base_url('rpayment');?>/<?php echo $this->uri->segment(2) ?>/<?php echo  $this->uri->segment(3) ?>" method="post">

                   <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($bct_id1) && !empty($bct_id1)) ? $bct_id1 : set_value('bct_id1');?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($bct_id2) && !empty($bct_id2)) ? $bct_id2 : set_value('bct_id2');?>" readonly required>
      
        <input type="hidden" class="form-control" name="sign" id="sign"  value="" readonly required>
        <input type="hidden" class="form-control" name="ip_a" id="ip_a"  value="<?php echo $_SERVER['REMOTE_ADDR'] ?>" readonly required>
                 

                    <button style="width:200px;color:#868484;display: inline-block; font-size: 20px;font-weight: 400; padding: 20px 30px;z-index: 1;border-radius: 15px;border:0px;background-color:#ebebeb;font-family: inherit;border:1px solid #ccc;">
                       Clear Signature 
                      </button>
                      &nbsp;
                    
                    
                   <!--  <button style="width:200px;color: #fff;display: inline-block; font-size: 20px;font-weight: 400; padding: 20px 30px;z-index:1;border-radius:15px;border:0px;background-color:#7aabd4;font-family:inherit;border:1px solid #ccc;">
                        Done
                      </button> -->

                       <input  style="width:200px;color: #fff;display: inline-block; font-size: 20px;font-weight: 400; padding: 20px 30px;z-index:1;border-radius:15px;border:0px;background-color:#7aabd4;font-family:inherit;border:1px solid #ccc;" type="submit" name="submit"  value="Done">
  
  
  
  
</form>
                  </div>
                <div style="clear:both"></div>
                          </div>
              </div>
              <footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
              <div style="text-align:center;width:80%;margin:0 auto">
                    <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">Feel free to contact us any time with  question and concerns.</h5>
                  <p><a style="color:#4a91f9;cursor:pointer;"><?php echo $itemm[0]['email']; ?></a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;"><?php echo $itemm[0]['mob_no']; ?></a></p>
                <br />
                  <!--<p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>-->
                  <!--<p style="color: #868484;">You are receiving something because purchased something at Company name</p>-->
                  <p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
                  <p style="text-align:right"><a href="https://salequick.com/terms_and_condition">Terms</a>&nbsp;|<a href="https://salequick.com/privacy_policy">Privacy</a></p>
                </div>
            </footer>
        </div>


<script>
var canvas = document.getElementById('signature-pad');

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});

document.getElementById('save-png').addEventListener('click', function () {
  if (signaturePad.isEmpty()) {
    return alert("Please provide a signature first.");
  }
  
  var data = signaturePad.toDataURL('image/png');
  document.getElementById("sign").value = data;
  console.log(data);
  //window.open(data);
});

document.getElementById('save-jpeg').addEventListener('click', function () {
  if (signaturePad.isEmpty()) {
    return alert("Please provide a signature first.");
  }

  var data = signaturePad.toDataURL('image/jpeg');
  console.log(data);
  window.open(data);
});

document.getElementById('save-svg').addEventListener('click', function () {
  if (signaturePad.isEmpty()) {
    return alert("Please provide a signature first.");
  }

  var data = signaturePad.toDataURL('image/svg+xml');
  console.log(data);
  console.log(atob(data.split(',')[1]));
  window.open(data);
});

document.getElementById('clear').addEventListener('click', function () {
  signaturePad.clear();
});

document.getElementById('draw').addEventListener('click', function () {
  var ctx = canvas.getContext('2d');
  console.log(ctx.globalCompositeOperation);
  ctx.globalCompositeOperation = 'source-over'; // default value
});

document.getElementById('erase').addEventListener('click', function () {
  var ctx = canvas.getContext('2d');
  ctx.globalCompositeOperation = 'destination-out';
});

</script>
    </body>
</html>
