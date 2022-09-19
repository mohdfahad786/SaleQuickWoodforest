<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
      #drop_file_zone {
        /*background-color: #EEE;*/
        background: #F4F7FF;
        background: -webkit-linear-gradient(to top, #F4F7FF, #fff);
        background: linear-gradient(to top, #F4F7FF, #fff);
        border: #999 2px dashed;
        width: 100%;
        height: 200px;
        padding: 8px;
        font-size: 18px;
        margin: auto;
        margin-bottom: 20px;
        border-radius: 20px;
    }
    #drag_upload_file {
        width:50%;
        margin:0 auto;
    }
    #drag_upload_file p {
        text-align: center;
        color: #B0B3BC;
        font-size: 16px;
    }
    #drop_button {
        background-color: #5976C6;
        color: #fff;
        font-weight: 500;
        border: none;
        padding: 2px 10px;
        border-radius: 5px;
    }
    #drag_upload_file #selectfile {
        display: none;
    }
    .grid-body {
        padding: 30px !important;
    }
  
    .card-type-no-wraper{
        display: block;
        width: 121px;
    }
    .dataTables_wrapper .dataTables_filter input {
        width: 220px !important;
        height: 45px!important;
        color: #4a4a4a;
        -webkit-box-shadow: 0 0;
        box-shadow: 0 0;
        padding-left: 35px;
        border-color: #e1e6ea;
        font-weight: normal;
        border-radius: 3px;
        background-image: url('<?php echo base_url('new_assets/img/search.svg') ?>');
        background-repeat: no-repeat;
        background-size: 25px;
        background-position: 5px center;
        border: none;
        border-radius: 5px;
    }
    .list-upload .thumbnail > ion-icon{
                font-size: 2em;
                /*color: hsla(235, 100%, 99%, 1);*/
                color: #fff;
                display: none;
        }
    
    .list-upload .thumbnail{
                position:relative ;
                width: 50px ;
                height: 50px;
                margin-right: 20px;
                border-radius: 7px;
                background-color: hsla(235, 100%, 78%, 1);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;

    }
    
    .list-upload .thumbnail i{
                font-size: 2em;
                color: hsla(235, 100%, 99%, 1);
                /*display: none;*/
    }
    
    /*.list-upload .thumbnail .completed{
                position: absolute;
                top: 50;
                right: -10px;
                margin-top: -10px;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background-color: #2ecc71;
                color: white;
                align-items: center;
                justify-content: center;
    }*/
    .list-upload :where(.completed,.remove){
            display: flex;
    }
    
    .list-upload .properties{
            display: flex;
            flex-direction: column;
            flex-basis: 100%;
            gap: 5px;
    }
    
    .list-upload .properties .title{
            word-break: break-word;
    }
    
    .list-upload .properties .size{
            color: #8f98ff;
            font-size: 12px;

    }
    
    .list-upload .properties :where(.progress,.buffer){
            position: sticky;
            display: block;
            width: 100%;
            height: 2px;
            background-color: hsla(235, 100%, 95%, 1);
    }
    
    .list-upload .properties .buffer{
            width: 100%;
            -webkit-background: linear-gradient(90deg,#82f4b1 0%,#2ecc71 100%);
            background: linear-gradient(90deg,#82f4b1 0%,#2ecc71 100%);
    }
    
    .list-upload .properties .percentage{
            position: absolute;
            left: 0;
            top: 15px;
            font-size: 15px;
            color: black;
    }
    
    /*.list-upload .remove{
            position: absolute;
            right: 0;
            top: 50%;
            border: 0;
            outline: 0;
            width: 20px;
            height: 20px;
            margin-top: -10px;
            border-radius: 50%;
            background-color: #ff6b81;
            color: white;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            -webkit-transition: all .3s ease-out;
            transition: all .3s ease-out;
    }*/
    .list-upload .remove:hover{
            background-color: #303030;
    }
    
    .file-list {
        display: flex !important;
        margin-bottom: 20px;
        border-radius: 10px;
        padding: 15px;
    }
    
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom"></div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="grid grid-chart" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <form method="POST" action="<?php echo base_url('merchant_document/edit_ongoing_notes/'.$merchant_id.'/'.$on_id); ?>">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto !important;">
                                            <div class="form-title">Add Ongoing Note for '<?php echo !empty($merchant->business_dba_name) ? $merchant->business_dba_name : $merchant->email; ?>'</div>
                                            
                                            <input type="hidden" name="merchant_id" value="<?php echo $merchant_id ?>" required>
                                            <input type="hidden" name="on_id" value="<?php echo $on_id ?>" required>
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input class="form-control" name="subject" id="subject" placeholder="Subject" value="<?php echo $ongoing_notes->subject ?>" required type="text" autocomplete="off">
                                            </div>
                                            <input type="hidden" name="srNo" id="srNo" value="<?php echo $ongoing_notes->note_sr_id ?>">
                                            <div class="form-group">
                                                <label>Ongoing Note</label>
                                                 <textarea class="form-control" name="note" id="note" placeholder="Ongoing Note" rows="8" required><?php echo $ongoing_notes->note ?></textarea>
                                            </div>
                                            
                                            <div class="form-group" style="margin-bottom: 0 !important;">
                                                <label>Attach New Files*</label>
                                                <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
                                                    <div id="drag_upload_file">
                                                        <p><i class="fa fa-cloud-upload" style="font-size: 46px;"></i></p>
                                                        <p>Drag & Drop files here</p>
                                                        <p>OR</p>
                                                        <p><input id="drop_button" type="button" value="Browse Files" onclick="file_explorer();" ></p>
                                                        <input type="file" id="selectfile" multiple>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="srNo" id="srNo" value="<?php echo $ongoing_notes->note_sr_id ?>">
                                                
                                                <!-- <div class="progress" style="width: 290px;margin: auto;">-->
                                                    <!-- <div class="progress-bar"></div>
                                                </div> --> 
                                            </div>
                                            <div class="form-group">
                                               
                                                <div class="list-upload">
                                                    <ul>
                                              
                                                    </ul>
                                                </div>     
                                            </div>
                                            
                                            <!-- <?php print_r($attachedFiles) ?>;  -->                                            
                                            <input type="submit" name="submit" value="submit" class="btn btn-first" style="width: 100% !important;border-radius: 5px !important;">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" id="message_success_popup" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="row">
                                    <div class="col-12">
                                        <div id="pdf_success_message"></div>
                                    </div>
                                </div>
                            </div>
                         </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?=base_url('new_assets/css/sweetalert.css')?>">
<script src="<?=base_url('new_assets/js/sweetalert.js')?>"></script>
<style type="text/css">
    .sweet-alert .btn {
        padding: 5px 15px;
    }
</style>
<script>




// function delAttachment(id){
//     alert(id);
//     return false;
// }
    var fileobj;
    var fName;
    var base_url = '<?php echo base_url() ?>';


    function upload_file(ev) {
        console.log("Files dropped");
        ev.preventDefault();
       
        fileobj = ev.dataTransfer.files;
        console.log(fileobj);
       
        ajax_file_upload(fileobj);
    }
     
    function file_explorer() {
        document.getElementById('selectfile').click();
        document.getElementById('selectfile').onchange = function() {
            fileobj = document.getElementById('selectfile').files;
            
            ajax_file_upload(fileobj);
        };
    }
     
    function ajax_file_upload(file_obj) {
        
        // console.log(file_obj[0].name);
        // console.log(file_obj[0].name.split('.').pop());
        var status=1;
        for (var i = 0; i < file_obj.length; i++) {
            //file_obj[i]
            console.log('i='+i);
            if(file_obj[i] != undefined) {
               var file_name = file_obj[i].name;
                var ext = file_name.split('.').pop();
                if( (ext == "pdf") || (ext == "jpg") || (ext == "jpeg") || (ext == "png") ){
                    
                } else {
                    status=0;
                    alert('Only JPEG, JPG, PDF & PNG file can be uploaded.');
                    return false;
                }
            }
            let uniq='id-'+btoa(file_name).replace(/=/g,'').substring(0,7)+i;
            console.log('file:'+file_name);
            console.log('uniq:'+uniq);
            // document.querySelector('.list-upload ul').innerHTML='<li class="file-list '+ext+'"  data-filename='+file_name+'" id='+uniq+'><div class="thumbnail"><img src="'+base_url+'new_assets/img/pdf.png"><span class="completed"><i class="fa-solid fa-circle-check"></i></span></div><div class="properties"><span class="title"><strong></strong></span><span class="size"></span><span class="progress"><span class="buffer"></span><span class="percentage">0%</span></span></div><button id="pdf_id" class="remove" onclick="remove_pdf();"><i class="fa-solid fa-circle-xmark"></i></button></li>'+document.querySelector('.list-upload ul').innerHTML;
            document.querySelector('.list-upload ul').innerHTML='<li class="file-list '+ext+'"  data-filename='+file_name+'" id='+uniq+'><div class="thumbnail"><i class="fa fa-file-pdf-o"></i><span class="completed"><img src="'+base_url+'new_assets/img/pdf_check.png"></span></div><div class="properties"><span class="title"><strong></strong></span><span class="size"></span><span class="progress"><span class="buffer"></span><span class="percentage">0%</span></span></div><button type="button" id='+uniq+' class="remove" style="border:none; background: transparent;"><img src="'+base_url+'new_assets/img/pdf_close.png" ></button></li>'+document.querySelector('.list-upload ul').innerHTML;

            //let li_el=document.querySelector('#'+file_name);
                    //console.log(li_el);
                    let li_el=document.querySelector('#'+uniq)
                    let name=li_el.querySelector('.title strong');
                    let size=li_el.querySelector('.size');
                    name.innerHTML=file_name;
                    size.innerHTML=bytesToSize(file_obj[i].size);
                    // console.log('name='+file_name);
                    // console.log('size='+size.innerHTML);
                    //return false;
            var srNo = $('#srNo').val();
            var form_data = new FormData();                  
            form_data.append('file', file_obj[i]);
            form_data.append('srNo', srNo);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                          let li_el=document.querySelector('#'+uniq);
                            let percent=Math.ceil((evt.loaded/evt.total)*100);
                            li_el.querySelector('.buffer').style.width=percent+'%';
                            li_el.querySelector('.percentage').innerHTML=percent+'%';
                            li_el.querySelector('.buffer').style.left=percent+'%';
                            if(evt.loaded==evt.total){
                                    li_el.querySelector('.completed').style.display=li_el.querySelector('.remove').style.display='flex';
                                    li_el.querySelector('.remove').addEventListener('click',function(){
                                            var data=new FormData();
                                           // data.append('removefile',file_name);
                                            //li_el.remove();   
                                    });
                            }

                        }
                    }, false);
                    return xhr;
                },
                type: 'POST', 
                dataType: "json",
                url: "<?php echo base_url('merchant_document/upload_pdf_file/'.$merchant_id); ?>",
                contentType: false,
                processData: false,
                data: form_data,
                success:function(response) {
                    console.log(response);
                    if(response.status == 200) {
                        $('.pdf_success_message').empty();
                        $('#pdf_id').val('');
                        $('#pdf_label').val('');
                        $('#pdf_success_message').html('<span style="color: #28a745 !important;"><strong>Success!</strong> '+response.message+'</span>');
                        $('#'+uniq).val(response.row_id);
                        var allRowId=allRowId+response.row_id+'<br>';

                        $("#message_success_popup").modal('show');

                    } else if(response.status == 501) {
                        fName=fName+file_name+'<br>';
                        $('.pdf_error_message').empty();
                        $('.pdf_error_message').html('<span style="color: red !important;"><strong>Error!</strong> '+response.message+'</span>');
                        $("#message_error_popup").modal('show');

                    } else {
                        console.log(response);
                    }
                }
            });
        }
    }
    function bytesToSize(bytes){
            const units=["byte","kilobyte","megabyte","gigabyte","terabyte"];
            const unit=Math.floor(Math.log(bytes)/Math.log(2014));
            return new Intl.NumberFormat("en",{style:"unit",unit:units[unit]}).format(bytes/1024** unit);
    }
$(document).on('click', '.remove', function() {
        var wrapper = $(this).parent();
        var file_id = $(this).parent().val();
    // var onId='<?php echo $on_id ?>';
    
    //var base_url = '<?php echo base_url() ?>';
    // var path=base_url+'Merchant_document/delPdf/'+id;
    // alert(path);
    //window.location.replace(path);
     swal({
            title: "<span style='font-size: 21px;'>Alert</span>",
            text: "<span style='font-size: 16px;'>Are you sure to delete this file?</span>",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn danger-btn",
            confirmButtonText: "Delete",
            cancelButtonClass: "btn btn-first",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('merchant_document/delPdf/'); ?>'+file_id,
                    data: "",
                    dataType: "JSON",
                    success: function(response1) {
                        // console.log(response1);
                        if(response1.status == 200) {
                            console.log('aa');
                            $('.pdf_success_message').empty();                                
                            $('#pdf_success_message').html('<span style="color: #28a745 !important;"><strong>Success!</strong> '+response1.message+'</span>');

                            $("#message_success_popup").modal('show');
                            // console.log('wrapper');
                            // console.log(wrapper);

                            wrapper.remove();

                        } else if(response1.status == 501) {
                            // console.log('bb');
                            $('.pdf_error_message').empty();
                            $('.pdf_error_message').html('<span style="color: red !important;"><strong>Error!</strong> '+response1.message+'</span>');
                            $("#message_error_popup").modal('show');

                        }
                    }
                })
            }
            
        })
})



$(document).ready(function() {
    // var d='';
    
    var base_url = '<?php echo base_url() ?>';
    var attachFile=<?php echo json_encode($attachedFiles); ?>;
    // for (var i = ; i <= attachFile.length; i++) {
    //     d=d+attachFile[i]+',';
    // }
    console.log(attachFile.length);
    
    for(var i=0;i<attachFile.length;i++){
        var uniq= attachFile[i]['id'];
    var file_name=attachFile[i]['attachment'];
    document.querySelector('.list-upload ul').innerHTML='<li class="file-list "  data-filename='+file_name+'" id='+uniq+' value='+uniq+'><div class="thumbnail"><i class="fa fa-file-pdf-o"></i><span class="completed"><img src="'+base_url+'new_assets/img/pdf_check.png"></span></div><div class="properties"><span class="title"><strong>'+file_name+'</strong></span><span class="size"></span><span class="progress"><span class="buffer"></span><span class="percentage">0%</span></span></div><button type="button" class="remove" style="border:none; background: transparent;"><img src="'+base_url+'new_assets/img/pdf_close.png"></button></li>'+document.querySelector('.list-upload ul').innerHTML;

    }

});
</script>
<?php include_once'footer_dash.php'; ?>