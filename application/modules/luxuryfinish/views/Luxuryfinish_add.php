  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_luxuryfinish') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('luxuryfinish'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('luxuryfinish_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('luxuryfinish/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="name" class="col-md-2 control-label"><?= trans('lux_name') ?></label>
          <div class="col-md-12">
            <input type="text" name="name" class="form-control" id="name" placeholder="">
          </div>
         </div>
         
         <div class="form-group">
          <label for="description" class="col-md-2 control-label"><?= trans('lux_description') ?></label>
          <div class="col-md-12">
          	<textarea name="description" class="form-control" id="description" rows="5"></textarea>
          </div>
         </div>
         
         <div class="form-group">
          <label for="sequence" class="col-md-2 control-label"><?= trans('lux_sequence') ?></label>
          <div class="col-md-12">
            <input type="number" name="sequence" class="form-control" id="sequence" placeholder="">
          </div>
         </div>
         
        <div class="row">
            <div class="form-group col-4">
              <label for="coverImage" class="col-md-12 control-label"><?= trans('lux_coverImage') ?></label>
              <div class="col-md-12">
                <input type="file" name="coverImage" class="form-control" id="coverImage" placeholder="">
              </div>
            </div>
        
            <div class="form-group col-4">
              <label for="productImage" class="col-md-12 control-label"><?= trans('lux_productImage') ?></label>
              <div class="col-md-12">
                <input type="file" name="productImage" class="form-control" id="productImage" placeholder="">
              </div>
            </div>
         </div>   
         
        <div class="row">
            <div class="form-group col-4">
              <label for="image1" class="col-md-12 control-label"><?= trans('lux_image1') ?></label>
              <div class="col-md-12">
                <input type="file" name="image1" class="form-control" id="image1" placeholder="">
              </div>
            </div>
            
            <div class="form-group col-4">
              <label for="image2" class="col-md-12 control-label"><?= trans('lux_image2') ?></label>
              <div class="col-md-12">
                <input type="file" name="image2" class="form-control" id="image2" placeholder="">
              </div>
            </div>
        
            <div class="form-group col-4">
              <label for="image3" class="col-md-12 control-label"><?= trans('lux_image3') ?></label>
              <div class="col-md-12">
                <input type="file" name="image3" class="form-control" id="image3" placeholder="">
              </div>
            </div>
         </div>    
           
        <div class="form-group">
          <label for="video" class="col-md-12 control-label"><?= trans('lux_video') ?></label>
          <div class="col-md-12">
            <input type="text" name="video" class="form-control" id="video" placeholder="">
          </div>
         </div>
       
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_luxuryfinish') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>