<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title><?php echo ($site_title); ?></title><script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.0.min.js"></script><script type="text/javascript" src="__PUBLIC__/jquery-easyui-1.3.4/jquery.easyui.min.js"></script><script type="text/javascript" src="__PUBLIC__/jquery-easyui-1.3.4/locale/easyui-lang-zh_CN.js"></script><script type="text/javascript" src="__PUBLIC__/js/common.js"></script><script type="text/javascript" src="__PUBLIC__/jquery-easyui-1.3.4/jquery.datagrid.extend.js"></script><link rel="stylesheet" href="__PUBLIC__/jquery-easyui-1.3.4/themes/bootstrap/easyui.css" type="text/css"><link rel="stylesheet" href="__PUBLIC__/jquery-easyui-1.3.4/themes/icon.css" type="text/css"><link rel="stylesheet" href="__PUBLIC__/css/icon.css" type="text/css"><link rel="stylesheet" href="__PUBLIC__/css/common.css" type="text/css"></head><body class="easyui-layout">	<div data-options="region:'north',href:'<?php echo U(GROUP_NAME.'/Main/north');?>'" style="height: 70px; overflow: hidden;"></div>	<div data-options="region:'south',href:'<?php echo U(GROUP_NAME.'/Main/south');?>'" style="height: 40px; overflow: hidden;"></div>	<div data-options="region:'west',href:'<?php echo U(GROUP_NAME.'/Main/west');?>',title:'<?php echo C(session('language').'.menuname');?>',split:true,iconCls:'icon-tip'" style="width: 200px;"></div>	<div data-options="region:'center',href:'<?php echo U(GROUP_NAME.'/Main/center');?>',title:'<?php echo C(session('language').'.center');?>',iconCls:'icon-sum'" style="overflow: hidden;"></div>
</body></html>