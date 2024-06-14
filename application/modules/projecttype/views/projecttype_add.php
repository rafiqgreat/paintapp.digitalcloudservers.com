  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_projecttype') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('projecttype'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('projecttype_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('projecttype/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="name" class="col-md-2 control-label"><?= trans('projecttype_name') ?></label>

          <div class="col-md-12">
            <input type="text" name="name" class="form-control" id="name" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label for="image" class="col-md-2 control-label"><?= trans('projecttype_image') ?></label>

          <div class="col-md-12">
            <input type="file" name="image" class="form-control" id="image" placeholder="">
          </div>
        </div>
       
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_projecttype') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>