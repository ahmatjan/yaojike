<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" charset="utf-8">
	function logout() {
		$.messager.confirm('<?php echo C(session('language').'.msg');?>', '<?php echo C(session('language').'.tuichuxunwen');?>', function(r) {
			if (r) {
				location.href = "__APP__/<?php echo GROUP_NAME;?>/Login/logout";
			}
		});
	}
</script>

<div style="height: 70px; overflow: hidden; clear: both;">
	<div style="height: 70px; width: 450px;  float: left;">药剂科</div><!-- background-image: url(../Public/img/mainBanner.jpg); -->
	<div style="height: 70px; float: right; padding-right: 10px;">
		<div style="height: 40px; line-height: 40px; font-size: 12px; text-align: right;">[<?php echo ($auth["uid"]); ?>]<?php echo ($auth["name"]); ?>(<?php echo ($auth["count"]); ?>)&nbsp;<?php echo C(session('language').'.ninhao');?> | <?php echo C(session('language').'.scip');?> <?php echo ($auth["lastIp"]); ?>|
			<?php echo C(session('language').'.scsj');?>:<?php echo ($auth["lastTime"]); ?></div>
		<div style="height: 30px; float: right;">
			<a href="javascript:void(0)" id="logout" onclick="logout()" class="easyui-menubutton" data-options="iconCls:'Doorout'"><?php echo C(session('language').'.tuichuanniu');?></a>
		</div>

	</div>
</div>