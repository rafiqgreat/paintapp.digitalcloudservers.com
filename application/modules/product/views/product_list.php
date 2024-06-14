<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css"> 

<style> <!-- DH resize the buttons to fit small screens -->
button
{
  margin-top: 10px;
    margin-left: 10px;
}
.btn-xs
{
    padding: 1px 5px !important;
    font-size: 12px !important;
    line-height: 1.5 !important;
    border-radius: 3px !important;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('template/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; <?= trans('p_list') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <?php 
		  //print '<pre>';
		 // print_r($_SESSION);
		  //print($this->rbac->check_operation_access('add'));
		  //die('in cat list');
		  if($this->rbac->check_operation_permission('add')): ?>
            <a href="<?= base_url('category/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_category') ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>#<?= trans('id') ?></th>
              <th><?= trans('p_name') ?></th>
              <th><?= trans('p_description') ?></th>
              <th><?= trans('p_spreading') ?></th>
              <th><?= trans('p_image') ?></th>
              <th><?= trans('p_coverImage') ?></th>
              <th><?= trans('p_image1') ?><br><?= trans('p_image2') ?><br><?= trans('p_image3') ?></th>
              <th><?= trans('p_productImage') ?></th>
              <th><?= trans('p_video') ?></th>
              <th><?= trans('p_isLuxury') ?></th>
              <th><?= trans('createdAt') ?></th>
              <th><?= trans('updatedAt') ?></th>
              <th><?= trans('p_isActive') ?></th>
              <th width="100" class="text-right"><?= trans('action') ?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>  
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
  //---------------------------------------------------
  var table = $('#na_datatable').DataTable( {
    "processing": true,
    "serverSide": false,
    "ajax": "<?=base_url('product/datatable_json')?>",
    "order": [[0,'asc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "description", 'searchable':true, 'orderable':true},
	{ "targets": 3, "name": "spreading", 'searchable':true, 'orderable':true},
	{ "targets": 4, "name": "image", 'searchable':true, 'orderable':false},
	{ "targets": 5, "name": "coverImage", 'searchable':true, 'orderable':false},
	{ "targets": 6, "name": "image1", 'searchable':true, 'orderable':false},
	{ "targets": 7, "name": "productImage", 'searchable':true, 'orderable':false},
	{ "targets": 8, "name": "video", 'searchable':true, 'orderable':false},
	{ "targets": 9, "name": "isLuxury", 'searchable':true, 'orderable':true},
    { "targets": 10, "name": "createdAt", 'searchable':false, 'orderable':false},
	{ "targets": 11, "name": "updateddAt", 'searchable':false, 'orderable':false},
	{ "targets": 12, "name": "isActive", 'searchable':false, 'orderable':false},
    { "targets": 13, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
</script>

<script type="text/javascript">
  $("body").on("change",".tgl_checkbox",function(){
    console.log('checked');
    $.post('<?=base_url("product/change_status")?>',
    {
      '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
      id : $(this).data('id'),
      status : $(this).is(':checked') == true?1:0
    },
    function(data){
      $.notify("Status Changed Successfully", "success");
    });
  });
</script>


