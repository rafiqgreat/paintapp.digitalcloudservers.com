  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_product_packaging') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('product_packaging'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('product_packaging_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('product_packaging/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="PackagingId" class="col-md-2 control-label"><?= trans('packaging_name') ?></label>
          <div class="col-md-12">
            <select name="PackagingId" id="PackagingId" class="form-control">
              <option value="">Select Packaging</option>
              <?php foreach($packagings as $packaging): ?>
                <option value="<?= $packaging['id']; ?>"><?= $packaging['name']; ?></option>
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
                <option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div> 
       
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('add_product_packaging') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close( ); ?>
      </div>
      <!-- /.box-body -->
    </div>
  </section> 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php /*?><script>
    $(document).ready(function(){
        $('#name').on('change', function(){
            var name = $(this).val();
            $.ajax({
                url: '<?php echo base_url("product_packaging/check_name_exist"); ?>',
                method: 'POST',
                data: {name: name},
                success: function(response){
                    //alert (response);
					if(response){
                        alert('product_packaging already exists');
                        // You can add further actions here, like disabling form submission
						$('#name').val(''); // Clear the input field
                    }
                }
            });
        });
    });
</script><?php */?>
