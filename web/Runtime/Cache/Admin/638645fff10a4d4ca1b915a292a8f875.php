<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">$('#west_navContent').accordion();</script>
<div id="west_navContent" class="easyui-accordion" data-options="fit:true,border:false">
	<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div title="<?php echo ($v["text"]); ?>"
			data-options="selected:true,iconCls:'icon-blank',tools : [ {
					iconCls : 'icon-reload',
					handler : function() {
						main_west_menu<?php echo ($i); ?>.tree('reload');
					}
				}, {
					iconCls : 'icon-redo',
					handler : function() {
						var node = main_west_menu<?php echo ($i); ?>.tree('getSelected');
						if (node) {
							main_west_menu<?php echo ($i); ?>.tree('expandAll', node.target);
						} else {
							main_west_menu<?php echo ($i); ?>.tree('expandAll');
						}
					}
				}, {
					iconCls : 'icon-undo',
					handler : function() {
						var node = main_west_menu<?php echo ($i); ?>.tree('getSelected');
						if (node) {
							main_west_menu<?php echo ($i); ?>.tree('collapseAll', node.target);
						} else {
							main_west_menu<?php echo ($i); ?>.tree('collapseAll');
						}
					}
				} ]"
			style="padding: 5px;">
			<ul id="main_west_menu<?php echo ($i); ?>" class="easyui-tree" data-options="url:'<?php echo U(GROUP_NAME.'/Main/menuData/',array('id'=>$v[id]));?>',lines:true"></ul>
		</div>
		<script type="text/javascript" charset="utf-8">					var main_west_menu<?php echo ($i); ?>;					$(function() {						main_west_menu<?php echo ($i); ?> = $('#main_west_menu<?php echo ($i); ?>');						main_west_menu<?php echo ($i); ?>.tree({							onLoadSuccess : function(node, data) {												//main_west_menu.tree('expandAll');								main_west_menu<?php echo ($i); ?>.tree('expandAll');							},							onClick : function(node) {												if (1==node.attributes.whetherclick) {														var url = '__APP__/Admin/' + node.attributes.name;														addTab({										title : node.text,										href : url,										tools : [ {											iconCls : 'icon-reload',											handler : function() {																				reloadTab();											}										} ],										closable : true									});								}							},						});							});				</script><?php endforeach; endif; else: echo "" ;endif; ?>
</div>