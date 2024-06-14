  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_product_packaging') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('product_packaging'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('product_packaging_list') ?></a>
              <?php if($this->rbac->check_operation_permission('add')): ?>
              <a href="<?= base_url('product_packaging/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_product_packaging') ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('product_packaging/edit/'.$product_packaging['id']), 'class="form-horizontal"' )?> 
          <div class="form-group">
          <label for="PackagingId" class="col-md-2 control-label"><?= trans('packaging_name') ?></label>
          <div class="col-md-12">
            <select name="PackagingId" id="PackagingId" class="form-control">
              <option value="">Select Packaging</option>
              <?php foreach($packagings as $packaging): ?>
                <option value="<?= $packaging['id']; ?>" <?php if($packaging['id']==$product_packaging['PackagingId']){echo 'selected';}?>><?= $packaging['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
          <div class="form-group">
          <label for="ProductId" class="col-md-2 control-label"><?= trans('product_name') ?></label>
          <div class="col-md-12">
            <select name="ProductId" id="ProductId" class="form-control">
              <option value="">Select Product</option>
              <?php foreach($products as $product): ?>
                <option value="<?= $product['id']; ?>" <?php if($product['id']==$product_packaging['ProductId']){echo 'selected';}?>><?= $product['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_product_packaging') ?>" class="btn btn-primary pull-right">
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
        </div>  
      </section> 
    </div>