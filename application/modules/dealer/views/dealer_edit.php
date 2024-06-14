  <style>
  .imgwidth{
		width:40px;
		height:40px;
	}
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_dealer') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('dealer'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('dealer_list') ?></a>
              <a href="<?= base_url('dealer/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_dealer') ?></a>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('dealer/edit/'.$dealer['id']), 'class="form-horizontal" enctype="multipart/form-data"' )?> 
           <div class="form-group row">
              <div class="col-md-12">
              	<label for="name" class="control-label"><?= trans('dealer_name') ?></label>
                <input type="text" name="name" class="form-control" id="name" value="<?= $dealer['name']; ?>"  placeholder="">
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-md-12">
              <label for="address" class="control-label"><?= trans('address') ?></label>
              <textarea name="address" class="form-control" id="address" cols="5"><?= $dealer['address']; ?></textarea>
              </div>
            </div>
            
            <div class="form-group row">
              
              <div class="col-md-4">
              	<label for="CountryId" class="control-label"><?= trans('country_name') ?></label>
                <select name="CountryId" id="CountryId" class="form-control">
                  <option value="">Select Country</option>
                  <?php foreach($countries as $country): ?>
                    <option value="<?= $country['id']; ?>" <?php if($country['id']==$dealer['CountryId']){echo 'selected';}?>><?= $country['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="state_id" class="control-label">State Name</label>
                <select id="state_id" name="state_id" class="form-control">
                    <option value="">Select State</option> 
                    <?php $states = $this->dealer_model->get_state_by_country($dealer['CountryId']);
					if(!empty($states)){
					?> 
                    <?php foreach($states as $state): ?>
                    <option value="<?= $state['id']; ?>" <?php if($state['id']==$dealer['state_id']){echo 'selected';}?>><?= $state['name']; ?></option>
                  <?php endforeach; 
					}?>                  
                </select>
                </div>
              <div class="col-md-4">
              	<label for="CityId" class="control-label"><?= trans('CityId') ?></label>
                <select name="CityId" class="form-control" id="CityId">
                    <option value="">Select City</option> 
                    <?php $cities = $this->dealer_model->get_city_by_state($dealer['state_id']);
					if(!empty($cities)){?> 
                    <?php foreach($cities as $city): ?>
                    <option value="<?= $city['id']; ?>" <?php if($city['id']==$dealer['CityId']){echo 'selected';}?>><?= $city['name']; ?></option>
                  <?php endforeach; 
					}?>               
                </select>
                </div>
            </div>
            
            <div class="form-group row">
              <div class="col-md-6">
              	<label for="longitude" class="control-label"><?= trans('longitude') ?></label>
                <input type="number" name="longitude" class="form-control" id="longitude" value="<?= $dealer['longitude']; ?>" placeholder="">
              </div>
              <div class="col-md-6">
              	<label for="latitude" class="control-label"><?= trans('latitude') ?></label>
                <input type="number" name="latitude" class="form-control" id="latitude" value="<?= $dealer['latitude']; ?>" placeholder="">
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-md-12">
              	<label for="phone" class="col-md-2 control-label"><?= trans('phone') ?></label>
                <input type="number" name="phone" class="form-control" id="phone" value="<?= $dealer['phone']; ?>" placeholder="">
              </div>
            </div>
            
            <div class="row">
                <div class="form-group col-6">
                  <label for="isAC" class="col-md-2 control-label"><?= trans('isAC') ?></label>
        
                  <div class="col-md-12">
                    <input type="radio" id="1" name="isAC" value="1" <?php if($dealer['isAC']==1){echo 'checked="checked"';}?>>
                    <label for="1">Yeas</label>&emsp;
                    <input type="radio" id="0" name="isAC" value="0" <?php if($dealer['isAC']==0){echo 'checked="checked"';}?> >
                    <label for="0">No</label>
                  </div>
                </div>
                
                <div class="form-group col-6">
                  <label for="isRM" class="col-md-2 control-label"><?= trans('isRM') ?></label>
        
                  <div class="col-md-12">
                    <input type="radio" id="1" name="isRM" value="1" <?php if($dealer['isRM']==1){echo 'checked="checked"';}?>>
                    <label for="1">Yeas</label>&emsp;
                    <input type="radio" id="0" name="isRM" value="0" <?php if($dealer['isRM']==0){echo 'checked="checked"';}?>>
                    <label for="0">No</label>
                  </div>
                </div>
            </div>
            
            <div class="form-group row">
            <div class="col-md-6">
                <label for="sequence" class="col-md-2 control-label"><?= trans('sequence') ?></label>
                <input type="number" name="sequence" class="form-control" id="sequence" value="<?= $dealer['sequence']; ?>">
              </div>
            <div class="col-md-6">
              <label for="dealerlogo" class="control-label">Dealer Logo</label>
              <input type="file" name="dealerlogo" class="form-control" id="dealerlogo" value="" placeholder="">
              <?php if($dealer['dealerlogo'] && file_exists($dealer['dealerlogo'])){?> 
                	<br /><img class="imgwidth" src="<?php echo base_url($dealer['dealerlogo']);?>">&nbsp;
                    <a class="delete btn btn-xs btn-danger" href="<?php print base_url("dealer/delete_dealerimg/dealerlogo/".$dealer['id']);?>" title="Delete" onclick="return confirm('Do you want to delete ?')"> <i class="fa fa-trash-o"></i></a>
                <?php }?>
            </div>
        </div>
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_dealer') ?>" class="btn btn-primary pull-right">
              </div>
            </div>	
            <?php echo form_close(); ?>
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