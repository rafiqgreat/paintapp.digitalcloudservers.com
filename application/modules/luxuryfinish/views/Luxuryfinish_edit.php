<style>
.imgwidth{
	width:40px;
	height:40px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-pencil"></i> &nbsp;
            <?= trans('edit_luxuryfinish') ?>
          </h3>
        </div>
        <div class="d-inline-block float-right"> <a href="<?= base_url('luxuryfinish'); ?>" class="btn btn-success"><i class="fa fa-list"></i>
          <?= trans('luxuryfinish_list') ?>
          </a>
          <?php //if($this->rbac->check_operation_permission('add')): ?>
          <a href="<?= base_url('luxuryfinish/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i>
          <?= trans('add_new_luxuryfinish') ?>
          </a>
          <?php //endif; ?>
        </div>
      </div>
      <div class="card-body"> 
        
        <!-- For Messages -->
        <?php $this->load->view('template/_messages.php') ?>
        <?php echo form_open(base_url('luxuryfinish/edit/'.$luxuryfinish['id']), 'class="form-horizontal" enctype="multipart/form-data"' )?>
        <div class="form-group">
          <label for="name" class="col-md-2 control-label">
            <?= trans('lux_name') ?>
          </label>
          <div class="col-md-12">
            <input type="text" name="name" value="<?= $luxuryfinish['name']; ?>" class="form-control" id="name" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label for="description" class="col-md-2 control-label">
            <?= trans('lux_description') ?>
          </label>
          <div class="col-md-12">
            <textarea name="description" class="form-control" id="description" rows="5"><?= $luxuryfinish['description']; ?>
</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="sequence" class="col-md-2 control-label">
            <?= trans('lux_sequence') ?>
          </label>
          <div class="col-md-12">
            <input type="text" name="sequence" value="<?= $luxuryfinish['sequence']; ?>" class="form-control" id="sequence" placeholder="">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-4">
            <div class="col-md-12">
                <label for="coverImage" class="control-label"><?= trans('lux_coverImage') ?></label>
              	<input type="file" name="coverImage" value="<?= $luxuryfinish['coverImage']; ?>" class="form-control" id="coverImage" placeholder="">
              	<?php if($luxuryfinish['coverImage'] && file_exists($luxuryfinish['coverImage'])){?> 
                	<br /><img class="imgwidth" src="<?php echo base_url($luxuryfinish['coverImage']);?>" width="75">&nbsp;
                    <a class="delete btn btn-xs btn-danger" href="<?php print base_url("luxuryfinish/delete_luximg/coverImage/".$luxuryfinish['id']);?>" title="Delete" onclick="return confirm('Do you want to delete ?')"> <i class="fa fa-trash-o"></i></a>
                <?php }?>
            </div>
          </div>
          <div class="form-group col-4"> 
            <div class="col-md-12">
            	<label for="productImage" class="control-label"><?= trans('lux_productImage') ?></label>
              	<input type="file" name="productImage" value="<?= $luxuryfinish['productImage']; ?>" class="form-control" id="productImage" placeholder="">
              	<?php if($luxuryfinish['productImage'] && file_exists($luxuryfinish['productImage'])){?> 
                	<br /><img class="imgwidth" src="<?php echo base_url($luxuryfinish['productImage']);?>">&nbsp;
                    <a class="delete btn btn-xs btn-danger" href="<?php print base_url("luxuryfinish/delete_luximg/productImage/".$luxuryfinish['id']);?>" title="Delete" onclick="return confirm('Do you want to delete ?')"> <i class="fa fa-trash-o"></i></a>
                <?php }?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-4">
            <div class="col-md-12">
            	<label for="image1" class="col-md-12 control-label"> <?= trans('lux_image1') ?> </label>
              	<input type="file" name="image1" value="<?= $luxuryfinish['image1']; ?>" class="form-control" id="image1" placeholder="">
              	<?php if($luxuryfinish['image1'] && file_exists($luxuryfinish['image1'])){?> 
                	<br /><img class="imgwidth" src="<?php echo base_url($luxuryfinish['image1']);?>">&nbsp;
                    <a class="delete btn btn-xs btn-danger" href="<?php print base_url("luxuryfinish/delete_luximg/image1/".$luxuryfinish['id']);?>" title="Delete" onclick="return confirm('Do you want to delete ?')"> <i class="fa fa-trash-o"></i></a>
                <?php }?>
            </div>
          </div>
          <div class="form-group col-4">
            <div class="col-md-12">
              	<label for="image2" class="col-md-12 control-label"> <?= trans('lux_image2') ?> </label>
              	<input type="file" name="image2" value="<?= $luxuryfinish['image2']; ?>" class="form-control" id="image2" placeholder="">
              	<?php if($luxuryfinish['image2'] && file_exists($luxuryfinish['image2'])){?> 
                	<br /><img class="imgwidth" src="<?php echo base_url($luxuryfinish['image2']);?>">&nbsp;
                    <a class="delete btn btn-xs btn-danger" href="<?php print base_url("luxuryfinish/delete_luximg/image2/".$luxuryfinish['id']);?>" title="Delete" onclick="return confirm('Do you want to delete ?')"> <i class="fa fa-trash-o"></i></a>
                <?php }?>
            </div>
          </div>
          <div class="form-group col-4">
            <div class="col-md-12">
              	<label for="image3" class="col-md-12 control-label"> <?= trans('lux_image3') ?> </label>
              	<input type="file" name="image3" value="<?= $luxuryfinish['image3']; ?>" class="form-control" id="image3" placeholder="">
              	<?php if($luxuryfinish['image3'] && file_exists($luxuryfinish['image3'])){?> 
                	<br /><img class="imgwidth" src="<?php echo base_url($luxuryfinish['image3']);?>">&nbsp;
                    <a class="delete btn btn-xs btn-danger" href="<?php print base_url("luxuryfinish/delete_luximg/image3/".$luxuryfinish['id']);?>" title="Delete" onclick="return confirm('Do you want to delete ?')"> <i class="fa fa-trash-o"></i></a>
                <?php }?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="video" class="col-md-12 control-label">
            <?= trans('lux_video') ?>
          </label>
          <div class="col-md-12">
            <input type="text" name="video" value="<?= $luxuryfinish['video']; ?>" class="form-control" id="video" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <input type="submit" name="submit" value="<?= trans('update_luxuryfinish') ?>" class="btn btn-primary pull-right">
          </div>
        </div>
        <?php echo form_close(); ?> </div>
      <!-- /.box-body --> 
    </div>
  </section>
</div>
