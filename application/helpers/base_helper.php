<?php
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
?>
