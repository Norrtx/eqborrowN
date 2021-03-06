$(document).ready(function () {
    var searchData = {};
    searchData.dashboard = true;
	var table = $('#tablelist').DataTable({
        searching: false,
        paging: false,
        bSort: false,
		pageLength: 10,
		serverSide: true,
		processing: true,
		ajax: {
			url: gUrl + '/report/get_borrow_datatables',
			data: function(d){
				return $.extend(d, searchData);
			}
		},
		'columns': [		
            {
                data: 'product_code'
            },
            {
                data: 'product_name'
            },
            {
                data: 'serial_code',
                render: function(data, type, row){
                    return data ? data : '-';
                }
            },
			{
				data: 'borrow_quantity'
            },
            {
                data: 'return_quantity'
            },
			{
				data: 'detail_status',
				render: function(data, type, row){
                    var result;
                    if(data == 1){
                        result = '<span class="badge badge-pill badge-primary">คืนแล้ว</span>';
                    } else {
                        result = '<span class="badge badge-pill badge-danger">ยืม</span>';
                    }
                    return result;
                }
            },
            {
                data: 'id',
                render: function(data, type, row){
                    var transDate = (row.modified_at) ? row.modified_at : row.created_at;
                    return moment(transDate).format('DD/MM/YYYY - hh:mm');                    
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
});
