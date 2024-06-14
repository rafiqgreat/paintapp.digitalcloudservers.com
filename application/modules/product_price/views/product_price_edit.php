  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_product_price') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('product_price'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('product_price_list') ?></a>
              <?php if($this->rbac->check_operation_permission('add')): ?>
              <a href="<?= base_url('product_price/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_product_price') ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('product_price/edit/'.$product_price['id']), 'class="form-horizontal"' )?> 
          <div class="form-group">
          <label for="product_id" class="col-md-2 control-label"><?= trans('product_name') ?></label>
          <div class="col-md-12">
            <select name="product_id" id="product_id" class="form-control">
              <option value="">Select Product</option>
              <?php foreach($products as $product): ?>
                <option value="<?= $product['id']; ?>" <?php if($product['id']==$product_price['product_id']){echo 'selected';}?>><?= $product['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="finish_id" class="col-md-2 control-label"><?= trans('finishtype_name') ?></label>
          <div class="col-md-12">
            <select name="finish_id" id="finish_id" class="form-control">
              <option value="">Select Finishtype</option>
              <?php foreach($finishtypes as $finishtype): ?>
                <option value="<?= $finishtype['id']; ?>" <?php if($finishtype['id']==$product_price['finish_id']){echo 'selected';}?>><?= $finishtype['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="package_id" class="col-md-2 control-label"><?= trans('packaging_name') ?></label>
          <div class="col-md-12">
            <select name="package_id" id="package_id" class="form-control">
              <option value="">Select Packaging</option>
              <?php foreach($packagings as $packaging): ?>
                <option value="<?= $packaging['id']; ?>" <?php if($packaging['id']==$product_price['package_id']){echo 'selected';}?>><?= $packaging['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
         <div class="form-group">
          <label for="price" class="col-md-2 control-label"><?= trans('price') ?></label>

          <div class="col-md-12">
            <input type="number" name="price" value="<?= $product_price['price']; ?>" class="form-control" id="price" placeholder="">
          </div>
        </div>
        
        <div class="form-group">
          <label for="isLuxury" class="col-md-2 control-label"><?= trans('isLuxury') ?></label>
          <div class="col-md-12">
            <select name="isLuxury" id="isLuxury" class="form-control">
              <option value="">Select Luxury Status</option>
              <option value="0" <?php if($product_price['isLuxury']==0){echo 'selected';}?>>No</option>
              <option value="1" <?php if($product_price['isLuxury']==1){echo 'selected';}?>>Yes</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label for="currency" class="col-md-2 control-label"><?= trans('currency') ?></label>

          <div class="col-md-12">
            <input type="text" name="currency" class="form-control" id="currency" placeholder="" value="<?= $product_price['currency']; ?>">
          </div>
        </div>
       
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_product_price') ?>" class="btn btn-primary pull-right">
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
        </div>  
      </section> 
    </div>