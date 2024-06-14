  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_country') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('country'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('country_list') ?></a>
              <?php if($this->rbac->check_operation_permission('add')): ?>
              <a href="<?= base_url('country/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_country') ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('country/edit/'.$country['id']), 'class="form-horizontal"' )?> 
           <div class="form-group">
            <label for="name" class="col-md-2 control-label"><?= trans('country_name') ?></label>

            <div class="col-md-12">
              <input type="text" name="name" value="<?= $country['name']; ?>" class="form-control" id="name" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-md-2 control-label"><?= trans('country_name') ?></label>

            <div class="col-md-12">
              <input type="number" name="sequence" value="<?= $country['sequence']; ?>" class="form-control" id="name" placeholder="">
            </div>
          </div>
            
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_country') ?>" class="btn btn-primary pull-right">
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
        </div>  
      </section> 
    </div>