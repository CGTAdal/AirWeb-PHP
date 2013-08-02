<?php
/*
 * Created on 2006/11/21
*
* To change the template for this generated file go to
* Window - Preferences - PHPeclipse - PHP - Code Templates
*/
//$str1 = '2006-11-22T02:18:07Z';
$str1 = '2006-11-22T02:18:07Z';
$str2 = '1999-1-3';
echo  strtotime($str1)."<br>\n";;
echo date('Y-m-d H:i:s', strtotime($str1))."<br>\n";
echo strtotime($str2)."<br>\n";
echo date('Y-m-d H:i:s', strtotime($str2))."<br>\n";
?>
