  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_profession') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('profession'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('profession_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('profession/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="profession_name" class="col-md-2 control-label"><?= trans('profession_name') ?></label>

          <div class="col-md-12">
            <input type="text" name="profession_name" class="form-control" id="profession_name" placeholder="">
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_profession') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#profession_name').on('submit', function(){
            var name = $(this).val();
            $.ajax({
                url: '<?php echo base_url("profession/check_name_exist"); ?>',
                method: 'POST',
                data: {name: profession_name},
                success: function(response){
                    //alert (response);
					if(response){
                        alert('Profession already exists');
                        // You can add further actions here, like disabling form submission
						$('#profession_name').val(''); // Clear the input field
                    }
                }
            });
        });
    });
</script>
