<?php 
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>

<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper all-users-page">   
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title">
            <span>View All Employee</span>
            <a class="btn btn-custom1" href="<?php echo base_url('merchant/add_employee'); ?>"><span>Add Employee</span> <span class="material-icons">add</span></a>
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
                <table id="dt_all_Emp_list" class="display salequick-dt" style="width:100%">
                  <thead>
                      <tr>
                          <th width="7%">St No.</th>
                          <th>Name</th>
                          <th width="16%">Email</th>
                          <th width="12%">Phone</th>
                          <th width="10%">View</th>
                          <th width="14%">Create Payment</th>
                          <th width="10%">Status</th>
                          <th width="5%" class="no-event"></th>
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
                          <td><?php echo $a_data['email'] ?></td>
                          <td><?php echo $a_data['mob_no'] ?></td>
                          <td><?php if($a_data['view_permissions']=='1') {echo 'Yes';} elseif($a_data['view_permissions']=='0'){ echo 'No';} ?></td>
                          <td><?php if($a_data['create_pay_permissions']=='1') {echo 'Yes';} elseif($a_data['create_pay_permissions']=='0'){ echo 'No';} ?></td>

                          <td>
                            <a href="#" class="<?php if($a_data['status']=='active') { echo 'pos_Status_c'; } elseif( $a_data['status']=='block'){ echo 'pos_Status_cncl'; } ?>"><?php echo $a_data['status'] ?></a>
                          </td>

                          <td>
                            <div class="dropdown dt-vw-del-dpdwn">
                              <button type="button" data-toggle="dropdown">
                                <i class="material-icons"> more_vert </i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item edit_users" href="<?php  echo base_url('merchant/edit_employee/' . $a_data['id']) ?>">Edit</a>
                                <a class="dropdown-item dt-delete-c-row" href="#" onclick="employee_delete(<?php echo $a_data['id'];?>)">Delete</a>
                              </div>
                            </div>
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
<script type="text/javascript">
function employee_delete(id)
{
    if(confirm('Are you sure delete this Employee?'))
    {
      $.ajax({
            url : "<?php echo base_url('merchant/employee_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
    }
}
</script>

<?php
include_once'footer_new.php';
?>
