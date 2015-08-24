<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" charset="utf-8">

	$(function() {

		$('#effect_index_treegrid').datagrid({
			
			url : "<?php echo U(GROUP_NAME.'/Effect/index',array('getdatajson'=>'do'));?>",

			animate : false,

			fit : true,

			border : false,

			singleSelect : true,

			rownumbers : true,
			
			pagination : true,

			pageSize : 15,

			pageList : [ 15, 30, 45, 60 ],

			idField : 'hz_id',

			treeField : 'hz_id',

			columns : [ [ {

				field : 'hz_id',

				title : 'hz_id',

				checkbox : true,

				width : 50

			}, {

				field : 'hz_keshi',

				title : '科室',

				align : 'right',

				width : 150

			},  {

				field : 'hz_baogaoren',

				title : '报告人',

				align : 'right',

				width : 150

			},{

				field : 'hz_name',

				title : '患者姓名',

				align : 'right',

				width : 150

			},{

				field : 'hz_sex',

				title : '性别',

				align : 'right',
				
				formatter:function (rowIndex, rowData){
			        if(1==rowData.hz_sex){
			        	return '女';
			        }else{
			        	return '男';
			        }
			    },
				width : 150

			}, {

				field : 'hz_chushengtime',

				title : '出生日期',

				width : 300

			} ] ],

			toolbar : [ {

				text : '添加',

				iconCls : 'icon-add',

				handler : function() {

					addeffect();

				}

			}, {

				text : '编辑',

				iconCls : 'icon-edit',

				handler : function() {

					editDatalibbiaobenlx();

				}

			}, {

				text : '删除',

				iconCls : 'icon-remove',

				handler : function() {

					delDatalibbiaobenlx();

				}

			}, '-', {

				iconCls : 'Checkerror',

				text : '取消选择',

				handler : function() {

					$('#effect_index_treegrid').datagrid('unselectAll');

				}

			}, {

				iconCls : 'icon-reload',

				text : '刷新',

				handler : function() {

					$('#effect_index_treegrid').datagrid('reload');

				}

			}, '-', {

				iconCls : 'Bulletarrowup',

				text : '折叠所有',

				handler : function() {

					$('#effect_index_treegrid').datagrid('collapseAll');

				}

			} ],

			onDblClickRow : function(row) {

				if (row.state == 'closed') {

					//$('#effect_index_treegrid').datagrid('expand', [ row.id ]);

				} else {

					//$('#effect_index_treegrid').datagrid('collapse', [ row.id ]);

				}

			}
			
			

		});

	});
	
	
	$('#effect_index_treegrid').datagrid('doCellTip',   
			{   
				onlyShowInterrupt:false,   //false全都有tips，true，被遮挡的才会有tips
				position:'bottom',
				maxWidth:'200px',
                specialShowFields:[{field:'status',showField:'statusDesc'}],
				tipStyler:{'backgroundColor':'#fff000', borderColor:'#ff0000', boxShadow:'1px 1px 3px #292929'}
			}); 

	//add

	function addeffect() {

		var row = $('#effect_index_treegrid').datagrid('getSelections');

		if (row.length <= 1) {

			var pid = row.length == 0 ? 0 : row[0].biaobenlx_id;
			
			//弹出添加dialog对话框

			var addDatalibDialog = $('<div/>').dialog({

				href : '<?php echo U(GROUP_NAME.'/Effect/effectadd');?>',

				title : '添加药物不良反应',

				width : 1400,

				height : 800,

				modal : true,

				buttons : [ {

					iconCls : 'Bullettick',

					text : '添加',

					handler : function() {
						if($('#biaobenlx_name').val()==''){
							msgBox('失败', '性别不能为空，遇缓存时，请刷新页面重试。');
						}else{
							//作添加动作
							
							$.post("<?php echo U(GROUP_NAME.'/Effect/effectadd',array('doit'=>'do'));?>", $('#effect_addForm').serialize(), function(data) {
	
								if (data.status) {
	
									addDatalibDialog.dialog('destroy');
	
									$('#effect_index_treegrid').datagrid('reload');
	
									$('#effect_index_treegrid').datagrid('unselectAll');
	
									msgBox(data.data, data.data);
	
								} else {
	
									msgBox(data.data, data.data);
	
								}
	
							}, "json");
						}
					}

				}, {

					iconCls : 'Bulletleft',

					text : '重置',

					handler : function() {

						addDatalibDialog.dialog('refresh');

					}

				} ]

			});
			addDatalibDialog.dialog({
			    onClose:function(){
			    	addDatalibDialog.dialog('destroy');
			    }
			});

		} else {

			$.messager.alert('提示', '需要添加顶级栏目请不要选择行,向已有的栏目添加只需要选择对应的栏目且每次只能选择一行来做添加数据字典操作.');

		}

	}

	//del

	function delDatalibbiaobenlx() {

		var row = $('#effect_index_treegrid').datagrid('getSelections');

		if (row.length == 0) {

			$.messager.alert('提示', '您还没有选定要删除的行!');

		} else {

			$.messager.confirm('警告', '你确实要彻底删除此项吗?<br>删除之后会可能影响到其它模块的正常显示!', function(r) {

				if (r) {

					$.post("<?php echo U(GROUP_NAME.'/Datalib/delDatalib',array('action'=>ACTION_NAME));?>", {

						id : row[0]['biaobenlx_id']

					}, function(data) {

						if (data.status) {

							$('#effect_index_treegrid').datagrid('reload');

							$('#effect_index_treegrid').datagrid('unselectAll');

							msgBox('成功', data.info);

						} else {

							msgBox('失败', data.info);

						}

					}, "json");

				}

			});

		}

	}

	//edit

	function editDatalibbiaobenlx() {

		var row = $('#effect_index_treegrid').datagrid('getSelections');

		if (row.length == 0) {

			$.messager.alert('提示', '您还没有选定要编辑的行!');

		} else {

			//弹出添加dialog对话框

			var editDatalibDialog = $('<div/>').dialog({

				href : '<?php echo U(GROUP_NAME.'/Datalib/editdatalib',array('action'=>ACTION_NAME));?>/id/' + row[0]['biaobenlx_id'],

				title : '编辑数据字典',

				width : 600,

				height : 220,

				modal : true,

				buttons : [ {

					iconCls : 'Bullettick',

					text : '编辑',

					handler : function() {

						//作编辑动作

						$.post("<?php echo U(GROUP_NAME.'/Datalib/editDatalibSubmit',array('action'=>ACTION_NAME));?>", $('#datalib_addDatalib_addFormbiaobenlx').serialize(), function(data) {

							if (data.status) {

								editDatalibDialog.dialog('destroy');

								$('#effect_index_treegrid').datagrid('reload');

								$('#effect_index_treegrid').datagrid('unselectAll');

								msgBox('成功', data.info);

							} else {
								
								msgBox('失败', data.info);

							}

						}, "json");

					}

				}, {

					iconCls : 'Bulletleft',

					text : '重置',

					handler : function() {

						editDatalibDialog.dialog('refresh');

					}

				} ]

			});
			editDatalibDialog.dialog({
			    onClose:function(){
			    editDatalibDialog.dialog('destroy');
			    }
			});

		}

	}

</script>

<table id="effect_index_treegrid"></table>