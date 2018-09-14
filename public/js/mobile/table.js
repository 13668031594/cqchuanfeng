function tableList( url, ths, tds, urls){
	if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
          if (pages > last_page) {
               $('#nomore').show();
          } else {
               $('#loading').show();
               if (ors) {
                    ors = false;
                    var datas = $('#form').serialize();
                    console.log(datas);
                    $.getJSON( url + '?is_page=1&page=' + pages, function (data) {
                           console.log(data);
                          if( data.status == 'success' ){
                          	var arrays = data.test.list.data.data;
                          	var status = null;
                          	var is_member = null;
                          	var members = null;
                          	undefined != data.test.status ? status = data.test.status : status = null;
                          	undefined != data.test.status ? is_member = data.test.status : is_member = null;
                          	undefined != data.test.members ? members = data.test.members : members = null;
                          	$(arrays).each(function(i){
                          		var tr = $('.table-tr').eq(0).clone(true);
                          		
                          		//添加id
                          		$(tr).find('.table-th-check input').attr({
                          			'id': arrays[i].id,
                          			'value': arrays[i].id
                          		});
                          		$(tr).find('.table-th-check label').attr( 'for', arrays[i].id );
                          		
                          		//添加th文本
                          		$(tr).find('.table-th-texts').each(function(x){
                          			
                          			if( ths[x] == 'status' ){
                          				undefined != [ arrays[i][ ths[x] ] ] ? $(this).text( status[ arrays[i][ ths[x] ] ] ) : '无';
                          			}else if( ths[x] == 'is_member' ){
                          				undefined != [ arrays[i][ ths[x] ] ] ? $(this).text( is_member[ arrays[i][ ths[x] ] ] ) : '无';
                          			}else if( ths[x] == 'member_list_id' ){
                          				undefined != [ arrays[i][ ths[x] ] ]['account_number'] ? $(this).text( members[ arrays[i][ ths[x] ] ]['account_number'] ) : '无';
                          			}else{
                          				undefined != [i][ths[x]] ? $(this).text( arrays[i][ths[x]] ) : '无';
                          			}
                          		});
                          		
                          		//添加td文本
                          		$(tr).find('.table-td-texts').each(function(y){
                          			if( tds[y] == 'conversion' ){
                          				undefined != [i][tds[y]] ? $(this).text( arrays[i][tds[y]] * 100 + '%' ) : '无';
                          			}else if( tds[y] == 'member_list_id'){
                          				undefined != members[ arrays[i][ tds[y] ] ]['account_number'] ? $(this).text( members[ arrays[i][ tds[y] ] ]['account_number'] ) : '无';
                          			}else{
                          				undefined != [i][tds[y]] ? $(this).text( arrays[i][tds[y]] ) : '无';
                          			}
                          		});
                          		
                          		//添加按钮路径
                          		$(tr).find('.table-td-handle a').each(function(z){
                          			if( $(this).hasClass('link') ){
                          				$(this).attr('href', urls[z].replace( /{id}/, arrays[i].id ) );
                          			}else{
                          				$(this).attr('lang', urls[z].replace( /{id}/, arrays[i].id ) );
                          			}
                          		});
                          		
                          		$(tr).find('.table-td').hide();
                          		
                          		$('#tbody').append( tr );
                          	});
                          	pages++;
                          }else{
                          	console.log('其他：', data);
                          }
                           $('#loading').hide();
                           ors = true;
                    });
               }
          }
     }
}

//表格下拉
$('.table-th-more').on( 'touchstart', function(){
     $(this).parents('.table-th').next('.table-td').slideToggle(300);
} );

//筛选列表
/*$('#table-choice').on( 'touchstart', function(){
     $('.screens').toggle();
     $('.choice').animate( {
          right: 0,
     }, 300 );
} );*/

//点击筛选屏障关闭筛选
$('.screens').on( 'touchstart', function(){
     $(this).toggle();
     $('.choice').animate( {
          right: '-150%',
     }, 300 );
} );

//筛选关闭按钮
$('#choice-close').on( 'touchstart', function(){
     $('.screens').toggle();
     $('.choice').animate( {
          right: '-150%',
     }, 300 );
} );

//筛选列表禁止冒泡
$('.choice').on('touchstart', function(event){
     event.stopPropagation();
});

//点击筛选标题显示隐藏筛选内容
$('.choice-title').on('touchstart', function(){
	$(this).next('.list').slideToggle();
});

//排序
$('.choice-out input:radio').change(function(){
	if( $(this).val() == '' ){
		return false;
	}else{
		$('.choice-out :radio').each(function(){
			if( $(this).val() == '' ){
				$(this).prop('checked', true);
			}else{
				$(this).prop('checked', false);
			}
		});
		
		$(this).prop('checked', true);
	}
})

//确认筛选
$('#choiceSubmit').on('touchstart', function() {
	$('.screens').toggle();
     $('.choice').animate( {
          right: '-150%',
     }, 300 );
     return true;
});

//搜索图标点击
/*$('#searchIcon').on('touchstart', function(){
     $('#searchInput').fadeToggle(300);
     $(this).hasClass('table-searchIcon1') ? $(this).removeClass('table-searchIcon1') : $(this).addClass('table-searchIcon1');
});*/