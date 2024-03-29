<?php

/**
 * переводит первый символ строки в верхний регистр
 *
 * @param string $string
 * @param string $enc
 *
 * @return string
 */
function mb_ucfirst($string, $enc = 'UTF-8')
{
    return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) . mb_substr($string, 1, mb_strlen($string, $enc), $enc);
}

/**
 * @param string $inns
 * @param bool $stripkop
 * @return string|string[]|null
 */
function num2str($inns, $stripkop = false)
{
    $num = str_replace(' ', '', $inns);
    $num = str_replace('р.', '', $num);
    $num = str_replace('.', ',', $num);
    //print $num.'<br>';
    $inn = $num;
    $nol = 'ноль';

    $str[100] = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
    $str[11] = ['', 'десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать', 'двадцать'];
    $str[10] = ['', 'десять', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];

    $sex = [
        ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'], // m
        ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'] // f
    ];

    $forms = [
        ['копейка', 'копейки', 'копеек', 1], // 10^-2
        ['рубль', 'рубля', 'рублей', 0], // 10^ 0
        ['тысяча', 'тысячи', 'тысяч', 1], // 10^ 3
        ['миллион', 'миллиона', 'миллионов', 0], // 10^ 6
        ['миллиард', 'миллиарда', 'миллиардов', 0], // 10^ 9
        ['триллион', 'триллиона', 'триллионов', 0], // 10^12
    ];

    $out = $tmp = [];

    $tmp = explode('.', str_replace(',', '.', $inn));
    $rub = number_format((float)$tmp[0], 0, '', '-');

    if ($rub == 0) $out[] = $nol;

    // нормализация копеек
    $kop = isset($tmp[1]) ? substr(str_pad($tmp[1], 2, '0', STR_PAD_RIGHT), 0, 2) : '00';

    $segments = explode('-', $rub);

    $offset = count($segments);

    $o = [];

    if ((int)$rub == 0) { // если 0 рублей
        $o[] = $nol;
        $o[] = morph(0, $forms[1][0], $forms[1][1], $forms[1][2]);
    } else {
        foreach ($segments as $k => $lev) {
            $sexi = (int)$forms[$offset][3]; // определяем род
            $ri = (int)$lev; // текущий сегмент

            if ($ri == 0 && $offset > 1) { // если сегмент==0 & не последний уровень(там Units)
                $offset--;
                continue;
            }
            // нормализация
            $ri = str_pad($ri, 3, '0', STR_PAD_LEFT);
            // получаем циферки для анализа
            $r1 = (int)substr($ri, 0, 1); //первая цифра
            $r2 = (int)substr($ri, 1, 1); //вторая
            $r3 = (int)substr($ri, 2, 1); //третья
            $r22 = (int)$r2 . $r3; //вторая и третья

            // разгребаем порядки
            if ($ri > 99) $o[] = $str[100][$r1]; // Сотни

            if ($r22 > 20) { // >20
                $o[] = $str[10][$r2];
                $o[] = $sex[$sexi][$r3];
            } else { // <=20
                if ($r22 > 9) $o[] = $str[11][$r22 - 9]; // 10-20
                elseif ($r22 > 0) $o[] = $sex[$sexi][$r3]; // 1-9
            }

            // Рубли
            $o[] = morph($ri, $forms[$offset][0], $forms[$offset][1], $forms[$offset][2]);

            $offset--;
        }
    }
    // Копейки
    if (!$stripkop) {
        $o[] = $kop;
        $o[] = morph($kop, $forms[0][0], $forms[0][1], $forms[0][2]);
    }

    return preg_replace("/s{2,}/", ' ', implode(' ', $o));
}

/**
 * Склоняем словоформу
 *
 * @param $n
 * @param $f1
 * @param $f2
 * @param $f5
 * @return mixed
 */
function morph($n, $f1, $f2, $f5)
{
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $f5;
    if ($n1 > 1 && $n1 < 5) return $f2;
    if ($n1 == 1) return $f1;

    return $f5;
}

/**
 * @param $num
 * @return string
 */
function prop($num)
{
    # Все варианты написания чисел прописью от 0 до 999 скомпонуем в один небольшой массив
    $m = [
        ['ноль'],
        ['-', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'],
        ['-', '-', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'],
        ['-', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'],
        ['-', 'одна', 'две']
    ]; # Все варианты написания разрядов прописью скомпонуем в один небольшой массив

    $r = [
        ['...ллион', '', 'а', 'ов'], // используется для всех неизвестно больших разрядов
        ['тысяч', 'а', 'и', ''],
        ['миллион', '', 'а', 'ов'],
        ['миллиард', '', 'а', 'ов'],
        ['триллион', '', 'а', 'ов'],
        ['квадриллион', '', 'а', 'ов'],
        ['квинтиллион', '', 'а', 'ов']
    ]; // ,[... список можно продолжить ];

    if ($num == 0) return $m[0][0]; # Если число ноль, сразу сообщить об этом и выйти

    $o = []; # Сюда записываем все получаемые результаты преобразования

    # Разложим исходное число на несколько трехзначных чисел и каждое полученное такое число обработаем отдельно
    foreach (array_reverse(str_split(str_pad($num, ceil(strlen($num) / 3) * 3, '0', STR_PAD_LEFT), 3)) as $k => $p) {
        $o[$k] = [];
        # Алгоритм, преобразующий трехзначное число в строку прописью
        foreach ($n = str_split($p) as $kk => $pp) {
            if (!$pp) continue;
            else {
                switch ($kk) {
                    case 0:
                        $o[$k][] = $m[4][$pp];
                        break;
                    case 1:
                        if ($pp == 1) {
                            $o[$k][] = $m[2][$n[2]];
                            break 2;
                        } else
                            $o[$k][] = $m[3][$pp];
                        break;
                    case 2:
                        if (($k == 1) && ($pp <= 2))
                            $o[$k][] = $m[5][$pp];
                        else
                            $o[$k][] = $m[1][$pp];
                        break;
                }
            }
        }

        $p *= 1;

        if (!$r[$k]) $r[$k] = reset($r);

        # Алгоритм, добавляющий разряд, учитывающий окончание руского языка
        if ($p && $k)
            switch (true) {
                case preg_match("/^[1]$|^\\d*[0,2-9][1]$/", $p):
                    $o[$k][] = $r[$k][0] . $r[$k][1];
                    break;
                case preg_match("/^[2-4]$|\\d*[0,2-9][2-4]$/", $p):
                    $o[$k][] = $r[$k][0] . $r[$k][2];
                    break;
                default:
                    $o[$k][] = $r[$k][0] . $r[$k][3];
                    break;
            }

        $o[$k] = implode(' ', $o[$k]);
    }

    return implode(' ', array_reverse($o));
}

/**
 * @param $date
 * @return string
 */
function russian_date($date)
{
    $date = explode(".", $date);
    switch ($date[1]) {
        case 1:
            $m = 'января';
            break;
        case 2:
            $m = 'февраля';
            break;
        case 3:
            $m = 'марта';
            break;
        case 4:
            $m = 'апреля';
            break;
        case 5:
            $m = 'мая';
            break;
        case 6:
            $m = 'июня';
            break;
        case 7:
            $m = 'июля';
            break;
        case 8:
            $m = 'августа';
            break;
        case 9:
            $m = 'сентября';
            break;
        case 10:
            $m = 'октября';
            break;
        case 11:
            $m = 'ноября';
            break;
        case 12:
            $m = 'декабря';
            break;
        default:
            $m = '';
            break;
    }

    return $date[0] . '&nbsp;' . $m . '&nbsp;' . $date[2];
}