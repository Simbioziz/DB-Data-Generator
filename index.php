<?php

require_once("lib/config.php"); //Подключение конфига
require_once("lib/class.php"); //Подключение функций


$db = new DBGenerate();

if (isset($_POST["upload"])) {
    if(!empty($_POST["max_rows"])) {
        
    $db->uploadDb(stripslashes($_POST["bname"]), stripslashes($_POST["max_rows"]), stripslashes($_POST["bdata"]));
    $dbs= unserialize($_POST["bdata"]);
    $bname = $db->strip_data($_POST["bname"]);
    $max_rows = $db->strip_data($_POST["max_rows"]);
    
    //Разбивка массивов на элементы
    foreach($dbs['Field'] as $field) {$cf[] = "'" . $field . "'";}
    foreach($dbs['Type'] as $type) {$ct[] = "'". $type ."'";}
    foreach($dbs['Type'] as $type) {$nobant[] = $type;}
    foreach($dbs['Extra'] as $type) {$extra[] = $type;}
    //Чистка массива
    $string = preg_replace('/\\s*\\([^()]*\\)\\s*/', '', implode(", ",$nobant));
    $massiv = explode(", ", $string);
    foreach($nobant as $v){
        preg_match_all('/\\(([^()]*)\\)/', $v, $string1);
        $string2 = preg_replace('/\\s*\\([^()]*\\)\\s*/', '', $v);
        $string1 = implode(", ", $string1[1]);
        //Формирование массива для свича
        $nmas[] = array('0' => $string2 , '1' => $string1);

    }
    //Ассациация элементов массива с типами дынных БД
    while ($i < $max_rows){
    foreach($nmas as $nvalue)
        {
        switch ($nvalue[0]) {
        case 'int':
        case 'tinyint':
        case 'smallint':
        case 'mediumint':
        case 'float':                          
            $mas[] = $db->keyGenerator($nvalue[1]);
        break;
        case('varchar'):
            $mas[] = $db->getRibka($nvalue[1]);
            break;
        case 'bit':
        case 'bool':
            return rand(0,1);
            break;
        case ('date'):                
            $mas[] = $db->getRandomdate();        
            break;
        case 'datetime':
        case 'timestamp':
            $mas[] = $db->getRandomdt();
            break;
        case ('time'):
            $mas[] = $db->getRandomtime();
            break;
        case('year'):
            $mas[] = $db->getRandomyear();
            break;
        case 'text':
            $mas[] = $db->getRibka();
            }
        }
        //Добавление данных в базу
        $cft = "'" .implode("', '", $mas). "'";            
        $query = "REPLACE INTO $bname VALUES ($cft)";
        $result = mysql_query($query);
        if(!$result){
            echo "Ошибочка вышла (";
        }
        //Счетчик окончания цикла
        $i++;
        unset($mas);         
    }
    }
    else { echo "Вы не ввели количество строк которое хотите добавить!";}
}
//Отрисовка БД в виде таблицы с инпутом 
$db->getStructure('yes');
//Отрисовка структуры БД в виде массива
//echo "<pre>";
//print_r($db->getStructure());
//echo "<pre>";
  ?>
