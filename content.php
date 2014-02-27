<?php
//$content = $modx->documentObject['content'];	
//Поиск заголовков в статье
preg_match_all('/<[hH]([1-6])>(.*?)<\/[hH][1-6]>/',$content,$matches);

/*
$matches массив со следующим содержимым:
[0][0-9] –названия заголовков статьи заключенных в HTML теги;
[1][0-9] –уровень вложенности заголовка;
[2][0-9] –названия заголовков статьи;
*/

echo '<pre>';
var_dump($matches);
echo '</pre>';

//Создание содержания
$quantityanchor=0;//Счетчик для якоря
$soderjanie="<noindex><div id=\"soderg\"><div class=\"soderg\">Содержание:</div><ol class=\"header1\">";
//for ($i=0;$i<count($matches[0]);$i++){
foreach($matches[0] as $i => $value){
	
	if ($i<>0 and $matches[1][$i]>$matches[1][$i-1]){
		$soderjanie.="<ul class=\"header".$matches[1][$i]."\">";
	}elseif ($i<>0 and $matches[1][$i]<$matches[1][$i-1]){
		$quantity=$matches[1][$i-1]-$matches[1][$i];
		for ($j=1;$j<=$quantity;$j++)$soderjanie.="</ul>";
	}
	
	//Создание якорей в “содержании”, на заголовки в статье
	$quantityanchor++;
	$soderjanie.="<li><a href=\"#hr".$quantityanchor."\">{$matches[2][$i]}</a></li>";

	
}
$soderjanie.="</ol></div></noindex>";

$index = 0;
foreach($matches[0] as $key => $val){
	$index++;
//Изменение заголовков статьи, путем добавления для каждого уникального ID
	$content=str_replace($matches[0][$key],"<H".$matches[1][$key]." id=\"hr".$quantityanchor."\">".$matches[2][$key]."-".$index."</H".$matches[1][$key].">",$content);
	
	//echo $index;
	
echo $index;
}	


//Вывод содержания
echo $soderjanie;
//Вывод статьи
echo $content;
?>