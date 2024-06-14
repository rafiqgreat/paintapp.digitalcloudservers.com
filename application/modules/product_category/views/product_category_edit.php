  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_product_category') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('product_category'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('product_category_list') ?></a>
              <?php if($this->rbac->check_operation_permission('add')): ?>
              <a href="<?= base_url('product_category/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_product_category') ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('product_category/edit/'.$product_category['id']), 'class="form-horizontal"' )?> 
          <div class="form-group">
          <label for="CategoryId" class="col-md-2 control-label"><?= trans('category_name') ?></label>
          <div class="col-md-12">
            <select name="CategoryId" id="CategoryId" class="form-control">
              <option value="">Select Finishtype</option>
              <?php foreach($categories as $category): ?>
                <option value="<?= $category['id']; ?>" <?php if($category['id']==$product_category['CategoryId']){echo 'selected';}?>><?= $category['name']; ?></option>
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
                <option value="<?= $product['id']; ?>" <?php if($product['id']==$product_category['ProductId']){echo 'selected';}?>><?= $product['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_product_category') ?>" class="btn btn-primary pull-right">
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
        </div>  
      </section> 
    </div>