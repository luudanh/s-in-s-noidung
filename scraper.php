<?php
require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';

scraperwiki::save_var('last_id', 1);
$api="https://api.morph.io/luudanh/s-in-s/data.json?key=g7c0INT8tWZAeziAaS3U&query=select%20*%20from%20%27data%27%20limit%200,10"
$json = scraperwiki::scrape($api);
var_dump(json_decode($json));
exit();
$id= scraperwiki::get_var('last_id');
for($i=$id;$i<1900;$i++){
 $src = scraperwiki::select("* from src.data limit $i,1");
 $url = $src[0]['link'];
$url = 'http://sexinsex.net/bbs/'.$url;
 $html_content = scraperwiki::scrape($url);
$html = str_get_html($html_content);
$data = array();
$tr =  $html->find("div.postmessage div.t_msgfont");
$j = 0;
foreach($tr as $trr){
$noidung = $trr->find('div',0)->innertext;
//$noidung = utf8_encode($noidung);
if(mb_strlen($noidung) >1000){
    $j++;
  @scraperwiki::save_sqlite(array('id'),array('id'=> $j.'-'.$src[0]['url'], 'title'=>$src[0]['title'],'url'=> $src[0]['url'],'content'=>base64_encode($noidung),'order'=> $j,'num'=>$src[0]['num'],'reply'=>$src[0]['reply']));
}
   
}
$html->clear();
unset($html);
scraperwiki::save_var('last_id', $i);
}
?>
