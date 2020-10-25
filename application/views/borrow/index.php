<!-- start center content -->
<div class="row">
	<div class="col-xl-12">
		<div class="card mb-3">
			<div class="card-header">
				<h3 class="pull-left">
					<i class="fa fa-table"></i> <?php line('dt_listdata'); ?>
				</h3>
				<div class="pull-right">
					<a href="<?php echo site_url('borrow/main_form'); ?>" role="button" class="btn btn-dark btn-create" data-toggle="modal" data-target="#ajaxLargeModal"><?php echo line('create'); ?></a>

						<div class="btn-group" role="group">
						<a id="btnGroupDrop1" role="button" href="#" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-file-excel-o"></i>
							<?php echo line('export_excel'); ?>
						</a>
						<div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(2px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
							<a class="dropdown-item btn-export-borrow" href="#"><?php echo line('export_borrow'); ?></a>
							<a class="dropdown-item btn-export-borrow-list" href="#"><?php echo line('export_borrow_list'); ?></a>
						</div>
						</div>

				</div>				
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table id="tablelist" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php line('bow_code'); ?></th>
								<th><?php line('bow_name'); ?></th>
								<th><?php line('bow_borrow_date'); ?></th>
								<th><?php line('bow_schedule_date'); ?></th>
								<th><?php line('action'); ?></th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- end card-->
	</div>
</div>
<!-- END center content -->
