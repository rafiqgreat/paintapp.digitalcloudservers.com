  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_product_price') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('product_price'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('product_price_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('product_price/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="product_id" class="col-md-2 control-label"><?= trans('product_name') ?></label>
          <div class="col-md-12">
            <select name="product_id" id="product_id" class="form-control">
              <option value="">Select Product</option>
              <?php foreach($products as $product): ?>
                <option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
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
                <option value="<?= $finishtype['id']; ?>"><?= $finishtype['name']; ?></option>
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
                <option value="<?= $packaging['id']; ?>"><?= $packaging['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
         <div class="form-group">
          <label for="price" class="col-md-2 control-label"><?= trans('price') ?></label>

          <div class="col-md-12">
            <input type="number" name="price" class="form-control" id="price" placeholder="">
          </div>
        </div>
        
        <div class="form-group">
          <label for="isLuxury" class="col-md-2 control-label"><?= trans('isLuxury') ?></label>
          <div class="col-md-12">
            <select name="isLuxury" id="isLuxury" class="form-control">
              <option value="">Select Luxury Status</option>
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label for="currency" class="col-md-2 control-label"><?= trans('currency') ?></label>

          <div class="col-md-12">
            <input type="text" name="currency" class="form-control" id="currency" placeholder="">
          </div>
        </div>
       
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_product_price') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#name').on('change', function(){
            var name = $(this).val();
            $.ajax({
                url: '<?php echo base_url("product_price/check_name_exist"); ?>',
                method: 'POST',
                data: {name: name},
                success: function(response){
                    //alert (response);
					if(response){
                        alert('product_price already exists');
                        // You can add further actions here, like disabling form submission
						$('#name').val(''); // Clear the input field
                    }
                }
            });
        });
    });
</script>
