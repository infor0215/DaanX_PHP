<?php
/*=========================
本程式已完成
include的程式
==========================*/
	$ch=curl_init();//curl宣告
	curl_setopt($ch, CURLOPT_URL,"http://ta.taivs.tp.edu.tw/news/news.asp?KEY=$array_unmber[$A]");//網頁來源宣告
	curl_setopt($ch, CURLOPT_HEADER, false);//頁面標籤顯示
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//顯示頭信息？
	$web_data=curl_exec($ch);//取網頁原始碼
	$doc=phpQuery::newDocumentHTML($web_data);//將抓來的資料丟到phpQuery的code
	$do_pq=pq('table[width="100%"]&&[align="center"]',$doc);
	$web_main_top_day=$do_pq->find('td[align="center"]&&[width="13%"]&&[bgcolor="#FF0000"]')->text();//日期
	$web_main_top_title=$do_pq->find('td[align="left"]&&[width="87%"]&&[bgcolor="#FF0000"]')->text();//主題
	$web_main_data=iconv("big5","UTF-8",$do_pq->find('tr[bgcolor="#FFDDBB"]')->find('td[width="87%"]')->html());//內文
	$web_main_where=$do_pq->find('tr[bgcolor="#FCEBC7"]')->find('td[width="87%"]')->text();//資料來源
	$web_main_outside_link=$do_pq->find('tr[bgcolor="#FFFF00"]')->find('td[bgcolor="#FFFFCC"]&&[width="87%"]')->find('a')->html();//參考連結
		if($web_main_outside_link !==""){//當參考連結存在（剛好會和有效日期疊到）時
			$web_main_can_read_time_form=explode("\n"."            ", $do_pq->find('tr')->find('td[bgcolor="#FFFFCC"]&&[width="87%"]')->text());//切割收到的資料（因為後另一資料抓法會重疊到）
			$web_main_can_read_time=$web_main_can_read_time_form[1];//有效日期A情況
		}
		else{//當參考連結不存在時
			$web_main_can_read_time=$do_pq->find('tr')->find('td[bgcolor="#FFFFCC"]&&[width="87%"]')->text();//有效日期B情況
		}
	$web_main_link_sum="";//初始變數
	$web_main_link="";//初始變數
	$web_main_link_from=explode("<br>", iconv("big5","UTF-8",$do_pq->find('td[colspan=2]')->html()));//附件的原始資料（陣列）
		for ($m=0; $m <count($web_main_link_from) ; $m++) { //一陣列數來判斷要抓多少程式
			$Address_frist02=strpos($web_main_link_from[$m],"href=",0);//抓字首
			$Address_end02=strpos($web_main_link_from[$m]," target",0);//抓字尾
			$Address_long02=$Address_end02-$Address_frist02;//抓字首和字尾的差;
			$web_main_link_output=substr($web_main_link_from[$m],$Address_frist02+6,$Address_long02-7);//抓超連結文字
				if($m>1){
					$web_main_link_sum=$web_main_link_sum."http://ta.taivs.tp.edu.tw/news/$web_main_link_output"."|||";//附件轉成一串字串
					$web_main_link=$web_main_link_sum;//附件輸出
				}
		}
	$web_main_file_from = $do_pq->find('p[align="center"]')->html();//抓取圖片<p></p>+抓圖的html的code
	$Address_frist=strpos($web_main_file_from,"KEY=",0);//抓字首
	$Address_end=strpos($web_main_file_from,"jpg",0);//抓字尾
	$Address_long=$Address_end-$Address_frist;//抓字首和字尾的差
	$web_main_file_check_output=substr($web_main_file_from,$Address_end,3);//抓末三字
	$web_main_file_output=substr($web_main_file_from,$Address_frist+10,$Address_long-7);//抓超連結文字
		if($web_main_file_check_output =="jpg"){//當末三字是jpg時（我還沒看過學校資料上有png或gif的文章附件）
			$web_main_file="http://ta.taivs.tp.edu.tw/news/$web_main_file_output";//圖片輸出
		}
	mysql_query("INSERT INTO stu_main (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
	curl_close($ch);//結束php_curl
?>
