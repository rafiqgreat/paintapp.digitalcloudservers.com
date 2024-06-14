<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper"> 
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-pencil"></i> &nbsp;
            <?= trans('edit_country') ?>
          </h3>
        </div>
        <div class="d-inline-block float-right"> <a href="<?= base_url('country/state'); ?>" class="btn btn-success"><i class="fa fa-list"></i> States List</a>
          <?php //if($this->rbac->check_operation_permission('add')): ?>
          <a href="<?= base_url('country/state_add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add New State</a>
          <?php //endif; ?>
        </div>
      </div>
      <div class="card-body"> 
        
        <!-- For Messages -->
        <?php $this->load->view('template/_messages.php') ?>
        <?php echo form_open(base_url('country/state_edit/'.$state['id']), 'class="form-horizontal"' )?>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="name" class="control-label">State Name</label>
              <input type="text" name="name" value="<?= $state['name']; ?>" class="form-control" id="name" placeholder="" required>
            </div>
            <div class="col-md-6">
              <label for="CountryId" class="control-label">Country</label>
              <select class="form-control" required name="CountryId">
                <option>Select Country</option>
                <?php foreach($countries as $country):?>
                <?php if($state['CountryId'] == $country['id']): ?>
                <option value="<?= $country['id']; ?>" selected>
                <?= $country['name']; ?>
                </option>
                <?php else: ?>
                <option value="<?= $country['id']; ?>">
                <?= $country['name']; ?>
                </option>
                <?php endif; endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <label for="name" class="control-label">
              <?= trans('sequence') ?>
            </label>
            <input type="number" name="sequence" value="<?= $state['sequence']; ?>" class="form-control" id="name" placeholder="" required>
          </div>
          <div class="col-md-6">
            <label for="to_display" class="control-label">To Display</label>
            <select name="to_display" class="form-control">
              <option value="1" <?= ($state['to_display'] == 1)?'selected': '' ?> >Yes</option>
              <option value="0" <?= ($state['to_display'] == 0)?'selected': '' ?>>No</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-12">
            <input type="submit" name="submit" value="Update State" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close(); ?> </div>
      <!-- /.box-body --> 
    </div>
  </section>
</div>
