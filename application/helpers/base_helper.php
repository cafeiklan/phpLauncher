<?php
/***
 * strlen_UTF8($str)
 * @param str 字符串
 * 计算UTF8字符串长度
 * 将汉字计算为1单位长度，英文一个字母1单位长度
 */
if ( ! function_exists('strlen_UTF8'))
{
	function strlen_UTF8($str)
	{
		$len = strlen($str);
		$n = 0;
		for($i = 0; $i < $len; $i++) {
			$x = substr($str, $i, 1);
			$a  = base_convert(ord($x), 10, 2);
			$a = substr('00000000'.$a, -8);
			if (substr($a, 0, 1) == 0) {
			}elseif (substr($a, 0, 3) == 110) {
				$i += 1;
			}elseif (substr($a, 0, 4) == 1110) {
				$i += 2;
			}
			$n++;
		}
		return $n;
	} // End strlen_UTF8;
}

/***
 * subString_UTF8($str, $start, $lenth)
 * @param str 字符串
 * @param start 起始字符位置
 * @param length 截取长度
 * 无乱码截断中文UTF8字符串
 * 将汉字计算为1单位长度，英文一个字母1单位长度，所以截断时需要注意长度设置。
 */
if ( ! function_exists('subString_UTF8'))
{
	function subString_UTF8($str, $start, $lenth)
	{
		$len = strlen($str);
		$r = array();
		$n = 0;
		$m = 0;
		for($i = 0; $i < $len; $i++) {
			$x = substr($str, $i, 1);
			$a  = base_convert(ord($x), 10, 2);
			$a = substr('00000000'.$a, -8);
			if ($n < $start){
				if (substr($a, 0, 1) == 0) {
				}elseif (substr($a, 0, 3) == 110) {
					$i += 1;
				}elseif (substr($a, 0, 4) == 1110) {
					$i += 2;
				}
				$n++;
			}else{
				if (substr($a, 0, 1) == 0) {
					$r[ ] = substr($str, $i, 1);
				}elseif (substr($a, 0, 3) == 110) {
					$r[ ] = substr($str, $i, 2);
					$i += 1;
				}elseif (substr($a, 0, 4) == 1110) {
					$r[ ] = substr($str, $i, 3);
					$i += 2;
				}else{
					$r[ ] = '';
				}
				if (++$m >= $lenth){
					break;
				}
			}
		}
		return join($r);
	} // End subString_UTF8;
}

/**
 * utf-8 字符串截取函数 edit by zwwooooo
 * $sourcestr：要截取的字符串，默认空
 * $i：开始截取地方，默认0
 * $cutlength：截取长度（文字个数），默认100
 * $endstr：截取后的字符串末尾字符串，默认是 “….”
 * UTF-8编码的字符可能由1~3个字节组成， 具体数目可以由第一个字节判断出来。(理论上可能更长，但这里假设不超过3个字节)
 * 第一个字节大于224的，它与它之后的2个字节一起组成一个UTF-8字符
 * 第一个字节大于192小于224的，它与它之后的1个字节组成一个UTF-8字符
 * 否则第一个字节本身就是一个英文字符（包括数字和一小部分标点符号）。
 */
if ( ! function_exists('mySubstr'))
{
	function mySubstr($sourcestr='',$cutlength=100,$i=0,$endstr='…'){
		$str_length=strlen($sourcestr);//字符串的字节数
		$returnstr='';		
		$i=0;		
		$n=0;
		while (($n<$cutlength) and ($i<=$str_length))
		{
			$temp_str=substr($sourcestr,$i,1);
			$ascnum=Ord($temp_str);//ascii码
			if ($ascnum>=224)
			{
				$returnstr=$returnstr.substr($sourcestr,$i,3);
				$i=$i+3;
				$n++;
			}elseif ($ascnum>=192)
			{
				$returnstr=$returnstr.substr($sourcestr,$i,2);
				$i=$i+2;
				$n++;
			}else
			{
				$returnstr=$returnstr.substr($sourcestr,$i,1);
				$i=$i+1;
				$n=$n+0.5;
			}
		}
		if($i<$str_length)$returnstr.=$endstr;
		return $returnstr;
	}
}

/***
 * get_client_ip
 * 获得用户客户端真实IP地址，考虑了IP的欺骗,和多重代理的情况
 */

if ( ! function_exists('get_client_ip'))
{
	function get_client_ip() {
		$unknown = 'unknown';
		if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		/*
		 处理多层代理的情况
		或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
		*/
		if (false !== strpos($ip, ','))
			$ip = reset(explode(',', $ip));
		return $ip;
	}
}
?>
