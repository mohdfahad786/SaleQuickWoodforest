<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
</head>
<body>

<!-- <h2><center>Hit Sql Query</center></h2> -->

<!-- <p>Resize the browser window to see the effect. When the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other.</p> -->

<div class="row">
  <div class="col-75">
    <div class="container">
     
      
        <div class="row">
          <div class="col-50">
            <!-- <h3>Write Your Sql Query Here..</h3> -->
            <?php     ?>
            <label for="fname"> Select data base</label>
           <Select name="databasename" class="form-control" id="databasename">
               <option>--  Select database --</option>
               
               <option value="SQdb" >SQdb</option>
                      </select>
           <label for="fname">Write Your Sql Query Here.. </label>
           <textarea name="sqldatastring" id="sqldatastring" cols="110" rows="10" class="form-control" placeholder="SELECT * FROM users"></textarea>
          </div>
          

          
          
        </div>
       
        <input type="hidden"  id="ip" name="ip" value="<?php echo  $_SERVER['REMOTE_ADDR'];  ; ?>"  />
        <input type="submit"  id="querybtn" value="Run Query" style="" onclick="getqueryresult()" />
        <br/>
        <div style="background-color:lightgray; min-height:20px;  width:100%; " id="resultmsg"></div>
        
     
    </div>
  </div>
  <div class="col-25">
  
  </div>
</div>
   <script>
      function getqueryresult()
      {
       
          let hb_base_url='<?php echo  base_url(); ?>';
          $("#querybtn").val('Wait....');
                $.ajax({
                            type: "POST",
                            url: hb_base_url + "welcome/hitsqlquery",
                            //contentType: "application/json",
                            //dataType: "json",
                            data:{ databasename: $("#databasename").val(), sqldatastring: $("#sqldatastring").val(),ip: $("#ip").val(),submit:'submitdata' },
                            success: function(response) {
                                //console.log(response);
                                $("#resultmsg").html(response);
                                $("#querybtn").val('Run Query');
                            },
                            error: function(response) {
                                console.log(response);
                                $("#resultmsg").html(response);
                                $("#querybtn").val('Run Query');
                            }
                    });
      }
            
   </script>
</body>
</html>