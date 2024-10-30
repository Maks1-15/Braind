<?php 

function generateAnons($text, $max_length = 250, $url = "#") { 
    // $text - текст, который необходимо сократить; $max_length - максимальное кол-во символов; $url - адрес статьи
    // Разбиваем текст на слова
    $words = explode(' ', $text);
    // Список слов для аннотации 
    $anons = [];
    // Длина текущей аннотации
    $length = 0; 
 
    foreach ($words as $word) { 
        if ($length + mb_strlen($word) <= $max_length) { // Добавляем слово, если не превышает максимальную длину 
            $anons[] = $word; // Добавляем подходящее слово, соответстующее условию
            $length += mb_strlen($word) + 1; // + 1, т.к. учитывается пробел 
        } else { 
            break; // Прекращаем добавление слов 
        } 
    } 
 
    // Берем последние 3 слова 
    $url_words = array_slice($anons, -3);
    // Объединяем слова в строку  
    $url_text = implode(' ', $url_words);
    // Удаляем последние 3 слова 
    $anons = array_slice($anons, 0, -3); 
    // Добавляем ссылки к последним трем словам 
    $anons[] = '<a href="' . $url . '">' . $url_words[0] . '</a>'; 
    $anons[] = '<a href="' . $url . '">' . $url_words[1] . '</a>'; 
    $anons[] = '<a href="' . $url . '">' . $url_words[2] . '</a>'; 
    // Объединяем слова в строку с многоточием 
    return implode(' ', $anons) . '...'; 
} 
 
// Пример использования 
$test_1 = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."; 
 
$anons = generateAnons($test_1, 250, "#"); 
echo $anons;

