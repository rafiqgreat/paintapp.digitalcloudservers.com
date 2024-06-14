<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css"> 

<style> <!-- DH resize the buttons to fit small screens -->
/*button
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
}*/
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('template/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; <?= trans('country_list') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <?php 
		  //if($this->rbac->check_operation_permission('add')): ?>
            <a href="<?= base_url('country/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_country') ?></a>
          <?php //endif; ?>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>#<?= trans('id') ?></th>
              <th><?= trans('country_name') ?></th>
              <th>Short Name</th>
              <th>Phone Code</th>
              <th><?= trans('createdAt') ?></th>
              <th><?= trans('sequence') ?></th>
              <th><?= trans('to_display') ?></th>
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
    "ajax": "<?=base_url('country/datatable_json')?>",
    "order": [[4,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
	{ "targets": 2, "name": "sortname", 'searchable':true, 'orderable':true},
	{ "targets": 3, "name": "phonecode", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "createdAt", 'searchable':true, 'orderable':true},
    { "targets": 5, "name": "sequence", 'searchable':false, 'orderable':false},
	{ "targets": 6, "name": "to_display", 'searchable':false, 'orderable':false},
    { "targets": 7, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
  
</script>


<script type="text/javascript">
  $("body").on("change",".tgl_checkbox",function(){
    console.log('checked');
    $.post('<?=base_url("country/change_status")?>',
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


