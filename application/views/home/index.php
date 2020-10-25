<!-- start center content -->
<div class="row">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
				<div class="card-box noradius noborder bg-default">
					<i class="fa fa-fw fa-random float-right text-white"></i>
					<h6 class="text-white text-uppercase m-b-20">
						<?php line('dsh_borrow'); ?>
					</h6>
					<h1 class="m-b-20 text-white counter">
						<?php echo number_format($count_borrow); ?>
					</h1>
					<span class="text-white">
						<?php line('dsh_borrow_desc'); ?>
					</span>
				</div>
			</div>

			<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
				<div class="card-box noradius noborder bg-danger">
					<i class="fa fa-bell-slash-o float-right text-white"></i>
					<h6 class="text-white text-uppercase m-b-20">
						<?php line('dsh_remain_return'); ?>
					</h6>
					<h1 class="m-b-20 text-white counter">
						<?php echo number_format($count_remain_return); ?>
					</h1>
					<span class="text-white">
						<?php line('dsh_remain_return_desc'); ?>
					</span>
				</div>
			</div>

			<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
				<div class="card-box noradius noborder bg-warning">
					<i class="fa fa-fw fa-vcard float-right text-white"></i>
					<h6 class="text-white text-uppercase m-b-20">
						<?php line('dsh_member'); ?>
					</h6>
					<h1 class="m-b-20 text-white counter">
						<?php echo number_format($count_member); ?>
					</h1>
					<span class="text-white">
						<?php line('dsh_member_desc'); ?>
					</span>
				</div>
			</div>

			<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
				<div class="card-box noradius noborder bg-info">
					<i class="fa fa-cubes float-right text-white"></i>
					<h6 class="text-white text-uppercase m-b-20">
						<?php line('dsh_product'); ?>
					</h6>
					<h1 class="m-b-20 text-white counter">
						<?php echo number_format($count_product); ?>
					</h1>
					<span class="text-white">
						<?php line('dsh_product_desc'); ?>
					</span>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
				<div class="card mb-3">
					<div class="card-header">
						<h3>
							<i class="fa fa-envelope-o"></i> <?php line('dsh_last_login'); ?></h3>						
					</div>

					<div class="card-body">

						<div class="widget-messages nicescroll" style="height: 400px;">
							<?php foreach($last_login as $last): ?>
							<a href="#">
								<div class="message-item">
									<div class="message-user-img">
										<img src="assets/images/avatars/avatar10.png" class="avatar-circle" alt="">
									</div>
									<p class="message-item-user"><?php echo $last['username']; ?></p>
									<p class="message-item-msg"><?php echo $last['fullname']; ?></p>
									<p class="message-item-date"><?php echo date('d/m/Y H:i', strtotime($last['last_login'])); ?></p>
								</div>
							</a>
							<?php endforeach; ?>
						</div>

					</div>
					<div class="card-footer small text-muted"><?php echo get_line('updated') .' ' . date('d/m/Y H:i'); ?></div>
				</div>
				<!-- end card-->
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-9">
				<div class="card mb-3">
					<div class="card-header">
						<h3>
							<i class="fa fa-envelope-o"></i> <?php line('dsh_last_borrow_product'); ?></h3>						
					</div>

					<div class="card-body">
						<div class="table-responsive">
							<table id="tablelist" class="table table-bordered table-hover">
								<thead>
									<tr>										
										<th><?php line('prd_code'); ?></th>
										<th><?php line('prd_name'); ?></th>
										<th><?php line('prd_serial_number'); ?></th>
										<th><?php line('bod_borrow_quantity'); ?></th>
										<th><?php line('bod_return_quantity'); ?></th>
										<th><?php line('bow_return_status'); ?></th>
										<th><?php line('trans_date'); ?></th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer small text-muted"><?php echo get_line('updated') .' ' . date('d/m/Y H:i'); ?></div>
				</div>
				<!-- end card-->
			</div>

		</div>
	</div>
</div>
<!-- END center content -->
