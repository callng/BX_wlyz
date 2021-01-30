function loading_start () {
	$(".colorful_loading_frame,.colorful_loading").css("display", "block");
}
function loading_close () {
	$(".colorful_loading_frame,.colorful_loading").css("display", "none");
}
function bx_load (text) {
    //不声明var 默认全局
    load_index =
    layer.msg(text, {
        icon: 16,
        time: 0,
        shade: 0.3
    });
}
function bx_load_close () {
    layer.close(window.load_index);
}
/*
 * @param string result 
 * @param string fun
 */
msg_icon = new Array();
msg_icon['success'] = 1;
msg_icon['error'] = 2;
msg_icon['warning'] = 0;
msg_icon['question'] = 3;
function bx_msg(result,fun) {
	
	try {
		var res = JSON.parse(result);
		if(res.state == "success" && fun != null){
			//当等于success时要执行的代码   
			eval(fun);
        }
		//多类型  灵活
		if(res.type == 'msg'){
			layer.msg(res.text, {
                icon: window.msg_icon[res.state],
            });
		}
		if(res.type == 'alert'){
			layer.alert(res.text, {
                icon: window.msg_icon[res.state],
                title: res.title,
                closeBtn: 2,
            });
		}
	} catch (e) {
  		layer.alert(result, {
            icon: window.msg_icon['error'],
            title: '程序出错：',
            closeBtn: 2,
        });
	}
}
function auto_page (age, page, num,js) {
	var body = '';
	num = Math.min(age,num);
	if (page > age || page < 1){
    	return;
    }
	var end = page + Math.floor(num / 2) <= age ? page + Math.floor(num / 2) : age;
	var start = end - num + 1; 
	if (start < 1) { 
        end -= start - 1;
        start = 1;
    }
	for (var i = start; i <= end; i ++) {
        if (i == page)
            body += '<li class="page-item disabled"><a class="page-link" onclick="' + js + '(' + i + ')" href="javascript:;">' + i + '</a></li>';
        else
            body += '<li class="page-item"><a class="page-link" onclick="' + js + '(' + i + ')" href="javascript:;">' + i + '</a></li>';
    }
	return body;
	
}
function bx_page (conut,page,limit,js) {
	count = parseInt(conut);
	page = parseInt(page);
	limit = parseInt(limit);
	var age = Math.ceil(conut/limit);
	var big = limit*page;
	var small = big-limit+1;
	var bodybut = '';
	if(page != '1' ){
		bodybut += '<li class="page-item"><a class="page-link" onclick="'+ js + '(1)" href="javascript:;">首页</a></li>\
		<li class="page-item"><a class="page-link" onclick="' + js + '(' + (page-1) + ')" href="javascript:;">上一页</a></li>';
	}
	bodybut += auto_page(age,page,8,js);
	if(page != age){
		bodybut += '<li class="page-item"><a class="page-link" onclick="' + js + '(' + (page+1) + ')" href="javascript:;">下一页</a></li>\
		<li class="page-item"><a class="page-link" onclick="' + js + '(' + age + ')" href="javascript:;">尾页</a></li>';
		
	}else{
		big = conut;
	}
pagebody = bodybut + '<li class="page-item disabled">\
<span class="page-link" href="#" tabindex="-1">' + page + '/' + age + '</span>\
</li>\
<li class="page-item disabled">\
<span class="page-link" href="#" tabindex="-1">从' + small + '-' + big + '条</span>\
</li>\
<li class="page-item disabled">\
<span class="page-link" href="#" tabindex="-1" style="border-right-width: 0px;right: 1px;">共' + conut + '条数据</span>\
</li>\
<li class="page-item">\
<input onclick="$(this).keydown(function(e){if(e.keyCode==13){go_' + js + '();}});" id="go_' + js + '" \
style="width:100px;panding;padding-left: 0px;padding-right: 0px;border-radius: 0px;text-align: center;margin-left: -1px;" class="form-control" type="number" value="' + page + '" >\
</li>\
<script type="text/javascript">\
    	function go_' + js + ' () {\
    		var b;\
    		if($("#go_' + js + '").val() >= ' + age + ' || $("#go_' + js + '").val() < 1){\
				b = ' + age + ';\
				if($("#go_' + js + '").val() < 1){\
					b = 1;\
				}\
			}else{\
				b = $("#go_' + js + '").val()\
			}\
			' + js + '(b);\
    	}\
</script>\
<li class="page-item">\
<a class="page-link" style="left: 1px;border-left-width: 0px;" onclick="go_' + js + '();" href="javascript:;">GO</a>\
</li>';
	return pagebody;
}

function bx_time(sj){
    var time = Array();
    var  now    = new Date(sj*1000);
    time[0]   =now.getFullYear();//年
    time[1]  =now.getMonth()+1;//月 
    time[2]   =now.getDate();//日
    time[3]   =now.getHours(); //小时
    time[4] =now.getMinutes();  //分钟
    time[5] =now.getSeconds();//秒
    for (var i = 0; i < time.length;i++) {
    	if(time[i] <= 9){
    	    time[i] = "0" + time[i];
        }
    }
   
    return  time[0]+"-"+time[1]+"-"+time[2]+" "+time[3]+":"+time[4]+":"+time[5];   
}

function export_card(res,v_type) {
	var result = "";
	switch (v_type){
		case 'text':
		    $(res).each(function(i){
		        result += $(this).text() + "\r\n";
            });
			break;
		case 'val':
		    $(res).each(function(i){
		        result += $(this).val() + "\r\n";
            });
			break;
		default:
		    $(res).each(function(i){
		        result += $(this).text() + "\r\n";
            });
			break;
	}
	result = result.slice(0,-2);//细节  去除最后换行
	var a = new Blob([result], {type: "text/plain;"});
	var now = new Date();
	var name = now.getFullYear() + '年' + (now.getMonth()+1) + '月' + now.getDate() + '日' + now.getHours() + '时' + now.getMinutes() + '分' + now.getSeconds() + '秒';
	saveAs(a, "卡密导出_" + name + ".txt");
}