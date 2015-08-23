<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?php echo ($site_title); ?></title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.0.min.js">
</script>
<script type="text/javascript" src="__PUBLIC__/jquery-easyui-1.3.4/jquery.easyui.min.js"></script>

<script type="text/javascript" src="__PUBLIC__/jquery-easyui-1.3.4/locale/easyui-lang-zh_CN.js"></script>

<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
<link rel="stylesheet" href="__PUBLIC__/jquery-easyui-1.3.4/themes/bootstrap/easyui.css" type="text/css">

<link rel="stylesheet" href="__PUBLIC__/jquery-easyui-1.3.4/themes/icon.css" type="text/css">

<link rel="stylesheet" href="__PUBLIC__/css/common.css" type="text/css">

<script type="text/javascript">
var win;
	
var verImg;
	
var index_index_loginForm;
	
$(function() {
	win = $("#index_index_window");
		
	verImg = $("#verImg");
		
	index_index_loginForm = $("#index_index_loginForm");
		
	$('#uid').focus();
		
	$("input").keypress(function(key) {
		if (key.keyCode == 13) {
			loginForm();
			
		}
		
	});
	
});

	
function reloadVerify() {
	var timenow = new Date().getTime();
		
	verImg.attr("src", "<?php echo U(GROUP_NAME.'/Login/verify/t');?>" + timenow);
	
}

	
function resetForm() {
	index_index_loginForm.form('clear');

	var timenow = new Date().getTime();

	verImg.attr('src', "<?php echo U(GROUP_NAME.'/Login/verify/t');?>" + timenow);
}

	
function loginForm() {
	if (index_index_loginForm.form('validate')) {
		$.post("<?php echo U(GROUP_NAME.'/Login/checkLogin');?>", index_index_loginForm.serialize(),function(data) {
			if (data.status) {
				msgBox(data.data, data.info);
				location.href = "<?php echo U(GROUP_NAME.'/Main/index');?>";
			} else {
				$.messager.alert(data.data, data.info);
			}
		}, "json");
	} else {
		msgBox('信息不全', '表单验证失败，请重试！');
	}
}

</script>


</head>

<body class="easyui-layout">
	<div data-options="region:'center'" style="padding: 5px; background: #fff;">
		<div id="index_index_window" class="easyui-window" data-options="draggable:false,modal:true,title:'系统登录',iconCls:'icon-tip',resizable:false,closable:false,minimizable:false,maximizable:false" style="width: 600px; height: 380px; padding: 5px; overflow: hidden;">
			<div style="height: 110px; background-color: #fff;">
<img src="__PUBLIC__/img/loginImg.jpg" border="0" width="576" height="110">
</div>
			<div style="margin-left: 70px; padding: 10px;">
				<form id="index_index_loginForm" method="post">
					<div style="margin-top: 10px;">
						<label for="uid">帐号:</label><input id="uid" name="uid" type="text" class="easyui-validatebox" data-options="required:true,validType:'minLength[3,18]',missingMessage:'输入工号'" style="width: 250px; height: 30px;" />
					
</div>
					<div style="margin-top: 5px;">
						
<label for="pwd">密码:</label><input id="pwd" name="pwd" type="password" class="easyui-validatebox" data-options="validType:'minLength[5,10]',required:true" style="width: 250px; height: 30px;" />
					</div>
					<div style="margin-top: 5px;">
						<label for="pwd">验证:</label><input id="verify" name="verify" type="text" class="easyui-validatebox" data-options="validType:'strLength[4]',missingMessage:'与下图片内容一至',required:true" style="width: 250px; height: 30px;" />
					</div>
					<div style="margin-top: 5px; margin-left: 37px;">
<img id="verImg" src="__URL__/verify/" style="cursor: pointer;">&nbsp;<a href="javascript:reloadVerify();">看不清，点击更换！</a>
</div>
					<div style="margin-top: 10px; float: right; margin-right: 10px;">
						<span><a id="btnSubmit" href="javascript:void(0);" onclick="loginForm()" class="easyui-linkbutton" data-options="iconCls:'icon-ok'">登录</a></span>
						<span><a id="btnReset" href="javascript:void(0);" class="easyui-linkbutton" onclick="resetForm()" data-options="iconCls:'icon-cancel'">重置</a></span>
					</div>
					<div style="clear: both;"></div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>