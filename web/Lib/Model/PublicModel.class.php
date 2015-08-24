<?php
/**
 * 
 * 系统设置权限的读取显示和修改
 * @author zhangkaifeng
 * time  2013-7-9 10:54
 *
 */
class PublicModel extends Model{
	// $string： 明文 或 密文
	// $operation：DECODE表示解密,其它表示加密
	// $key： 密匙
	// $expiry：密文有效期
	public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
		$ckey_length = 4;
		// 密匙
		$key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
		// 密匙a会参与加解密
		$keya = md5(substr($key, 0, 16));
		// 密匙b会用来做数据完整性验证
		$keyb = md5(substr($key, 16, 16));
		// 密匙c用于变化生成的密文
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
		// 参与运算的密匙
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
		// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
		$result = '';
		$box = range(0, 255);
		$rndkey = array();
		// 产生密匙簿
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
		// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		// 核心加解密部分
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			// 从密匙簿得出密匙进行异或，再转成字符
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if($operation == 'DECODE') {
			// substr($result, 0, 10) == 0 验证数据有效性
			// substr($result, 0, 10) - time() > 0 验证数据有效性
			// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
			// 验证数据有效性，请看未加密明文的格式
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
			// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
	
	
	/**
	 * 系统邮件发送函数
	 * @param string $to    接收邮件者邮箱
	 * @param string $name  接收邮件者名称
	 * @param string $subject 邮件主题
	 * @param string $body    邮件内容
	 * @param string $attachment 附件列表
	 * @return boolean
	 */
	function think_send_mail($to, $name,$url, $subject = '', $body = '', $attachment = null){
		require APP_PATH.'Lib/ORG/PHPMailer/class.phpmailer.php';//导class.phpmailer.php类文件
		//$config = C('THINK_EMAIL');
		$mail  = new PHPMailer();
		//dump($config);
		$mail->CharSet    ="UTF-8";                 //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
		$mail->IsSMTP();                            // 设定使用SMTP服务
		$mail->SMTPAuth   = true;                   // 启用 SMTP 验证功能
		$mail->SMTPSecure = "SSL";                  // SMTP 安全协议,必须要大写，囧
		$mail->Host       = 'smtp.qq.com';   		// SMTP 服务器
		$mail->Port       = 25;   					// SMTP服务器的端口号
		$mail->Username   = '2698117097@qq.com';  	// SMTP服务器用户名2698117097
		$mail->Password   = 'fb2739606';        // SMTP服务器密码fb2739606
		$mail->SetFrom('2698117097@qq.com', C('FROM_NAME'));// 设置发件人地址和名称
		$mail->AddReplyTo(C('FROM_NAME'),"邮件回复人名称");// 设置邮件回复人地址和名称
		$mail->Subject    = C('EMAIL_TITLE');                     // 设置邮件标题
		$mail->AltBody    = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
		// 可选项，向下兼容考虑
		$mail->MsgHTML(C('WORD_CONTENT').$url);                         // 设置邮件内容
		$mail->AddAddress($to, $name);
		if(!$mail->Send()) {
			return false;
		} else {
			return  true;
		}
		
		
		
		/*
		require APP_PATH.'Lib/ORG/PHPMailer/class.phpmailer.php';//导class.phpmailer.php类文件
		$mail             = new PHPMailer(); //PHPMailer对象
		$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
		$mail->IsSMTP();  // 设定使用SMTP服务
		$mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
		// 1 = errors and messages
		// 2 = messages only
		//dump($config);
		$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
		$mail->SMTPSecure = 'ssl';                 // 使用安全协议
		$this->Mailer = 'SMTP';
		$mail->Host       = 'smtp.qq.com';//$config['SMTP_HOST'];  // SMTP 服务器
		$mail->Port       = '25';//$config['SMTP_PORT'];  // SMTP服务器的端口号
		$mail->Username   = '362301556@qq.com';//$config['SMTP_USER'];  // SMTP服务器用户名
		$mail->Password   = 'kaifeng262311';//$config['SMTP_PASS'];  // SMTP服务器密码
		$mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
		$replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
		$replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
		$mail->AddReplyTo($replyEmail, $replyName);
		$mail->Subject    = $subject;
		$mail->MsgHTML($body);
		$mail->AddAddress($to, $name);
		if(is_array($attachment)){ // 添加附件
			foreach ($attachment as $file){
				is_file($file) && $mail->AddAttachment($file);
			}
		}
		return $mail->Send() ? true : $mail->ErrorInfo;*/

	}
	
	
	
	public function sendmail($sendto_email, $user_name, $subject, $bodyurl)
	{
		require APP_PATH.'Lib/ORG/PHPMailer/class.phpmailer.php';//导class.phpmailer.php类文件
		$mail = new PHPMailer();
		$mail->IsSMTP();                  // send via SMTP
		 
		$mail->Host = "smtp.qq.com";   // SMTP servers
		$mail->SMTPAuth = true;           // turn on SMTP authentication
		$mail->Username = "mail@qq.com";     // SMTP username  注意：普通邮件认证不需要加 @域名
		$mail->Password = "kaifeng262311"; // SMTP password
		$mail->From = "362301556@qq.com";      // 发件人邮箱
		$mail->FromName = "管理员";  // 发件人
	
		$mail->CharSet = "utf-8";   // 这里指定字符集！
		$mail->Encoding = "base64";
		$mail->AddAddress($sendto_email, $user_name);  // 收件人邮箱和姓名
		$mail->SetFrom('axx@xxx.com', 'XXXXXXX有限公司');
	
		$mail->AddReplyTo("axx@xxx.com", 'xxxxxxxx有限公司');
		//$mail->WordWrap = 50; // set word wrap 换行字数
		//$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment 附件
		//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");
		$mail->IsHTML(true);  // send as HTML
		// 邮件主题
		$mail->Subject = $subject;
		// 邮件内容
		$mail->Body = '<html><head>
		<meta http-equiv="Content-Language" content="zh-cn"/>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		</head>
		<body>
		<div style="width:60%;padding:30px 20px;background:#F9F9F9;">
		<span style="font-weight:bold;font-size:16px;">Hi,' . $user_name . '</span><br/>
		欢迎您注册<b>XXX公司网站</b><br/>
		请点击下面的连接完成注册(有效期一小时):<br/>
		' . $bodyurl . '<br/>
		<font style="color:#999;">如果以上链接无法点击,请将上面的地址复制到你的浏览器(如IE)的地址栏完成激活</font><br/>
		http://www.XXX.com
		</div>
		</body>
	
		</html>
		';
		$mail->AltBody = "text/html";
	
		if (!$mail->Send())
		{
			$mail->ClearAddresses();
			echo "邮件错误信息: " . $mail->ErrorInfo;
			exit;
		}
		else
		{
			$mail->ClearAddresses();
			// $this->assign('waitSecond', 6);
			//            $this->success("注册成功,系统已经向您的邮箱：{$sendto_email}发送了一封激活邮件!请您尽快激活~~<br />");
			$this->redirect('sendhtml', array('send' => 5,'email'=>$sendto_email));
		}
	}
	
	
	
	
	
	function Get_host($host){  //解析域名
		$Get_host=gethostbyname($host);
		echo "尝试连接 $host ...<br>\r\n ";
		if(!$Get_host){
			$str= "解析失败 (1)<HR>";
	}elseif($Get_host==$host){
	$str= "解析失败 (2)： 可能是一个无效的主机名<HR>";
	}else{
	echo "域名解析为 $Get_host ...<br>\r\n";
	$this->Open_host($host);
	}
	echo $str;
	}
	
	
	
Function Open_host($host){  //连接主机

if(function_exists('fsockopen')){
$fp = fsockopen($host,25,&$errno,&$errstr,60);}
  elseif(function_exists('pfsockopen')){
    echo "服务器不支持Fsockopen，尝试pFsockopen函数 ...<br>\r\n";
    $fp = pfsockopen($host,25,&$errno,&$errstr,60); }
  else
    exit('服务器不支持Fsockopen函数');

if(!$fp){
echo "代号：$errno,<br>\n错误原因：$errstr<HR>";
}else{
echo "SMTP服务器连接ok!<br>\r\n";
fwrite($fp, "");
$out0= fgets($fp, 128);
#echo $out0;
if (strncmp($out0,"220",3)==0){ // 判断三位字符内容
echo '220 SMTP服务端响应正常<HR>';
}else{
echo '服务器端错误<HR>';}
}
}
//SMTP服务器地址


//调运脚本
#$host="smtp.163.com";
#echo Get_host($host);




	
	
	
	
	
	
	
	
}