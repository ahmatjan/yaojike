<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" charset="utf-8"  src="__PUBLIC__/ueditor1_4_3-utf8/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8"  src="__PUBLIC__/ueditor1_4_3-utf8/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor1_4_3-utf8/lang/zh-cn/zh-cn.js"></script>

<style type="text/css">
input.error { border: 1px solid red; }
label.checked {
  background:url("./demo/images/checked.gif") no-repeat 0px 0px;
}

label {

	float: left;
	
	text-align: right;

	padding: 2px;

	margin: 1px;

}

.row {

	margin-top: 10px;

}

</style>

<script typescripttype="text/javascript">  
window.UEDITOR_HOME_URL = '__PUBLIC__/ueditor1_4_3-utf8/'; //一定要用这句话，否则你需要去ueditor.config.js修改路径的配置信息  
var ue=UE.getEditor('md_jingshi');
 </script>  
<form id="effect_addForm" method="post">

	<div style="clear: both; overflow: hidden; padding: 10px;">
		
		<div style="float: left; width: 270px; margin-right: 20px;">
			<div class="row">
				<label for="keshi">药名：</label><input id="md_name" name="md_name" placeholder="药名" value="<?php echo ($data["md_name"]); ?>" class="input-xlarge"  type="text">
			</div>
		</div>
		
	</div>



<hr color="#D4D4D4">

	<div style="clear: both; overflow: hidden; padding: 2px;">
		
		<div style="float: left; width: 200px; margin-right: 2px;">
			<div class="row">
				<label for="hz_name">特别警示：</label>
				<script id="md_jingshi" type="text/plain" style="width:1024px;height:500px;"></script> 
			</div>
		</div>
		
	</div>
	
	<hr color="#D4D4D4">



	

</form>