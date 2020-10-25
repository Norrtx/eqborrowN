<div id="app">
	<form role="form" id="modalForm">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				<span v-if="item.id == 0"><?php echo line('create'); ?></span>
				<span v-else><?php echo line('edit'); ?> : {{ item.name }}</span>				
			</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form>		
				<?php echo form_hidden('id', $id); ?>
				<input type="text" v-model="hideVal" style="display:none;">
				<div class="form-row">
					<div class="form-group col-sm-8">
						<label for="members">
							<span class="text-secondary"><?php line('bow_code'); ?>*</span>
						</label>
						<v-select :options="members" :filterable="false" @search="searchMember" v-model="item.member" placeholder="เลือกผู้ยืม"></v-select>				
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-sm-4">
						<label for="borrow_date">
							<span class="text-secondary"><?php line('bow_borrow_date'); ?>*</span>
						</label>
						<?php echo form_input(array('name' => 'borrow_date', 'v-model'=>'item.borrow_date', 'class' => 'form-control', 'autocomplete' => 'off', 'readonly'=>'')); ?>
					</div>
					<div class="form-group col-sm-4">
						<label for="schedule_date">
							<span class="text-secondary"><?php line('bow_schedule_date'); ?>*</span>
						</label>
						<?php echo form_input(array('name' => 'schedule_date', 'v-model'=>'item.schedule_date', 'class' => 'form-control', 'autocomplete' => 'off', 'readonly'=>'')); ?>
					</div>
					<div v-if="item.id!=0" class="form-group col-sm-4">
						<label for="return_date">
							<span class="text-secondary"><?php line('bod_return_date'); ?>*</span>
						</label>
						<?php echo form_input(array('name' => 'return_date', 'v-model'=>'item.return_date', 'class' => 'form-control', 'autocomplete' => 'off', 'readonly'=>'')); ?>
					</div>
				</div>

				<div class="form-row" v-if="item.id==0">
					<div class="form-group col-sm-12">
						<label for="product_id">
							<?php line('prd_name'); ?>
						</label>
						<v-select :options="products" v-model="productId" placeholder="เลือกรายการ"></v-select>
					</div>
				</div>
				<h5>รายการสินค้า</h5>
				<div class="form-row">
					<div class="form-group col-sm-12">
						<table class="table table-bordered table-sm">
							<thead>
								<tr>
									<th><?php echo line('prd_code'); ?></th>
									<th><?php echo line('prd_name'); ?></th>
									<th><?php echo line('prd_serial_number'); ?></th>
									<template v-if="item.id==0">
										<th><?php echo line('bod_borrow_quantity'); ?></th>
									</template>
									<template v-else>
										<th><?php echo line('bod_borrow_quantity'); ?></th>
										<th><?php echo line('bod_return_quantity'); ?></th>										
									</template>
									<th v-if="item.id==0">&nbsp;</th>
								</tr>
							</thead>
							<tbody>							
								<template v-if="item.products && item.products.length > 0">
									<tr v-for="(product, index) in item.products" class="table-light">
										<td>{{ product.code }}</td>
										<td>{{ product.name }}</td>
										<td>{{ product.serial_code }}</td>
										<template v-if="item.id==0">
											<td>
												<?php echo form_number(array('v-model'=>'product.borrow_quantity', 'v-on:change'=>'changeQty(index)', 'class' => 'form-control form-control-sm', 'style'=>'width:100px;', 'autocomplete' => 'off')); ?>
											</td>
										</template>
										<template v-else>
											<td>{{ product.borrow_quantity | formatNumber }}</td>
											<td><?php echo form_number(array('v-model'=>'product.return_quantity', 'v-on:change'=>'changeQty(index)', 'class' => 'form-control form-control-sm', 'style'=>'width:100px;', 'autocomplete' => 'off')); ?></td>											
										</template>
										<td v-if="item.id==0">
											<button v-on:click.prevent="removeProduct(index)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
										</td>
									</tr>
								</template>
								<template v-else>
									<tr>
										<td colspan="8" class="text-center text-danger"><?php echo line('no_record'); ?></td>
									</tr>
								</template>
							</tbody>
						</table>
					</div>
				</div>	
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">
				<?php line('close'); ?>
			</button>
			<button type="button" v-on:click.prevent="submitData()" class="btn btn-primary btn-save">
				<?php line('save'); ?>
			</button>
		</div>
	</form>
</div>

<script type="text/javascript">
Vue.component('v-select', VueSelect.VueSelect);
var app = new Vue({
	el: '#app',
	data: {
		item: {
			id: $('input[name=id]').val()			
		},
		members: [],
		products: [],
		productId: '',
		hideVal: true,
	},
	watch: {		
		productId: function(val){
			this.addProduct(val);
		}
	},
	methods: {
		submitData: function () {
			$('#modalForm').submit();
		},
		addProduct: function(product) {
			if(!product){
				return false;
			}
			/* ตรวจสอบยอดคงเหลือ */
			if(product.remain < 1){
				showBox('จำนวนสินค้าไม่เพียงพอ', 'error');				
				return false;
			}

			/* ถ้ารายการมีอยู่แล้วให้ปรับปรุงจำนวนเพิ่มขึ้นทีละ 1 */
			var index = this.item.products.map(function(e) { return e.id; }).indexOf(product.id);
			if(index >= 0){
				this.item.products[index].borrow_quantity = parseInt(this.item.products[index].borrow_quantity)+1; 
			} else {
				this.item.products.push(product);
			}
		},
		removeProduct: function(index){			
			this.item.products.splice(index, 1);
			this.changeHide();
		},
		changeQty: function(index){
			if(parseInt(this.item.products[index].borrow_quantity) < 1 && this.item.id==0){
				showBox('จำนวนห้ามน้อยกว่า 1', 'error');
				this.item.products[index].borrow_quantity =  1;
				return;
			}

			if(parseInt(this.item.products[index].return_quantity) < 1 && this.item.id!=0){
				showBox('จำนวนห้ามน้อยกว่า 0', 'error');
				this.item.products[index].return_quantity =  0;
				return;
			}
		},
		searchMember(search, loading) {
			loading(true);			
			this.search(loading, search, this);
		},
		search: _.debounce((loading, search, vm) => {
			axios.get(gUrl + 'api/members?keyword=' + search, {
				headers: {
					'api-key': gApiKey
				}
			}).then(
				response => {
					if (response.status === 200) {
						var reMember = response.data.map(obj => {
								var rObj = {};
								rObj = {value: obj.id, label: obj.code + ' - ' + obj.name}
								return rObj;
							});

						vm.members = reMember;
					}
					loading(false);
				}
			);
		}, 350),
		changeHide: function(){
			this.hideVal = this.hideVal ? false : true;
		}
	},
	created: function () {
		/* get data */
		axios.get(gUrl + 'api/borrows/' + this.item.id, {
			headers: {
				'api-key': gApiKey
			}
		}).then(
			response => {
				if (response.status === 200) {
					if (this.item.id != 0) {
						this.item = response.data;
					} else{
						this.item.products = [];
					}
				}
			}
		);

		/* product data */
		axios.get(gUrl + 'api/products?with_serial=1', {
		headers: {'api-key': gApiKey}
		}).then(
				response => {
					if (response.status === 200) {
						if(response.data.length > 0){							
								var reProducts = response.data.map(obj => {
								var rObj = {};
								var showSerial = (obj.is_serial_number == 1) ? ' (S/N:'+obj.serial_code+')' : '';		
								rObj = {
										id: obj.id+'-'+obj.serial_id,
										value: obj.id,
										name: obj.name,
										label: obj.code + ' - ' + obj.name + showSerial,
										code: obj.code,
										price: obj.price,
										remain: (obj.is_serial_number == 1) ? obj.serial_quantity : obj.quantity,
										borrow_quantity: 1,
										return_quantity: 0,
										is_serial_number: obj.is_serial_number,
										serial_number_id: obj.serial_id,
										serial_code: (obj.is_serial_number == 1) ? obj.serial_code : '-'
									}
								return rObj;
							});

							this.products = reProducts;
						}
					}
				}
		);
	},
	mounted: function () {
		/* borrow single date picker */
		$('input[name=borrow_date]').daterangepicker(datepickerOption, 
		function(start, end, label) {
			var dt = moment(start).format('DD/MM/YYYY');
			app.item.borrow_date = dt;
			app.changeHide();
		});

		/* schedule single date picker */
		$('input[name=schedule_date]').daterangepicker(datepickerOption, 
		function(start, end, label) {
			var dt = moment(start).format('DD/MM/YYYY');
			app.item.schedule_date = dt;
			app.changeHide();
		});

		/* return single date picker */
		$('input[name=return_date]').daterangepicker(datepickerOption, 
		function(start, end, label) {
			var dt = moment(start).format('DD/MM/YYYY');
			app.item.return_date = dt;
			app.changeHide();
		});
	}
});
</script>