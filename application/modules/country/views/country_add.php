  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_country') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('country'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('country_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('country/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group row">
          <div class="col-md-12">
            <label for="name" class="control-label"><?= trans('country_name') ?></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="">
          </div>
        </div>
        <div class="form-group">
          	<div class="row">
                <div class="col-md-6">
                    <label for="sortname" class="control-label">Short Name</label>
                    <input type="text" name="sortname" value="" class="form-control" id="sortname" placeholder="" required>
                </div>
                <div class="col-md-6">
                    <label for="sortname" class="control-label">Phone Code</label>
                    <input type="number" name="phonecode" value="" class="form-control" id="phonecode" placeholder="" required>
                </div>
            </div>
          </div>
        <div class="form-group row">
            <div class="col-md-6">
            	<label for="name" class="control-label"><?= trans('sequence') ?></label>
              <input type="number" name="sequence" value="" class="form-control" id="name" placeholder="" required>
            </div>
          <div class="col-md-6">  
              <label for="to_display" class="control-label">To Display</label>
              <select name="to_display" class="form-control">
                  <option value="1">Yes</option>
                  <option value="0">No</option>
              </select>
          </div>
       </div>
        <div class="form-group row">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_country') ?>" class="btn btn-primary pull-right">
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
        $('#name').on('change', function(){
            var name = $(this).val();
            $.ajax({
                url: '<?php echo base_url("country/check_name_exist"); ?>',
                method: 'POST',
                data: {name: name},
                success: function(response){
                    //alert (response);
					if(response == 1){
                        alert('Country already exists');
						$('#name').val(''); // Clear the input field
                    }
                }
            });
        });
    });
</script>
