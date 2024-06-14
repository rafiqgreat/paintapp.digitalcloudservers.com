  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_country_product') ?> </h3>
           </div>
           <div class="d-inline-block float-right">
            <a href="<?= base_url('country_product'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('country_product_list') ?></a>
          </div>
        </div>
        <div class="card-body">
         
         <!-- For Messages -->
         <?php $this->load->view('template/_messages.php') ?>

         <?php echo form_open(base_url('country_product/add'), 'class="form-horizontal" enctype="multipart/form-data"');  ?> 
         <div class="form-group">
          <label for="CountryId" class="col-md-2 control-label"><?= trans('country_name') ?></label>
          <div class="col-md-12">
            <select name="CountryId" id="CountryId" class="form-control">
              <option value="">Select Country</option>
              <?php foreach($countries as $country): ?>
                <option value="<?= $country['id']; ?>"><?= $country['name']; ?></option>
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
            <input type="submit" name="submit" value="<?= trans('add_country_product') ?>" class="btn btn-primary pull-right">
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
                url: '<?php echo base_url("country_product/check_name_exist"); ?>',
                method: 'POST',
                data: {name: name},
                success: function(response){
                    //alert (response);
					if(response){
                        alert('country_product already exists');
                        // You can add further actions here, like disabling form submission
						$('#name').val(''); // Clear the input field
                    }
                }
            });
        });
    });
</script><?php */?>
