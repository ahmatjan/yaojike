<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" charset="utf-8">
	$(function() {
		//添加内容页选项卡
		addTab = function(option) {
			var t = $('#center_tab');
			if (t.tabs('exists', option.title)) {
				t.tabs('select', option.title);
			} else {
				t.tabs('add', option);
			}
		}
		//二级模块添加内容页选项卡
		addTabs = function(title,href) {
			var t = $('#center_tab');
			if (t.tabs('exists', title)) {
				t.tabs('select', title);
			} else {
				t.tabs('add', {
					title : title,
					href : href,
					closable : true
				});
			}
		}
		//删除内容页选项卡
		delTabs = function(title) {
			var tab = $('#center_tab').tabs('getTab',title);
			var tabIndex = $('#center_tab').tabs('getTabIndex', tab);
			if (tabIndex == 0) {
				msgBox('<?php echo C(session('language').'.msg');?>', '<?php echo C(session('language').'.mianbanguanbi');?>');
			} else {
				$('#center_tab').tabs('close', tabIndex);
			}
		}
		$('#center_tab').tabs({
			tools : [ {
				iconCls : 'icon-cancel',
				handler : function() {
					var tab = $('#center_tab').tabs('getSelected');
					var tabIndex = $('#center_tab').tabs('getTabIndex', tab);
					if (tabIndex == 0) {
						msgBox('<?php echo C(session('language').'.msg');?>', '<?php echo C(session('language').'.mianbanguanbi');?>');
					} else {
						$('#center_tab').tabs('close', tabIndex);
					}
				}
			} ]
		});
		//检查用户密码是否还是初始状态
		$.post('<?php echo U(GROUP_NAME.'/Main/checkPwd');?>', function(data) {
			if (data) {
				var cPwd = $('<div/>').dialog({
					href : '<?php echo U(GROUP_NAME.'/Main/pwdChange');?>',
					title : '<?php echo C(session('language').'.xiugaimorenmima');?>',
					width : 450,
					height : 250,
					modal : true,
					closable : false,
					onClose : function() {
						cPwd.dialog('destroy');
					},
					buttons : [ {
						iconCls : 'icon-ok',
						text : '<?php echo C(session('language').'.genggaianniu');?>',
						handler : function() {
							
						}
					} ]
				});
			}
		});
	});
</script>
<div id="center_tab" class="easyui-tabs" data-options="border:false,fit:true">
	<div title="<?php echo C(session('language').'.shouye');?>" style="padding: 20px;"></div>
</div>