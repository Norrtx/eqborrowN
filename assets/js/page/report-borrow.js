$(document).ready(function () {
	var searchData = {};
	var table = $('#tablelist').DataTable({
		pageLength: 10,
		serverSide: true,
		processing: true,
		ajax: {
			url: gUrl + gClass + '/get_borrow_datatables',
			data: function(d){
				return $.extend(d, searchData);
			}
		},
		'columns': [
			{
                data: 'member_code'
			},
			{
				data: 'member_name'
			},
			{
                data: 'borrow_date',
                render: function(data, type, row){
                    return moment(data).format('DD/MM/YYYY');
                }
			},
			{
                data: 'schedule_date',
                render: function(data, type, row){
                    return moment(data).format('DD/MM/YYYY');
                }
			},
			{
                data: 'return_date',
                render: function(data, type, row){
                    return data ? moment(data).format('DD/MM/YYYY') : '-';
                }
            },
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
			}
		]
	});

	// serach category
	$('body').on('change', 'select[name=item_type]', function(e){
		searchData.item_type = $('select[name=item_type]').val();
		table.ajax.reload();
	});
    
    $('body').on('click', '.btn-export', function(e){
		e.preventDefault();
        var keyword = $('input[type=search]').val();
        var balanceStatus = $('select[name=item_type]').val();
		window.location.href = gUrl + gClass + '/export_borrow?keyword='+keyword+'&balance_status='+balanceStatus;
	});
});
