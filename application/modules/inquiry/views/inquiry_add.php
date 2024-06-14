  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_inquiry') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('inquiry'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('inquiry_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('inquiry/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group row">
          <div class="col-md-12">
          <label for="message" class="control-label"><?= trans('inquiry_name') ?></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="">
          </div>
        </div>
         <div class="form-group row">
          <div class="col-md-12">
          	<label for="message" class="control-label"><?= trans('inquiry_message') ?></label>
            <textarea name="message" class="form-control" id="message"></textarea>
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-12">
          	<label for="projectDetails" class="control-label"><?= trans('inquiry_projectDetails') ?></label>
            <textarea name="projectDetails" class="form-control" id="projectDetails"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-4">
          	<label for="CountryId" class="control-label"><?= trans('country_name') ?></label>
            <select name="CountryId" id="CountryId" class="form-control">
              <option value="">Select Country</option>
              <?php foreach($countries as $country): ?>
                <option value="<?= $country['id']; ?>"><?= $country['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
          	<label for="state_id" class="control-label">State Name</label>
            <select id="state_id" name="state_id" class="form-control">
                <option value="">Select State</option>                 
            </select>
            </div>
            <div class="col-md-4">
          	<label for="CityId" class="control-label"><?= trans('CityId') ?></label>
            <select name="CityId" class="form-control" id="CityId">
                <option value="">Select City</option>                 
            </select>
            </div>
        </div>
        <div class="form-group row">
          <div class="col-md-4">
          <label for="phone" class="control-label"><?= trans('inquiry_phone') ?></label>
            <input type="number" name="phone" class="form-control" id="phone" placeholder="">
          </div>
          <div class="col-md-4">
          <label for="email" class="control-label"><?= trans('inquiry_email') ?></label>
            <input type="email" name="email" class="form-control" id="email" placeholder="">
          </div>
          <div class="col-md-4">
          	<?php $statuses = array('Pending', 'Closed', 'Replied and call back');?>
          	<label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control">
            	<?php foreach($statuses as $status){?>
                	<option value="<?php print $status;?>"><?php print $status;?></option>
                <?php }?>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_inquiry') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>

<script>
$( '#CountryId' ).on( 'change', function (){
	$.post( '<?=base_url("inquiry/state_by_country")?>', {
			'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
			CountryId: this.value
		},
		function ( data ) {
			arr = $.parseJSON( data );
			//console.log( arr );
			$( '#CityId option:not(:first)' ).remove();
			$( '#state_id option:not(:first)' ).remove();
			$.each( arr, function ( key, value ) {
				$( '#state_id' )
					.append( $( "<option></option>" )
						.attr( "value", value.id )
						.text( value.name )
					);
			});
		});
});
$( '#state_id' ).on( 'change', function (){
	$.post( '<?=base_url("inquiry/city_by_state")?>', {
			'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
			state_id: this.value
		},
		function ( data ) {
			arr = $.parseJSON( data );
			//console.log( arr );
			$( '#CityId option:not(:first)' ).remove();
			$.each( arr, function ( key, value ) {
				$( '#CityId' )
					.append( $( "<option></option>" )
						.attr( "value", value.id )
						.text( value.name )
					);
			});
		});
});
</script>
