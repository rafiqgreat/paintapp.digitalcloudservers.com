d  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; <?= trans('edit_product') ?> </h3>
            </div>
            <div class="d-inline-block float-right">
              <a href="<?= base_url('product'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('product_list') ?></a>
              <?php if($this->rbac->check_operation_permission('add')): ?>
              <a href="<?= base_url('product/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_product') ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-body">

           <!-- For Messages -->
           <?php $this->load->view('template/_messages.php') ?>
           
           <?php echo form_open(base_url('product/edit/'.$product['id']), 'class="form-horizontal" enctype="multipart/form-data"' )?> 
          <div class="form-group">
          <label for="name" class="col-md-2 control-label"><?= trans('p_name') ?></label>
          <div class="col-md-12">
            <input type="text" name="name" value="<?= $product['name']; ?>" class="form-control" id="name" placeholder="">
          </div>
         </div>
         
         <div class="form-group">
          <label for="description" class="col-md-2 control-label"><?= trans('p_description') ?></label>
          <div class="col-md-12">
            <input type="text" name="description" value="<?= $product['description']; ?>" class="form-control" id="description" placeholder="">
          </div>
         </div>
         
         <div class="form-group">
          <label for="spreading" class="col-md-2 control-label"><?= trans('p_spreading') ?></label>
          <div class="col-md-12">
            <input type="text" name="spreading" value="<?= $product['spreading']; ?>" class="form-control" id="spreading" placeholder="">
          </div>
         </div>
         
        <div class="row">
        	
            <div class="form-group col-4">
            	<img src="<?php echo base_url($product['image'])?>" width="40">
              <label for="image" class="col-md-12 control-label"><?= trans('p_image') ?></label>
              <div class="col-md-12">
                <input type="file" name="image" class="form-control" id="image" placeholder="">
              </div>
            </div>
            
            <div class="form-group col-4">
            	<img src="<?php echo base_url($product['coverImage'])?>" width="40">
              <label for="coverImage" class="col-md-12 control-label"><?= trans('p_coverImage') ?></label>
              <div class="col-md-12">
                <input type="file" name="coverImage" value="<?= $product['coverImage']; ?>" class="form-control" id="coverImage" placeholder="">
              </div>
            </div>
        	
            <div class="form-group col-4">
            	<img src="<?php echo base_url($product['productImage'])?>" width="40">
              <label for="productImage" class="col-md-12 control-label"><?= trans('p_productImage') ?></label>
              <div class="col-md-12">
                <input type="file" name="productImage" value="<?= $product['productImage']; ?>" class="form-control" id="productImage" placeholder="">
              </div>
            </div>
         </div>   
         
        <div class="row">
            <div class="form-group col-4">
            	<img src="<?php echo base_url($product['image1'])?>" width="40">
              <label for="image1" class="col-md-12 control-label"><?= trans('p_image1') ?></label>
              <div class="col-md-12">
                <input type="file" name="image1" value="<?= $product['image1']; ?>" class="form-control" id="image1" placeholder="">
              </div>
            </div>
            
            <div class="form-group col-4">
            	<img src="<?php echo base_url($product['image2'])?>" width="40">
              <label for="image2" class="col-md-12 control-label"><?= trans('p_image2') ?></label>
              <div class="col-md-12">
                <input type="file" name="image2" value="<?= $product['image2']; ?>" class="form-control" id="image2" placeholder="">
              </div>
            </div>
        
            <div class="form-group col-4">
            	<img src="<?php echo base_url($product['image3'])?>" width="40">
              <label for="image3" class="col-md-12 control-label"><?= trans('p_image3') ?></label>
              <div class="col-md-12">
                <input type="file" name="image3" value="<?= $product['image3']; ?>" class="form-control" id="image3" placeholder="">
              </div>
            </div>
         </div>    
           
        <div class="form-group">
          <label for="video" class="col-md-12 control-label"><?= trans('p_video') ?></label>
          <div class="col-md-12">
            <input type="text" name="video" value="<?= $product['video']; ?>" class="form-control" id="video" placeholder="">
          </div>
         </div>
         
         <div class="form-group">
          <label for="sequence" class="col-md-12 control-label"><?= trans('p_sequence') ?></label>
          <div class="col-md-12">
            <input type="text" name="sequence" value="<?= $product['sequence']; ?>" class="form-control" id="sequence" placeholder="">
          </div>
         </div>
		        
         <div class="form-group">
          <label for="isLuxury" class="col-md-2 control-label"><?= trans('p_isLuxury') ?></label>
          <div class="col-md-12">
            <input type="text" name="isLuxury" value="<?= $product['isLuxury']; ?>" class="form-control" id="isLuxury" placeholder="">
          </div>
         </div>
            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="<?= trans('update_product') ?>" class="btn btn-primary pull-right">
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
        </div>  
      </section> 
    </div>