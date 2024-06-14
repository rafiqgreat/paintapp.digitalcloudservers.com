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
          <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; <?= trans('splashes_screens_list') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <?php 
		  //print '<pre>';
		 // print_r($_SESSION);
		  //print($this->rbac->check_operation_access('add'));
		  //die('in cat list');
		  if($this->rbac->check_operation_permission('add')): ?>
            <a href="<?= base_url('splashes_screens/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_splashes_screens') ?></a>
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
              <th><?= trans('splashes_screens_image') ?></th>
              <th><?= trans('sequence') ?></th>
              <th><?= trans('status') ?></th>
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
    "ajax": "<?=base_url('splashes_screens/datatable_json')?>",
    "order": [[4,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "image_path", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "sequence", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "status", 'searchable':false, 'orderable':false},
    { "targets": 4, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
</script>


