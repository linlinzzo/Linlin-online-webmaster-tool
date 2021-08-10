<?php
/*云体检通用漏洞防护补丁v1.1
更新时间：2013-05-25
功能说明：防护XSS,SQL,代码执行，文件包含等多种高危漏洞
*/
$url_arr=array(
'xss'=>"\\=\\+\\/v(?:8|9|\\+|\\/)|\\%0acontent\\-(?:id|location|type|transfer\\-encoding)",
);
$args_arr=array(
'xss'=>"[\\'\\\"\\;\\*\\<\\>].*\\bon[a-zA-Z]{3,15}[\\s\\r\\n\\v\\f]*\\=|\\b(?:expression)\\(|\\<script[\\s\\\\\\/]|\\<\\!\\[cdata\\[|\\b(?:eval|alert|prompt|msgbox)\\s*\\(|url\\((?:\\#|data|javascript)",
'sql'=>"[^\\{\\s]{1}(\\s|\\b)+(?:select\\b|update\\b|insert(?:(\\/\\*.*?\\*\\/)|(\\s)|(\\+))+into\\b).+?(?:from\\b|set\\b)|[^\\{\\s]{1}(\\s|\\b)+(?:create|delete|drop|truncate|rename|desc)(?:(\\/\\*.*?\\*\\/)|(\\s)|(\\+))+(?:table\\b|from\\b|database\\b)|into(?:(\\/\\*.*?\\*\\/)|\\s|\\+)+(?:dump|out)file\\b|\\bsleep\\([\\s]*[\\d]+[\\s]*\\)|benchmark\\(([^\\,]*)\\,([^\\,]*)\\)|(?:declare|set|select)\\b.*@|union\\b.*(?:select|all)\\b|(?:select|update|insert|create|delete|drop|grant|truncate|rename|exec|desc|from|table|database|set|where)\\b.*(charset|ascii|bin|char|uncompress|concat|concat_ws|conv|export_set|hex|instr|left|load_file|locate|mid|sub|substring|oct|reverse|right|unhex)\\(|(?:master\\.\\.sysdatabases|msysaccessobjects|msysqueries|sysmodules|mysql\\.db|sys\\.database_name|information_schema\\.|sysobjects|sp_makewebtask|xp_cmdshell|sp_oamethod|sp_addextendedproc|sp_oacreate|xp_regread|sys\\.dbms_export_extension)",
'other'=>"\\.\\.[\\\\\\/].*\\%00([^0-9a-fA-F]|$)|%00[\\'\\\"\\.]");
$referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);
$query_string=empty($_SERVER["QUERY_STRING"]) ? array() : array($_SERVER["QUERY_STRING"]);
check_data($query_string,$url_arr);
check_data($_GET,$args_arr);
check_data($_POST,$args_arr);
check_data($_COOKIE,$args_arr);
check_data($referer,$args_arr);
function W_log($log)
{
  $logpath=$_SERVER["DOCUMENT_ROOT"]."/log.txt";
  $log_f=fopen($logpath,"a+");
  fputs($log_f,$log."\r\n");
  fclose($log_f);
}
function check_data($arr,$v) {
 foreach($arr as $key=>$value)
 {
  if(!is_array($key))
  { check($key,$v);}
  else
  { check_data($key,$v);}
  if(!is_array($value))
  { check($value,$v);}
  else
  { check_data($value,$v);}
 }
}
function check($str,$v)
{
  foreach($v as $key=>$value)
  {
  if (preg_match("/".$value."/is",$str)==1||preg_match("/".$value."/is",urlencode($str))==1)
    {
      //W_log("<br>IP: ".$_SERVER["REMOTE_ADDR"]."<br>时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交数据: ".$str);
      print "您的提交带有不合法参数,谢谢合作";
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>林林站长工具</title><meta name="description" content="林林站长工具让在线给百度提交链接、给必应提交网站地图、给神马搜索提交MIP页面链接提供了可能。" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>搜索引擎提交工具</h1>
<b>在这里你可以向百度提交链接、向神马提交MIP页面链接以及向必应提交站点地图。只需按照要求填写信息即可。</b><p>这里你可以提交你的网站的链接给百度，只要按要求填写信息即可。</p><p>提交状态:<?php
if (isset($_POST["address"])) {
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%
=~_|]/i",$_POST["address"])) {
  echo "无效的调用地址(非网址)"; 
} else{
if(strpos($_POST["address"],'http://data.zz.baidu.com/urls?site=') !== false){
$urls = explode(" ",$_POST["link"]);
$api = $_POST["address"];
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
echo $result;
}else{
echo "无效的调用地址(百度域名验证失败)";
}
}
} 
if (isset($_POST["advice"])) {
$myfile = fopen("aaasuggest.txt", "a");
$txt = $_POST["advice"]."\n";
fwrite($myfile, $txt);
echo "添加建议成功";
}
if (isset($_POST["mipadd"])) {
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%
=~_|]/i",$_POST["mipadd"])) {
  echo "无效的调用地址(非网址)"; 
} else{
if(strpos($_POST["mipadd"],'https://data.zhanzhang.sm.cn/push?site=') !== false){
$urls = $var=explode(" ",$_POST["miplink"]);
$api = $_POST["mipadd"];
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
echo $result;
}else{
echo "非神马搜索域名";
}
}
}
if (isset($_POST['sitemap'])) {
$ping = 'https://www.bing.com/webmaster/ping.aspx?sitemap='.$_POST['sitemap'];  //  url和参数
$sitemap = file_get_contents($ping);
echo "Success!";
}
?>
</p>
<h2>提交链接给百度</h2>
<form method="post" action="https://www.linlinzzo.top/webmaster.php">
<p>在这里输入你要推送给百度搜索引擎的链接，注意要带https或http，多个链接请换行</p>
<textarea name="link" style="width:350px;height:300px"></textarea>
<p>这里输入百度站长平台上显示的调用接口地址</p>
<input type="url" name="address" style="width:200px;height:30px" required>
<input type="submit" style="width:50px;height:30px" value="提交">
</form>
</br></br></br></br>
<h2>提交站点地图给必应</h2>
<p>此处可以按照必应的提交接口进行网站地图的提交。请填写网站地图的网址。</p>
<form method="post" action="https://www.linlinzzo.top/webmaster.php">
在此处填写您要提交给必应的网站地图:
<input type="url" name="sitemap" style="width:200px;height:30px" required>
<input type="submit" value="提交" style="width:50px;height:30px"></form>
<form method="post" action="https://www.linlinzzo.top/webmaster.php">
</br></br></br></br>
<h2>给我们提交建议</h2>在此处填写您要给我们提的建议
<textarea name="advice" style="width:350px;height:200px"></textarea><input type="submit" value="提交" style="width:50px;height:30px">
</form>
</br></br></br></br>
<h2>提交MIP页面给神马</h2>
<form method="post" action="https://www.linlinzzo.top/webmaster.php">
<p>在这里输入你要推送给神马搜索的MIP页面链接，注意要带https或http，多个链接请换行</p>
<textarea name="miplink" style="width:350px;height:300px"></textarea>
<p>这里输入神马搜索站长平台的调用接口地址</p>
<input type="url" name="mipadd" style="width:200px;height:30px">
<input type="submit" style="width:50px;height:30px" value="提交">
</form>
</body></html>
