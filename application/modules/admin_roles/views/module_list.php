<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">

<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<!-- DataTables -->

<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"> </script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"> </script>

<style>
	tbody.sortable {
		/* change the cursor to 'move' cursor when hovering */
		cursor: move;
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
					<h3 class="card-title"><i class="fa fa-list"></i>&nbsp; <?= $title ?></h3>
				</div>

				<!-- <div class="alert alert-success" id="response" role="alert">Sort and save :)</div> -->
				
				<div class="d-inline-block float-right">
					<button class="save btn btn-success"><i class="fa fa-save"></i><?= trans('update_position') ?></button>
					<!-- <a href="<?= base_url('admin_roles/update_menu_list') ?>" class="btn btn-success"><i class="fa fa-plus"></i><?= trans('update_position') ?></a> -->
					<a href="<?= base_url('admin_roles/module_add') ?>" class="btn btn-success"><i class="fa fa-plus"></i><?= trans('add_new_module') ?></a>
				</div>
			</div>

			<div class="card-body">
				<table id="example1" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="50"><?= trans('id') ?></th>
							<th><?= trans('module_name') ?></th>
							<th><?= trans('controller_name') ?></th>
							<th><?= trans('fa_icon') ?></th>
							<th><?= trans('operations') ?></th>
							<th><?= trans('sub_module') ?></th>
							<th width="100"><?= trans('action') ?></th>
						</tr>
					</thead>
					<tbody class="sortable">
						<?php foreach($records as $record): ?>
						<tr id=menulist-<?= $record['module_id']; ?>>
								<!-- DH original: <td><?= $record['module_id']; ?></td> -->
								<td><?= $record['module_id']; ?></td>
								<td><?= trans($record['module_name']); ?></td>
								<td><?= $record['controller_name']; ?></td>
								<td><?= $record['fa_icon']; ?></td>
								<td><?= $record['operation']; ?></td>
								<td>
									<a href="<?= base_url('admin_roles/sub_module/'.$record['module_id']) ?>" class="btn btn-info btn-xs mr5">
										<i class="fa fa-sliders"></i>
									</a>
								</td>
								<td>
									<a href="<?php echo site_url("admin_roles/module_edit/".$record['module_id']); ?>" class="btn btn-warning btn-xs mr5" >
										<i class="fa fa-edit"></i>
									</a>
									<a href="<?php echo site_url("admin_roles/module_delete/".$record['module_id']); ?>" onclick="return confirm('are you sure to delete?')" class="btn btn-danger btn-xs">
										<i class="fa fa-remove"></i>
									</a>
									<a class='up' href='#'><i class="fa fa-up"></i></a>
									<!-- <a class='down' href='#'><i class="fa fa-down"></i></a> -->
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>

<script>
  $(document).ready(function() {
	  var table = $('#example1').DataTable( {
		  "ordering": false, // DH ordering disabled to allow re-ordering columns manually
		  rowReorder: {
			  selector: 'tr'
		  }
		  /*columnDefs: [
			  { targets: 0, visible: false } // make the first column (ID) invisible
		  ]*/
		  /*
		  columnDefs: [
			  { orderable: true, className: 'reorder', targets: [0] },
			  { orderable: false, targets: '_all' }
		  ]*/

	  } );
  } );  
</script>

<script type="text/javascript">
	var ul_sortable = $('.sortable');
	ul_sortable.sortable({
		revert: 100,
		placeholder: 'placeholder'
	});
	ul_sortable.disableSelection();
	var btn_save = $('button.save'),
	div_response = $('#response');
	btn_save.on('click', function(e) {
		e.preventDefault();
		var sortable_data = ul_sortable.sortable( 'serialize' );
		//alert(sortable_data);
		div_response.text('Saved!');
		$.ajax({
			type: 'POST',
			url: '<?= base_url("admin_roles/update_menu_list/"); ?>',
			data: sortable_data,
			success:function(result) {
				//console.log('Hello');
				alert('re-order completed, re-loading page.');
				div_response.text(result);
				location.href = '<?= base_url("admin_roles/Admin_roles/module"); ?>';
			}
		});
	});
</script>

