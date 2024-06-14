  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_splashes_screens') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('splashes_screens'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('splashes_screens_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('splashes_screens/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="image" class="col-md-3 control-label"><?= trans('splashes_screens_image') ?></label>

          <div class="col-md-12">
            <input type="file" name="image_path" class="form-control" id="image_path" placeholder="">
          </div>
        </div>
        
         <div class="form-group">
          <label for="sequence" class="col-md-3 control-label"><?= trans('splashes_screens_sequence') ?></label>

          <div class="col-md-12">
            <input type="number" name="sequence" class="form-control" id="sequence" placeholder="">
          </div>
        </div>
        
        <div class="form-group">
          <label for="status" class="col-md-3 control-label"><?= trans('splashes_screens_status') ?></label>

          <div class="col-md-12">
            <input type="number" name="status" class="form-control" id="status" placeholder="">
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_splashes_screens') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>