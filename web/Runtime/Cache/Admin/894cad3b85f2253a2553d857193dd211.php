<?php if (!defined('THINK_PATH')) exit();?>
<script type="text/javascript" charset="utf-8">
var medicinedatagrid;
var editIndex = undefined;

	$(function() {
		
		
		var editRow=undefined;
		
		medicinedatagrid=$('#medicine_index_treegrid').datagrid({
			
			url : "<?php echo U(GROUP_NAME.'/Medicine/index',array('getdatajson'=>'do'));?>",

			animate : false,

			fit : true,

			border : false,

			singleSelect : true,

			rownumbers : true,
			
			pagination : true,

			pageSize : 15,

			pageList : [ 15, 30, 45, 60 ],

			idField : 'md_id',

			treeField : 'md_id',

			columns : [ [ {

				field : 'md_id',

				title : 'md_id',

				checkbox : true,

				width : 50

			},{

				field : 'md_name',

				title : '药名',

				align : 'right',

				width : 150,
				editor: {
					type: 'text',/*combobox是下拉列表*/
					options: {
						validType:'minLength[1,50]',
						required: true
					}
				}

			},{

				field : 'md_sort',

				title : '排序',
				
				align : 'right',
				
				width : 50,
				
				editor: {
					type: 'numberbox',/*combobox是下拉列表*/
					options: {
						validType:'minLength[1,5]',
						required: true
					}
				}

			} ] ],

			queryParams: { action: 'query' }, /*查询参数*/
			
			toolbar : [ /*{

				text : '手动添加',

				iconCls : 'icon-add',

				handler : function() {

					addmedicine();

				}

			},*/{

				text : '导入word',

				iconCls : 'icon-add',

				handler : function() {

					addmedicineword();

				}

			}, {

				text : '编辑',

				iconCls : 'icon-edit',

				handler : function() {

					editmedicine();

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

					$('#medicine_index_treegrid').datagrid('unselectAll');

				}

			}, {

				iconCls : 'icon-reload',

				text : '刷新',

				handler : function() {

					$('#medicine_index_treegrid').datagrid('reload');

				}

			}/*, '-', {

				iconCls : 'Bulletarrowup',

				text : '折叠所有',

				handler : function() {
					
					$('#medicine_index_treegrid').datagrid('collapseAll');

				}

			},{

				iconCls : 'icon-save',

				plain:true,
				
				text : '应用修改',

				handler : function() {

					//saveRow();
					//$('#medicine_index_treegrid').datagrid('collapseAll');

				}

			} ,{
				text: '取消编辑',
				iconCls: 'icon-redo',
				handler: function () {
	                //取消当前编辑行把当前编辑行罢undefined回滚改变的数据,取消选择的行
	                editRow = undefined;
	                medicinedatagrid.datagrid("rejectChanges");
	                medicinedatagrid.datagrid("unselectAll");
            	}
            }*/],
            
            /*onBeforeSave : function (rowIndex, rowData){
            	alert(rowData['md_name'])
            },*/
			onAfterEdit: function (rowIndex, rowData, changes) {
                $.post("<?php echo U('Medicine/editmedicine',array('sort'=>'yes'));?>", {md_id : rowData['md_id'],md_sort:rowData['md_sort'],md_name:rowData['md_name']}, function(data) {
					if (data.status) {
						$('#medicine_index_treegrid').datagrid('reload');
						$('#medicine_index_treegrid').datagrid('unselectAll');
						msgBox('成功', data.info);
					} else {
						msgBox('失败', data.info);
					}
				}, "json");
                console.info(rowData);
                editRow = undefined;
            },
            saveRow : function(index){
            	medicinedatagrid.datagrid('endEdit', index);
            },
            onDblClickCell : function (rowIndex, rowData) {
            //双击开启编辑行
                if (editRow != undefined) {
                	medicinedatagrid.datagrid("endEdit", editRow);
                }
                if (editRow == undefined) {
                	medicinedatagrid.datagrid("beginEdit", rowIndex);
                    editRow = rowIndex;
                }
            },
            onClickRow : function(rowIndex, rowData) {

            	var medicineDialog = $('<div/>').dialog({
					href : "<?php echo U(GROUP_NAME.'/Medicine/get_medicine_content');?>?id="+rowData.md_id,
					title : '药品查看修改',
					modal : true,
					width : 750,
					height : 600,
					onClose : function() {
						medicineDialog.dialog('destroy');
					},
					buttons : [ {
						text : '保存',
						handler : function() {
							$.post("__URL__/changeArticleSubmit/", {
								title : $('#title').val(),
								source : $('#source').val(),
								id : $('#id').val(),
								content : $(window.frames[0].frames[0].document.body).html()
							}, function(data) {
								if (data.status) {
									medicineDialog.dialog('destroy');
									$('#article-article-tree').datagrid('reload');
									msgBox('成功', data.info);
								} else {
									msgBox('失败', data.info);
								}
							}, "json");
						}
					}, {
						text : '取消',
						handler : function() {
							medicineDialog.dialog('destroy');
						}
					} ]
				});

			}
		});
	});
    
	
	$('#medicine_index_treegrid').datagrid('doCellTip',{   
		onlyShowInterrupt:false,   //false全都有tips，true，被遮挡的才会有tips
		position:'bottom',
		maxWidth:'200px',
	             specialShowFields:[{field:'status',showField:'statusDesc'}],
		tipStyler:{'backgroundColor':'#fff000', borderColor:'#ff0000', boxShadow:'1px 1px 3px #292929'}
	}); 

	//add

	/**
	导入word
	*/
	function addmedicineword(){
		var addmedicinewordDialog = $('<div/>').dialog({

			href : '<?php echo U(GROUP_NAME.'/Medicine/medicineaddword');?>',

			title : '导入药品word',

			width : 400,

			height : 200,

			modal : true,

			buttons : [ {

				iconCls : 'Bullettick',

				text : '添加',

				handler : function() {
					if($("#medicine_add_form").form('validate')){
					    $.ajaxFileUpload ({
						    url :"<?php echo U(GROUP_NAME.'/Medicine/medicineaddword');?>",
						    secureuri :false,
						    fileElementId :'yaopinword',
						    dataType : 'json',
						    success : function (data){
						    	if(data.status){
						    		msgBox(data.data, data.info);
						    		addmedicinewordDialog.dialog('destroy');
						    		$('#medicine_index_treegrid').datagrid('reload');
						    	}else{
						    		msgBox(data.data, data.info);
						    	}
						    	
						    },
						    error: function (data, status, e){
						    	alert(e);
						    }
					    })
					}else{
						msgBox('失败', '表单有未填写项。');
					}
				}

			}, {

				iconCls : 'Bulletleft',

				text : '重置',

				handler : function() {

					addmedicinewordDialog.dialog('refresh');

				}

			} ]

		});
	}
	
	/**
	手动填写
	**/
	function addmedicine() {

		var row = $('#medicine_index_treegrid').datagrid('getSelections');

		if (row.length <= 1) {

			var pid = row.length == 0 ? 0 : row[0].biaobenlx_id;
			
			//弹出添加dialog对话框

			var addDatalibDialog = $('<div/>').dialog({

				href : '<?php echo U(GROUP_NAME.'/Medicine/medicineadd');?>',

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
							
							$.post("<?php echo U(GROUP_NAME.'/Medicine/medicineadd',array('doit'=>'do'));?>", $('#medicine_addForm').serialize(), function(data) {
	
								if (data.status) {
	
									addDatalibDialog.dialog('destroy');
	
									$('#medicine_index_treegrid').datagrid('reload');
	
									$('#medicine_index_treegrid').datagrid('unselectAll');
	
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

		var row = $('#medicine_index_treegrid').datagrid('getSelections');

		if (row.length == 0) {

			$.messager.alert('提示', '您还没有选定要删除的行!');

		} else {

			$.messager.confirm('警告', '你确实要彻底删除此项吗?<br>删除之后会可能影响到其它模块的正常显示!', function(r) {

				if (r) {

					$.post("<?php echo U(GROUP_NAME.'/Datalib/delDatalib',array('action'=>ACTION_NAME));?>", {

						id : row[0]['biaobenlx_id']

					}, function(data) {

						if (data.status) {

							$('#medicine_index_treegrid').datagrid('reload');

							$('#medicine_index_treegrid').datagrid('unselectAll');

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

	function editmedicine() {

		var row = $('#medicine_index_treegrid').datagrid('getSelections');

		if (row.length == 0) {

			$.messager.alert('提示', '您还没有选定要编辑的药品!');

		} else {

			//弹出添加dialog对话框

			var editmedicineDialog = $('<div/>').dialog({

				href : '<?php echo U(GROUP_NAME.'/Medicine/editmedicine');?>?id=' + row[0]['md_id'],

				title : '编辑药品',

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

								editmedicineDialog.dialog('destroy');

								$('#medicine_index_treegrid').datagrid('reload');

								$('#medicine_index_treegrid').datagrid('unselectAll');

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

						editmedicineDialog.dialog('refresh');

					}

				} ]

			});
			editmedicineDialog.dialog({
			    onClose:function(){
			    	editmedicineDialog.dialog('destroy');
			    }
			});

		}

	}

</script>
<div id="rbac_role_layout" class="easyui-layout" data-options="fit:true">

	<div data-options="region:'west',title:'药品列表',border:false,split:true" style="width: 400px;">

		<table id="medicine_index_treegrid"></table>

	</div>

	<div data-options="region:'center',title:'药品详细',border:false">

		<table id="medicine_content"></table>

	</div>

</div>