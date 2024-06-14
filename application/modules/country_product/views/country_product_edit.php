  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_country_product') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('country_product'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('country_product_list') ?></a>
              <?php if($this->rbac->check_operation_permission('add')): ?>
              <a href="<?= base_url('country_product/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_country_product') ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('country_product/edit/'.$country_product['id']), 'class="form-horizontal"' )?> 
          <div class="form-group">
          <label for="CountryId" class="col-md-2 control-label"><?= trans('country_name') ?></label>
          <div class="col-md-12">
            <select name="CountryId" id="CountryId" class="form-control">
              <option value="">Select Country</option>
              <?php foreach($countries as $country): ?>
                <option value="<?= $country['id']; ?>" <?php if($country['id']==$country_product['CountryId']){echo 'selected';}?>><?= $country['name']; ?></option>
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
                <option value="<?= $product['id']; ?>" <?php if($product['id']==$country_product['ProductId']){echo 'selected';}?>><?= $product['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_country_product') ?>" class="btn btn-primary pull-right">
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
        </div>  
      </section> 
    </div>