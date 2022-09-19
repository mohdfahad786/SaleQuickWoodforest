<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    .action-styling {
        color: black !important;
        text-decoration: underline !important;
    }
    .add-payment-link {
        width: auto;
        height: 40px;
        background: rgb(237, 237, 237);
        border: none;
        border-radius: 8px;
        color: rgb(132, 132, 132);
        font-size: 16px;
        font-weight: 400;
        padding: 10px 20px 10px 20px;
        font-family: Avenir-Black !important;
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
            <?php if (count($mem) < 1 ) { ?>
                <div class="row">
                    <div class="col-12 py-5 py-5-custom text-right">
                        <a class="add-payment-link" href="<?php echo base_url('charges/add_charges'); ?>"><i class="fa fa-plus"></i>  Add New Charge  </a>
                    </div>
                </div>
            <?php } ?>

            <?php $count = 0; ?>
            <div class="row">
                <div class="col-12">
                    <!-- <div class="reset-dataTable"> -->
                        <table id="dt_view_tax_list" class="hover row-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-priority="0">SR NO</th>
                                    <th >Name</th>
                                    <th >Type</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                    <th class="no-event"></th>
                                    <th class="no-event" data-priority="1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach($mem as $a_data) {
                                    $count++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $a_data['title'] ?></td>
                                        <td><?php echo $a_data['type'] ?></td>
                                        <td><?php echo $a_data['percentage'] ?></td>
                                        <td><a href="#" class="<?php if($a_data['status']=='active') { echo 'pos_Status_c'; } elseif( $a_data['status']=='block'){ echo 'pos_Status_cncl'; } ?>"><?php echo $a_data['status'] ?></a></td>
                                        <td>
                                            <a href="<?php  echo site_url('charges/edit_charges/' . $a_data['id']) ?>" class="tax-edit-btn">Edit</a>
                                        </td>
                                        <td>
                                            <div class="start_stop_tax <?php if($a_data['status']=='active') { echo 'active'; }?>" rel="<?php echo $a_data['id'];?>">
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
                                    <?php $i++;
                                }?>
                            </tbody>
                        </table>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script >

  function stop_pak(id)

    {

      if(confirm('Are you sure Stop ?'))

      {

          $.ajax({

            url : "<?php echo base_url('charges/stop_charges')?>/"+id,

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

            url : "<?php echo base_url('charges/start_charges')?>/"+id,

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

<?php include_once'footer_dash.php'; ?>