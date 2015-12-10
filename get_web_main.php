<?php
/*=========================
本程式未完成
相對路徑問題需先解決（line16～line24即可刪除）
==========================*/
	$ch=curl_init();//curl宣告
	curl_setopt($ch, CURLOPT_URL,"http://ta.taivs.tp.edu.tw/news/news.asp?KEY=30819");//網頁來源宣告
	curl_setopt($ch, CURLOPT_HEADER, false);//頁面標籤顯示
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//顯示頭信息？
	$web_data=curl_exec($ch);//取網頁原始碼
	include"phpQuery-onefile.php";//引入phpQuery的code
	$doc=phpQuery::newDocumentHTML($web_data);//將抓來的資料丟到phpQuery的code
	$list000 = pq('table[width="100%"]&&[align="center"]')->parent()->parent()->html();//找到我們所需要的區域（公告內文）
	$list001=iconv("big5","UTF-8",$list000);//更改編碼
	print_r($list001);//輸出測試01
	$list002 = pq('p[align="center"]')->html();//抓取圖片<p></p>
		if ($list002 !="") {//如果有資料
			$list001 = pq('p[align="center"]')->html();//抓圖的html的code
			$Address_frist=strpos($list001,"KEY=",0);//抓字首
			$Address_end=strpos($list001,"jpg",0);//抓字尾
			$Address_long=$Address_end-$Address_frist;//抓字首和字尾的差
			$output=substr($list001,$Address_frist+10,$Address_long-7);//計算
			echo "http://ta.taivs.tp.edu.tw/news/$output"."<br>";//輸出測試02
		}
	curl_close($ch);//結束php_curl
?>
