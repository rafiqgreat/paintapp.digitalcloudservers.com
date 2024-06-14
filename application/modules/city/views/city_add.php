  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_city') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('city'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('city_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('city/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group row">
          <div class="col-md-12">
          	<label for="name" class="control-label"><?= trans('city_name') ?></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="">
          </div>
        </div>
        
        <div class="form-group row">          
          <div class="col-md-6">
          	<label for="name" class="control-label"><?= trans('country_name') ?></label>
            <select name="CountryId" id="CountryId" class="form-control">
              <option value="">Select Country</option>
              <?php foreach($countries as $country): ?>
                <option value="<?= $country['id']; ?>"><?= $country['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
          	<label for="state_id" class="col-md-2 control-label">State</label>
            <select name="state_id" id="state_id" class="form-control" required>
            	<option>Select State</option>
            </select>
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-6">
            <label for="sequence" class="control-label"> <?= trans('sequence') ?></label>
            <input type="number" name="sequence" value="" class="form-control" id="sequence" placeholder="" required>
          </div>
          <div class="col-md-6">
            <label for="to_display" class="control-label">To Display</label>
            <select name="to_display" class="form-control">
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
        </div>
       
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_city') ?>" class="btn btn-primary pull-right">
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
                url: '<?php echo base_url("city/check_name_exist"); ?>',
                method: 'POST',
                data: {name: name},
                success: function(response){
                    //alert (response);
					if(response == 1){
                        alert('City already exists');
                        // You can add further actions here, like disabling form submission
						$('#name').val(''); // Clear the input field
                    }
                }
            });
        });
    });
</script>
<script>
$(document).on("change", "#CountryId", function(){
	$.post( '<?=base_url("city/state_by_country")?>', {
			'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
			CountryId: this.value
		},
		function ( data ) {
			arr = $.parseJSON( data );
			console.log( arr );
			$( '#state_id option:not(:first)' ).remove();
			$.each( arr, function ( key, value ) {
				$( '#state_id' )
					.append( $( "<option></option>" )
						.attr( "value", value.id )
						.text( value.name )
					);
			} );
		} );
} );
</script>
