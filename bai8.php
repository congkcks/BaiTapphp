<?php
// Bài 8 – Đếm số âm/dương/0 trong mảng
function bai8_handle($arrstr) {
    if (trim($arrstr) === '') {
        // random 10 số trong [-10, 10]
        $arr = [];
        for ($i = 0; $i < 10; $i++) $arr[] = rand(-10, 10);
    } else {
        $parts = array_map('trim', explode(',', $arrstr));
        $arr = array_map('intval', $parts);
        if (count($arr) != 10) {
            // chuẩn hóa về đúng 10 phần tử
            $arr = array_slice($arr, 0, 10);
            while (count($arr) < 10) $arr[] = 0;
        }
    }
    $pos = 0; $neg = 0; $zero = 0;
    foreach ($arr as $x) {
        if ($x > 0) $pos++;
        elseif ($x < 0) $neg++;
        else $zero++;
    }
    return ['array' => $arr, 'pos' => $pos, 'neg' => $neg, 'zero' => $zero];
}
