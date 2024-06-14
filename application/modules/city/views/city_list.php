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
          <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; <?= trans('city_list') ?></h3>
        </div>
        <div class="d-inline-block float-right">
            <a href="<?= base_url('city/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_city') ?></a>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body table-responsive"> 
        <table id="na_datatable" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>#<?= trans('id') ?></th>
              <th><?= trans('city_name') ?></th>
              <th>State Name</th>
              <th><?= trans('CountryId') ?></th>              
              <th><?= trans('sequence') ?></th>
              <th><?= trans('createdAt') ?></th>
              <th><?= trans('updatedAt') ?></th>
              <th>To Display</th>
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
    "ajax": "<?=base_url('city/datatable_json')?>",
    "order": [[5,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
	{ "targets": 2, "name": "state_id", 'searchable':false, 'orderable':false},
	{ "targets": 3, "name": "CountryId", 'searchable':false, 'orderable':false},
	{ "targets": 4, "name": "sequence", 'searchable':true, 'orderable':true},
    { "targets": 5, "name": "createdAt", 'searchable':true, 'orderable':true},
    { "targets": 6, "name": "updatedAt", 'searchable':false, 'orderable':false},
	{ "targets": 7, "name": "to_display", 'searchable':false, 'orderable':false},
    { "targets": 8, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
</script>


<script type="text/javascript">
  $("body").on("change",".tgl_checkbox",function(){
    console.log('checked');
    $.post('<?=base_url("city/change_status")?>',
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


