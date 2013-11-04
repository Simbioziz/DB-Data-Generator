<?php

class DBGenerate {
// Извлечение таблиц из базы
function getDbTables()
{
    $sql = 'SHOW TABLES FROM ' . DB_NAME. '';
    $result = mysql_query($sql);
    
    $tables = array();
    while ($row = mysql_fetch_array($result)){
        $tables[] = $row[0];
    }
    return $tables;
}
// Сообщение при добавлении
function uploadDb($bname, $max_rows, $bdata){
    echo "Добавлено(а) <b>".$max_rows."</b> строк(а) в таблицу <b>".$bname."</b>.";
}
//Построение структуры таблицы и сабмита
function getStructure($show='no')
{
    foreach($this->getDbTables() as $key=>$v){
    
    
    $statement = "DESCRIBE $v"; 
    $sql = mysql_query($statement); 
    while($result = mysql_fetch_array($sql)) 
    {
        $fields[$v]['Field'][] = $result['Field']; 
        $fields[$v]['Type'][] = $result['Type'];
        $fields[$v]['Extra'][] = $result['Extra'];
    }
    if($show=='yes'){
    $this->showTables($v, $fields[$v]);
    $raz = serialize($fields[$v]);
    echo "
            <br /><form name=myform action=index.php method=POST>
            Количество строк: <input type=text name='max_rows' size=1/>
            <input type=hidden value='$v' name='bname'/>
            <input type=hidden value='$raz' name='bdata'/>
            <input type=submit name='upload' value='Добавить рыбок в базу'>
            </form>";}
    else {
    print_r($fields[$v]);
    }
}
}
//Отрисовка таблицы БД
function showTables($kname, $keyser) {
    echo "<h3>Таблица: ".$kname."</h3>";
    echo '<table cellpadding="3" cellspacing="0" border="1">';
    foreach ($keyser as $key => $value) {
    echo "<tr>";
    foreach ($value as $data)
        echo "<td>".$data."</td>";
    echo "</tr>";
    }
    echo "</table>"; 
}
//Проверка передаваемых данных из формы
function strip_data($text)
{
    $quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" );
    $goodquotes = array ("-", "+", "#" );
    $repquotes = array ("\-", "\+", "\#" );
    $text = trim( strip_tags( $text ) );
    $text = str_replace( $quotes, '', $text );
    $text = str_replace( $goodquotes, $repquotes, $text );
    //$text = ereg_replace(" +", " ", $text);     
    return $text;
}
//Текст "Рыба"
function getRibka($symbol = 99999999999999)
{
    $ribka = 'Те, кому когда-либо приходилось делать в квартире ремонт, наверное, 
    обращали внимание на старые газеты, наклеенные под обоями. Как правило, пока все
     статьи не перечитаешь, ничего другого делать не можешь. Интересно же — обрывки 
     текста, чья-то жизнь... Так же и с рыбой. Пока заказчик не прочтет всё, 
     он не успокоится. Бывали случаи, когда дизайн принимался именно из-за 
    рыбного текста, который, разумеется, никакого отношения к работе не имел.' ;
    if ($symbol < strlen($ribka)){ return substr($ribka, 0, $symbol);}
    return $ribka;    
}
//Генерация случайного числа в заданном диапозоне
function keyGenerator($digits_quantity, $string = false, $zero = 1)  
    {  
        $random_number = 0;  
        $digits = 0;
        $rand_max =0;
      
        while($digits < $digits_quantity)  
        {  
            $rand_max .= "9";  
            $digits++;  
        }  
        mt_srand((double) microtime() * 1000000);   
        $random_number = mt_rand($zero, intval($rand_max));  
      
        if($string)  
        {  
            if(strlen(strval($random_number)) < $digits_quantity)  
            {  
                $zeros_quantity = $digits_quantity - strlen(strval($random_number));  
                $digits = 0;  
                while($digits < $zeros_quantity)  
                {  
                    $str_zeros .= "0";  
                    $digits++;  
                }  
                $random_number = $str_zeros . $random_number;  
            }  
        }  
        return $random_number;  
    }
//Генерация случайной даты
function getRandomdate()
{
    $y = $this->getRandomyear();
    $m = rand(01, 12);
    $d = rand(01, 29);
    return $y."-".$m."-".$d;
}
//Генерация случайного года
function getRandomyear()
{
    return rand(2010, date('Y'));
}
//Генерация случайного времени
function getRandomtime()
{
    $h  = rand(00, 23);
    $m = rand(00, 59);
    $s = rand(00, 59);
    return $h.":".$m.":". $s;
}
//Генерация случайного датавремени
function getRandomdt()
{
    return $this->getRandomdate() . ' ' . $this->getRandomtime(); 
}
}
?>
