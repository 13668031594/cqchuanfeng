$(".just-number").keyup(function(){  //keyup事件处理
     $(this).val($(this).val().replace(/\D/g,''));
}).bind("paste",function(){  //CTR+V事件处理
     $(this).val($(this).val().replace(/\D/g,''));
});

$(".just-money").keyup(function(){
     $(this).val($(this).val().replace(/[^0-9.]/g,''));
}).bind("paste",function(){  //CTR+V事件处理
     $(this).val($(this).val().replace(/[^0-9.]/g,''));
});

var srn = $('.screen');
var scrn = $('.scrn');
var popup = $('#popup');
var pop = $('#pop');
var yes = $('#yes');
var no = $('#no');
var sure = $('#sure');
var notsure = $('#notsure');
//密码框

//返回上一页
$('.back').click(function(){
	history.back();
});

//刷新页面
$('.refresh').click(function(){
	location.reload();
});

//注销
$('.logout').click( function(){
	var url = $('#exit').val();
	$(scrn).toggle();
	$(pop).find('.pop-text').text('确定要注销并退出吗？');
	$(yes).attr('href', url).text('确定').show();
	$(no).attr('href', 'javascript:;').text('取消').show().click(function(){
		$(scrn).hide();
		$(pop).hide();
	});
	popupShow( $(pop) );
} );

//操作成功失败提示弹窗位置居中显示
function popupShow( obj ){
	$(obj).css({
		'margin-left': '-' + Math.ceil( $(obj).width() / 2 ) + 'px',
		'margin-top': '-' + Math.ceil( $(obj).height() / 2 ) + 'px'
	}).show(300);
}

//ajax表单提交前验证函数
function verify( ajax, form, func, text ) {
     var num = 0;
     $('#form').find('.inputs').each( function(){
          if( !$(this).val() || $(this).val() == '' ){
               $(this).parents('.inputOut').next('.hint').show(200);
               num++;
          }else{
               $(this).parents('.inputOut').next('.hint').hide(200);
          }
     } );

     if( num != 0 ){
          return false;
     }else{
          ajax( form, func, text );
     }
}


var btnText = $('#submit').text();
var btnColor = $('#submit').css('background');

function Ajax(  form, func, text, dataType, type  ){
     if(  undefined == type ){
          type = $(form).attr('method');
     }

     if(  undefined == dataType ){
          dataType = 'json'
     }

     if( $(form).find('input:file').length <= 0 ){
          console.log('序列化');
          var datas = $(form).serialize();
          console.log('datas', datas);
          $.ajax({
               type: type,
               url: $(form).attr('action'),
               dataType: dataType,
               data: datas,
               beforeSend: handles(text),
               complete: function(){},
               success: function(data){
                    console.log('data',data);
                    func(data) ;
               },
               error: function (data) {
                    console.log('error', data);
               }
          });
     }else{
          console.log('FormData');
          var datas = new FormData($(obj)[0]);
          /*$(obj).find('input').each(function(){
               console.log('123');
               if( $(this).attr('type') != 'file' ){
                    console.log($(this).attr('name'));
                    datas.append( $(this).attr('name'), $(this).val() );
               }else{
                    console.log( $(this)[0].files[0] );
                    datas.append( $(this).attr('name'), $(this)[0].files[0] );
               }
          });*/
          $.ajax({
               type: type,
               url: $(form).attr('action'),
               dataType: dataType,
               data: datas,
               cache: false,			         //设置为false不缓存此页面
               contentType: false,               //'multipart/form-data',        //不可缺参数  内容编码类型   默认值："application/x-www-form-urlencoded"
               processData: false,               //不可缺参数  将data传递的不是字符串的数据处理转化成一个查询字符串，以配合默认内容类型 "application/x-www-form-urlencoded"  默认值：true
               beforeSend: handles(text),
               complete: function(){},
               success: function(data){
                    console.log(data);
                    func(data) ;
               },
               error: function(data){
                    console.log('error', data);
               },
          });
     }

}

function AjaxFuncs(  url, func, type ){
     if( undefined == type ){
          type = 'post';
     }

     $.ajax({
          type: type,
          url: '/' +url,
          dataType: 'json',
          data: '',
          beforeSend: handles,
          complete: function(){},
          success: function(data){
               func(data) ;
          },
     });

}

function handles( text ){
     if( undefined == text ){
          text = '正在提交...'
     }
     $('#submit').attr('disabled','disabled').css('backgroundColor', '#dedede').text(text);
}

function success(data){

     if( data ){
          //var popup = $('#popup');
          $('.screen').show();
          $('#submit').css('background', btnColor).text(btnText);
          popupShow(popup);
          //判断state是否为true
          if( data.state == true ){
               //如果没有传提示则默认‘操作成功’，否则循环打印提示
               if( data.text == '' || undefined == data.text ){
                    $(popup).find('.pop-text').text('操作成功');
               }else{
                    var texts = '';
                    $(data.text).each(function(i){
                         texts += data.text[i] + '<br/>';
                    });
                    $(popup).find('.pop-text').html(texts);
               }

               //判断有没有传路径，没有则按钮默认‘确定’，点击刷新页面
               if( data.url == '' || undefined == data.url ){
                    $(sure).text('确定').show().click(function(){
                         location.reload();
                    });
               }else{
					if( data.url == 'close' ){
						
						$(sure).hide();
						$(notsure).click(function(){
		                    $(srn).hide();
		                    $(popup).hide();
		               });
					}else{
						
						//判断again是否为false，如果为false再判断buttonText有没有值，没有则默认按钮文字为'确定'并将路由放入，否则将buttonText的值作为按钮文字
	                    if( data.again == false ){//订单绑定
	                    	
	                         if( data.buttonText == '' || undefined == data.buttonText ){
	                              $(sure).text('确定');
	                         }else{
	                              $(sure).text(data.buttonText);
	                         }
	                         
	                         $(sure).attr('href',data.url).show();
	                    }else{
	
	                         //again为true,判断buttonText有无值，无则默认按钮文字‘确定’否则为buttonText的值并绑定单击事件，点击再次弹窗
	                         if( data.buttonText == '' || undefined == data.buttonText ){
	                              $(sure).text('确定');
	                         }else{
	                              $(sure).text(data.buttonText);
	                         }
	                         
	                         $(sure).attr('href','javascript:;').show().on('click', function(){
	                               $(srn).hide();
	                               $(popup).hide();
	                               AjaxFuncs( data.url, success );
	                               $(this).off('click');
	                          });
	                    }
	                    
	                    $(sure).show();
	                    $(notsure).click(function(){
		                    $(srn).hide();
		                    $(popup).hide();
		                    location.reload();
		               });
					}
               }

               $('#success').show();
               $('#fail').hide();
          }else{         //state不为true时，判断text有没有值，没有则默认提示‘请重试’，否则循环打印text作为提示

               if( data.text == '' || undefined == data.text ){
                    $(popup).find('.pop-text').text('请重试');
               }else{
                    var texts = '';
                    $(data.text).each(function(i){
                         texts += data.text[i] + '<br/>';
                    });
                    $(popup).find('.pop-text').html(texts);
               }

               //判断url是否有值，没有则隐藏确认按钮，否则再判断buttonText是否有值，没有则默认‘确定’，否则为buttonText的值并将url作为链接地址
               if( data.url == '' || undefined == data.url ){
                    $(sure).hide();
                    $(srn).click(function(){
                    		$(popup).hide(300);
                    		$(this).hide().off('click');
                    });
               }else{
                    if( data.buttonText == '' || undefined == data.buttonText ){
                         $(sure).text('确定');
                    }else{
                         $(sure).text(data.buttonText);
                    }
                    
                    $(sure).attr('href', data.url).show();
               }
               $('#success').hide();
               $('#fail').show();
               $(notsure).text('关闭').show().click(function(){
                    $(srn).hide();
                    $(popup).hide();
                    $(this).off('click');
               });

          }
          $('#submit').removeAttr('disabled');
     }
}


//表格全选
$('.checkAll').change( function(){
     var isCheck = $(this).is(':checked');
     $('#tbody .table-check').each( function(){
          $(this).prop( 'checked', isCheck );
     } );
} );

//表格单击行选中
$('#tbody tr').click( function(){
     var input = $(this).find('.table-check');
     var isCheck = input.is(':checked');
     input.prop( 'checked', !isCheck );
} );


/************************** 表格批量删除、批量撤回 ************************/

//批量删除
/*$('.handle-delete').click(function(){
     handle( '', 'delete' );
});*/

//批量撤回
/*$('.handle-withdraw').click(function(){
     handle( '', 'put' );
});*/

//批量领取
/*$('.handle-get').click(function(){
     handle( '', '' );
});*/

//表格操作按钮禁止冒泡
$('.table-handle-item').click(function(event){
	event.stopPropagation();
});

//表格操作按钮提示框
$('.table-delete').click(function(){
	tableHandle( $(this), '删除' );
});

$('.table-withdraw').click(function(){
	//console.log('撤回1');
	tableHandle( $(this), '撤回' );
});

$('.table-get').click(function(){
	tableHandle( $(this), '领取' );
});

//输入密码的删除
$('.table-deletePassword').click(function(){
	tableHandle( $(this), '删除', '?password=' );
});

function tableHandle( $obj, $text, $set ){
	$(scrn).show().click(function () {
			//console.log('点击了遮罩层');
           $(this).hide();
           $(pop).hide(300);
           if(undefined != $set){
           	$('#pas').val('').hide();
           }
           $(this).off('click');
      });
      if( undefined == $text || $text == '' ){
      	$text = '继续操作';
      }
      $(pop).find('.pop-text').text('确定要' + $text + '吗？');
      
      if(undefined != $set){
       	$('#pas').val('').show();
       }
      
      if( undefined != $set ){
      		$(yes).attr('href', 'javascript:;').text('确定').show().click(function(){
      				console.log($obj.attr('lang') + $set + $('#pas').val());
      				$.getJSON($obj.attr('lang') + $set + $('#pas').val(), function(data){
      					if(data){
      						success(data);
      					}
      				});
      				$(pop).hide(300);
      				$(scrn).hide();
      				$(this).off('click');
      		});
      }else{
      		$(yes).attr('href', $obj.attr('lang')).text('确定').show();
      }
      $(no).text('取消').show().click(function () {
           $(scrn).hide();
           $(pop).hide(300);
           if(undefined != $set){
           	$('#pas').val('').hide();
           }
           $(this).off('click');
      });
      popupShow( pop );
}


function handle( $url, $type, $text, $style, $set ) {		//$style:套餐兑换 测绘操作 + '/edit'  $set: 客户、会员删除操作，密码输入  + '?password='
     var inputs = $('#tbody input[type="checkbox"]:checked');
     var inputs_length = inputs.length;
     var inputs_value = '';
     if (inputs_length <= 0) {
          $(scrn).show().click(function () {
               $(this).hide();
               $(pop).hide(300);
               $(this).off('click');
          });
          $(pop).find('.pop-text').text('请至少选择一项！');
          $(yes).hide();
          $(no).text('确定').click(function () {
               $(scrn).hide();
               $(pop).hide(300);
               $(this).off('click');
          });
          popupShow( pop );
          return false;
     } else {
     	
     	$(scrn).show().click(function () {
               $(this).hide();
               $(pop).hide(300);
               if(undefined != $set){
	           	$('#pas').val('').hide();
	           }
               $(this).off('click');
          });
          if( undefined == $text || $text == '' ){
          	$text = '继续操作';
          }
          
          //计算领取积分总数
          var inte = 0;
          inputs.each(function(){
          	inte += Number($(this).parents('.table-tr').find('.integrals').text());
          });
          if( $text == '领取' ){
          	$(pop).find('.pop-text').text('确定要' + $text + '这' + inputs_length + '项吗？领取总积分为' + inte + '；');
          }else{
          	$(pop).find('.pop-text').text('确定要' + $text + '这' + inputs_length + '项吗？');
          }
          if(undefined != $set){
           	$('#pas').val('').show();
           }
          $(yes).attr('href', 'javascript:;').text('确定').show().click(function(){
          		$(scrn).hide();
          		$(pop).hide(300);
          		$(this).off('click');
          		
          		inputs.each(function (i) {
	               if (i != ( inputs_length - 1 )) {
	                    inputs_value += $(this).val() + ',';
	               } else {
	                    inputs_value += $(this).val();
	               }
	          });
				
				var urls = $url + inputs_value;
				if( undefined != $style && $style != '' ){
					urls += $style;
				}
				if( undefined != $set && $set != '' ){
					urls += $set + $('#pas').val();
				}
				console.log(urls);
	          $.ajax({
	               url: urls,
	               type: $type,
	               dataType: 'json',
	               success: function (data) {
	                   console.log(data);
	                   success(data);
	               },
	               error: function (value) {
	                    console.log('error', value);
	               }
	          });
	          
	          if(undefined != $set){
	           	$('#pas').val('').hide();
	           }
          });
          $(no).text('取消').show().click(function () {
               $(scrn).hide();
               $(pop).hide(300);
               if(undefined != $set){
	           	$('#pas').val('').hide();
	           }
               $(this).off('click');
          });
          popupShow( pop );
     }
}

