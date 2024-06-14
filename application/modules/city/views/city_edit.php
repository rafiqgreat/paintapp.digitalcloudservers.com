<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper"> 
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-pencil"></i> &nbsp;
            <?= trans('edit_city') ?>
          </h3>
        </div>
        <div class="d-inline-block float-right"> <a href="<?= base_url('city'); ?>" class="btn btn-success"><i class="fa fa-list"></i>
          <?= trans('city_list') ?>
          </a>
          <?php if($this->rbac->check_operation_permission('add')): ?>
          <a href="<?= base_url('city/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i>
          <?= trans('add_new_city') ?>
          </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-body"> 
        
        <!-- For Messages -->
        <?php $this->load->view('template/_messages.php') ?>
        <?php echo form_open(base_url('city/edit/'.$city['id']), 'class="form-horizontal"' )?>
        <div class="form-group row">          
          <div class="col-md-12">
          	<label for="name" class="control-label"><?= trans('city_name') ?></label>
            <input type="text" name="name" value="<?= $city['name']; ?>" class="form-control" id="name" required>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
          	<label for="CountryId" class="col-md-2 control-label"><?= trans('country_name') ?></label>
            <select name="CountryId" id="CountryId" class="form-control">
            	<option>Select Country</option>
              <?php foreach($countries as $country): ?>
              	<option value="<?= $country['id']; ?>" <?php if($country['id']==$city['CountryId']){echo 'selected';}?>> <?= $country['name']; ?> </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
          	<label for="state_id" class="col-md-2 control-label">State</label>
            <select name="state_id" id="state_id" class="form-control" required>
            	<option>Select State</option>
            	<?php 
				$states = $this->city_model->get_state_by_country_id($city['CountryId']);
				if(!empty($states)){
					foreach($states as $state): ?>
					<option value="<?= $state['id']; ?>" <?php if($state['id']==$city['state_id']){echo 'selected';}?>> <?= $state['name']; ?> </option>
				<?php endforeach; 
				}?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <label for="sequence" class="control-label"> <?= trans('sequence') ?> </label>
            <input type="number" name="sequence" value="<?= $city['sequence']; ?>" class="form-control" id="sequence" placeholder="" required>
          </div>
          <div class="col-md-6">
            <label for="to_display" class="control-label">To Display</label>
            <select name="to_display" class="form-control">
              <option value="1" <?= ($city['to_display'] == 1)?'selected': '' ?> >Yes</option>
              <option value="0" <?= ($city['to_display'] == 0)?'selected': '' ?>>No</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('update_city') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close(); ?> </div>
      <!-- /.box-body --> 
    </div>
  </section>
</div>
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