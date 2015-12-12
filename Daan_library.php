<?php
/*=========================
本程式已完成「單一程式」
擷取圖書館座位的主程式
手機端能用webview處理此網頁嗎？
==========================*/
	include"phpQuery-onefile.php";//引入phpQuery的code
	$ch_library=curl_init();//curl宣告
	curl_setopt($ch_library, CURLOPT_URL,"http://libregist.taivs.tp.edu.tw/currstat");//網頁來源宣告
	curl_setopt($ch_library, CURLOPT_HEADER, false);//頁面標籤顯示
	curl_setopt($ch_library, CURLOPT_RETURNTRANSFER, true);//顯示頭信息？
	$web_library_data=curl_exec($ch_library);//取網頁原始碼
	$library_doc=phpQuery::newDocumentHTML($web_library_data);//將抓來的資料丟到phpQuery的code
	$web_library_head=pq('head')->html();//抓取css和node.js
	echo $web_library_head;//輸出css和node.js
	$web_library_seat=pq('div[class="entry"]',$library_doc)->html();//抓座位
	echo $web_library_seat;//輸出座位
	$web_library_tool=pq('div[id="ui-tooltip-*"]')->html();//引入座位相關訊息
	echo $web_library_tool;//輸出座位相關訊息
?>
