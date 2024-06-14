  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_category_surface') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('category_surface'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('category_surface_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('category_surface/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="CategoryId" class="col-md-2 control-label"><?= trans('category_surface_CategoryId') ?></label>
          <div class="col-md-12">
            <select name="CategoryId" id="CategoryId" class="form-control">
              <option value="">Select Category</option>
              <?php foreach($categories as $category): ?>
                <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label for="SurfaceId" class="col-md-2 control-label"><?= trans('category_surface_SurfaceId') ?></label>
          <div class="col-md-12">
            <select name="SurfaceId" id="SurfaceId" class="form-control">
              <option value="">Select Surface</option>
              <?php foreach($surfaces as $surface): ?>
                <option value="<?= $surface['id']; ?>"><?= $surface['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_category_surface') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>