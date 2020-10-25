$(document).ready(function () {
	var searchData = {};
	var table = $('#tablelist').DataTable({
		pageLength: 10,
		serverSide: true,
		processing: true,
		ajax: {
			url: gUrl + gClass + '/get_stock_datatables',
			data: function(d){
				return $.extend(d, searchData);
			}
		},
		'columns': [
			{
				data: 'code'				
			},
			{
				data: 'name'
			},
			{
				data: 'category_name'
			},
			{
				data: 'serial_code'
			},
			{
				data: 'quantity'
			},
			{
				data: 'unit_name'
			},
			{
				data: 'is_active',
				render: function(data, type, row){
                    var result;
                    if(data == 1){
                        result = '<span class="badge badge-pill badge-primary">ใช้งาน</span>';
                    } else {
                        result = '<span class="badge badge-pill badge-danger">ยกเลิก</span>';
                    }
                    return result;
                }
			}
		]
	});

	// serach category
	$('body').on('change', 'select[name=category_id]', function(e){
		searchData.category_id = $('select[name=category_id]').val();
		table.ajax.reload();
	});

	// init select2
	$('.select2').select2();

	$('body').on('click', '.btn-export', function(e){
		e.preventDefault();
		var keyword = $('input[type=search]').val();
		var categorie_id =  $('select[name=category_id]').val();
		window.location.href = gUrl + gClass + '/export_stock?keyword='+keyword+'&categorie_id='+categorie_id;
	});
});
