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
            <span>View Tax List</span>
            <a class="btn btn-custom1" href="<?php echo base_url('merchant/add_tax'); ?>"><span>Add New Tax</span> <span class="material-icons">add</span></a>
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
                          <th>Percentage</th>
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
                          <td><?php echo $a_data['title'] ?></td>
                          <td><?php echo $a_data['percentage'] ?></td>
                          <td><a href="#" class="<?php if($a_data['status']=='active') { echo 'pos_Status_c'; } elseif( $a_data['status']=='block'){ echo 'pos_Status_cncl'; } ?>"><?php echo $a_data['status'] ?></a></td>
                          <td>
                            <a href="<?php  echo site_url('merchant/edit_tax/' . $a_data['id']) ?>" class="tax-edit-btn">Edit</a>
                          </td>
                          <td>
                            <div  class="start_stop_tax  <?php if($a_data['status']=='active') { echo 'active'; }?>" 
                              rel="<?php echo $a_data['id'];?>">
                          <!--  <div class="start_stop_tax  <?php if($a_data['status']=='active') { echo 'active'; }?>" onclick="<?php if($a_data['status']=='active') { ?>stop_pak<?php } elseif( $a_data['status']=='block'){ ?>start_pak<?php } ?>(<?php echo $a_data['id'];?>)">-->
                              <label class="switch switch_type1" role="switch">
                                <input type="checkbox" class="switch__toggle" <?php if($a_data['status']=='active') { echo 'checked'; } elseif( $a_data['status']=='block'){ echo ''; } ?>>
                                <span class="switch__label">|</span>
                              </label>
                              <span class="msg">
                                <span class="stop">Stop</span>
                                <span class="start">Start</span>
                              </span>
                            </div>
                          </td>
                        </tr>
                      <?php $i++;}?>
                    <!-- <tr>
                        <td>02</td>
                        <td>Andrew</td>
                        <td>30%</td>
                        <td><a href="#" class="pos_Status_c">Active</a></td>
                        <td>
                          <a href="#" class="tax-edit-btn">Edit</a>
                        </td>
                        <td>
                          <div class="start_stop_tax active">
                            <label class="switch switch_type1" role="switch">
                              <input type="checkbox" class="switch__toggle" checked>
                              <span class="switch__label">|</span>
                            </label>
                            <span class="msg">
                              <span class="stop">Stop</span>
                              <span class="start">Start</span>
                            </span>
                          </div>
                        </td>
                    </tr> -->
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
<script >
  function stop_pak(id)
    {
      if(confirm('Are you sure Stop ?'))
      {
          $.ajax({
            url : "<?php echo base_url('merchant/stop_tex')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              location.reload(); 
               // $('#sidebar-menu ul.sub-menu  a.tax-list').trigger('click');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error  data');
            }
        });
      }
    }
  function start_pak(id)
    {
      if(confirm('Are you sure Start ?'))
      {
          $.ajax({
            url : "<?php echo base_url('merchant/start_tex')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              location.reload(); 
              // $('#sidebar-menu ul.sub-menu  a.tax-list').trigger('click');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error deleting data');
            }
        });
      }
    }

  function tax_delete(id)
    {
      if(confirm('Are you sure delete this ?'))
      {
          $.ajax({
            url : "<?php echo base_url('merchant/tax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               $('#sidebar-menu ul.sub-menu  a.tax-list').trigger('click');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
      }
    }
  jQuery(function($){
    $('.start_stop_tax,.start_stop_tax input[type="checkbox"]').on('click', function (e) {
      // stop - start
      e.preventDefault();
      // e.stopPropagation();
      // console.log('called')
      if($(this).closest('.start_stop_tax').hasClass('active')){
        stop_pak($(this).closest('.start_stop_tax').attr('rel'));
      }
      else{
        start_pak($(this).closest('.start_stop_tax').attr('rel'));
      }
      // return false;
    })
  })
</script>
<?php
include_once'footer_new.php';
?>
