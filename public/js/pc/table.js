/*********************************** 表格排序筛选 *****************************************/

//表格筛选改变表头字体颜色
$('.table-screening-check').change(function(){
	
	if( $(this).parents('.table-screening').find('.table-screening-check:checked').length > 0 ){
		$(this).parents('th').addClass('choi');
	}else{
		$(this).parents('th').removeClass('choi');
	}
});

//表格排序点击可排序表头
$('.table-rank').click(function(){
	var input = $(this).prev('input');
	var inputVal = $(input).val();
	$('.table-rank-input').each(function(i){
		$(this).val('');
	});
	if( inputVal == '' ){
		$(input).val("ascending");
	}else if( inputVal == "ascending" ){
		$(input).val("descending");
	}else{
		$(input).val('');
	}
	return true;
});

/*********************************** 表格翻页 ****************************************/
//首页
$('#firstPage').click(function(){
	$('.table-page .pages').val('1');
	return true;
});

//尾页
$('#lastPage').click(function(){
	$('.table-page .pages').val( $('.table-page .last_page').val() );
	return true;
});

//上一页
$('#prevPage').click(function(){
	var current_page = $('.table-page .current_page').val();
	if( Number(current_page) <= 1 ){
		return false;
	}else{
		$('.table-page .pages').val( Number(current_page) - 1 );
		return true;
	}
});

//下一页
$('#nextPage').click(function(){
	var current_page = $('.table-page .current_page').val();
	var last_page = $('.table-page .last_page').val();
	if( Number(current_page) >= Number(last_page) ){
		return false;
	}else{
		$('.table-page .pages').val( Number(current_page) + 1 );
		return true;
	}
});
