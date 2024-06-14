d  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_surface') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('surface'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('surface_list') ?></a>
              <?php if($this->rbac->check_operation_permission('add')): ?>
              <a href="<?= base_url('surface/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_surface') ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('surface/edit/'.$surface['id']), 'class="form-horizontal" enctype="multipart/form-data"' )?> 
           <div class="form-group">
            <label for="name" class="col-md-2 control-label"><?= trans('surface_name') ?></label>

            <div class="col-md-12">
              <input type="text" name="name" value="<?= $surface['name']; ?>" class="form-control" id="name" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="image" class="col-md-2 control-label"><?= trans('surface_image') ?></label>

            <div class="col-md-12">
              <input type="file" name="image" value="<?= $surface['image']; ?>" class="form-control" id="image" placeholder="">
            </div>
          </div>
            
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_surface') ?>" class="btn btn-primary pull-right">
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
        </div>  
      </section> 
    </div>