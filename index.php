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
</body>
</html>
