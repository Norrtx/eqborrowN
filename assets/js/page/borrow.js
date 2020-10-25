$(document).ready(function () {
	var table = $('#tablelist').DataTable({
		pageLength: 10,
		serverSide: true,
		processing: true,
		ajax: {
			url: gUrl + gClass + '/get_datatables'
		},
		'columns': [
            {
				data: 'member_code',
				render: function (data, type, row) {
					return '<a href="' + gUrl + gClass + '/main_form/' + row['id'] + '" data-id="' + row['id'] + '" data-toggle="modal" data-target="#ajaxLargeModal" class="btn-edit">' + data + '</a> ';
				}
            },
            {
				data: 'member_name'
            },
            {
				data:'borrow_date',
				render: function(data, type, row){
					return moment(data).format('DD/MM/YYYY');
				}
            },
            {
				data:'schedule_date',
				render: function(data, type, row){
					return moment(data).format('DD/MM/YYYY');
				}
            },
			{
				data: 'id',
				render: function (data, type, row) {
					var dataName = row['name'];
					var btnPrintA4 = '<a href="' + gUrl + 'borrow/pdf/' + data + '?page=a4" role="button" class="btn btn-sm btn-outline-dark" target="_blank"><i class="fa fa-print"></i> ' + gPrint + ' A4</a> ';
					var btnPrintA5 = '<a href="' + gUrl + 'borrow/pdf/' + data + '?page=a5" role="button" class="btn btn-sm btn-outline-dark" target="_blank"><i class="fa fa-print"></i> ' + gPrint + ' A5</a> ';
					var btnDelete = '<a href="#" data-href="' + gUrl + 'api/borrows/' + data + '" data-id="' + data + '" data-name="' + dataName + '" role="button" class="btn btn-outline-danger btn-sm btn-delete"><i class="fa fa-trash"></i> ' + gDelete + '</a>';
					return btnPrintA4 + btnPrintA5 + btnDelete;
				},
				orderable: false
			}
		]
	});

	$('#ajaxLargeModal').on('shown.bs.modal', function (e) {
		$('#modalForm').validate({
			submitHandler: function (form) {				
				if(!app.item.member){
					showBox('กรุณาเลือกสมาชิก', 'warning');
					return false;
				}
				if(app.item.products.length === 0){
					showBox('กรุณาเลือกรายการสินค้า', 'warning');
					return false;
				}

				axios.post(gUrl + 'api/borrows', app.item, {headers:{'api-key': gApiKey}})
				.then(function (response) {
					if(response.status === 200){
						showBox('บันทึกข้อมูลสำเร็จ', 'success');
						table.ajax.reload();
					} else {
						showBox('Status not 200', 'error');
					}
					$('#ajaxLargeModal').modal('hide');
				})
				.catch(function (error) {
					console.log(error.response);
					var text = '';
					for(var i=0; i<error.response.data.products.length; i++){
						text += error.response.data.products[i].label + '(คงเหลือ '+ error.response.data.products[i].remain +')<br/>';
					}
					text = '<span class="text-danger text-left" style="font-size:14px;">'+text+'</span>';
					showBox(error.response.data.message, 'error', text);
				});				
				return false;
			},
			rules: {
				borrow_date:{
					required: true
				},
				schedule_date:{
					required: true
				},
				return_date:{
					required: function(){
						return ($('input[name=id]').val() != 0) ? true : false;
					}
				}
			},
			messages: {
			},
			errorElement: 'span',
			errorPlacement: function (error, element) {
				error.addClass("error-block");
				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.parent("label"));
				} else if (element.parent('.input-group').length) {
					error.insertAfter(element.parent()); /* radio checkbox? */
				} else if (element.hasClass('select2')) {
					error.insertAfter(element.next('span')); /* select2 */
				} else {
					error.insertAfter(element);
				}
			},
			highlight: function (element, errorClass, validClass) {
				$(element).parents('.form-group').addClass('has-error').removeClass('has-success');
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).parents('.form-group').addClass('has-success').removeClass('has-error');
			}
		});
	});

	/* Delete button */
	$('body').on('click', '.btn-delete', function (e) {
		e.preventDefault();
		var deleteLink = $(this).attr('data-href');
		var id = $(this).attr('data-id');
		var callback = function () {
			setTimeout(function () {

				axios.delete(deleteLink, {
					headers: {'api-key': gApiKey}
				}).then(function (response) {
					showBox('ลบข้อมูลสำเร็จ', 'success');
					table.ajax.reload();
				})
				.catch(function (error) {
					showBox(error.response.data.message, 'error');
				});
			}, 100);
		}

		confirmBox('ลบข้อมูล', callback);
	});

	/* export excel */
	$('body').on('click', '.btn-export-borrow', function(e){
		e.preventDefault();
		var keyword = $('input[type=search]').val();
		window.location.href = gUrl + gClass + '/export_borrow?keyword='+keyword;
	});

	$('body').on('click', '.btn-export-borrow-list', function(e){
		e.preventDefault();
		var keyword = $('input[type=search]').val();
		window.location.href = gUrl + gClass + '/export_borrow_list?keyword='+keyword;
	});
});
