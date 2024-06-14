  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_dealer') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('dealer'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('dealer_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('dealer/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group row">
          <label for="name" class="col-md-2 control-label"><?= trans('dealer_name') ?></label>

          <div class="col-md-12">
            <input type="text" name="name" class="form-control" id="name" placeholder="">
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-12">
          	<label for="address" class="col-md-2 control-label"><?= trans('address') ?></label>
            <textarea name="address" class="form-control" id="address" cols="5"></textarea>
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
          <div class="col-md-6">
          	<label for="longitude" class="control-label"><?= trans('longitude') ?></label>
            <input type="number" name="longitude" class="form-control" id="longitude" placeholder="">
          </div>
          <div class="col-md-6">
          	<label for="latitude" class="control-label"><?= trans('latitude') ?></label>
            <input type="number" name="latitude" class="form-control" id="latitude" placeholder="">
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-12">
          	<label for="phone" class="control-label"><?= trans('phone') ?></label>
            <input type="number" name="phone" class="form-control" id="phone" placeholder="">
          </div>
        </div>
        
        <div class="row">
            <div class="form-group col-6">
              <label for="isAC" class="col-md-2 control-label"><?= trans('isAC') ?></label>
    
              <div class="col-md-12">
                <input type="radio" id="1" name="isAC" value="1" >
                <label for="1">Yeas</label>&emsp;
                <input type="radio" id="0" name="isAC" value="0" checked="checked">
                <label for="0">No</label>
              </div>
            </div>
            
            <div class="form-group col-6">
              <label for="isRM" class="col-md-2 control-label"><?= trans('isRM') ?></label>
    
              <div class="col-md-12">
                <input type="radio" id="1" name="isRM" value="1">
                <label for="1">Yeas</label>&emsp;
                <input type="radio" id="0" name="isRM" value="0" checked="checked">
                <label for="0">No</label>
              </div>
            </div>
		</div>
        
        <div class="form-group row">
            <div class="col-md-6">
                <label for="sequence" class="col-md-2 control-label"><?= trans('sequence') ?></label>
                <input type="number" name="sequence" class="form-control" id="sequence" placeholder="">
              </div>
            <div class="col-md-6">
              <label for="dealerlogo" class="control-label">Dealer Logo</label>
              <input type="file" name="dealerlogo" class="form-control" id="dealerlogo" placeholder="">
            </div>
        </div>
        
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_dealer') ?>" class="btn btn-primary pull-right">
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
	$.post( '<?=base_url("dealer/state_by_country")?>', {
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
	$.post( '<?=base_url("dealer/city_by_state")?>', {
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