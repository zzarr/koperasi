<?php

if (!function_exists('filterNumber')) {
    /**
     * Filter hanya angka dari sebuah string.
     *
     * @param string $value
     * @return string
     */
    function filterNumber($value)
    {
        return preg_replace('/[^\d.]/', '', $value); // Hanya angka dan titik
    }
}

function formatRupiah($angka, $text = true)
{
    return ($text ? "Rp " : '') . number_format($angka, 0, ',', '.');
}

function limitText($content = false, $limit = false, $stripTags = true, $ellipsis = true)
{
    if ($content && $limit) {
        $content = ($stripTags ? strip_tags($content) : $content);
        $content = explode(' ', $content, $limit + 1);
        array_pop($content);
        if ($ellipsis) {
            array_push($content, '...');
        }
        $content = implode(' ', $content);
    }
    return $content;
}

function dateFormat($date)
{
    return date('Y-m-d', strtotime($date));
}

function monthArray($locale = 'id', $isSlug = false)
{
    if ($locale == 'id') {
        $month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        if ($isSlug) $month = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agst', 'Sept', 'Okt', 'Nov', 'Des'];
    } else {
        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        if ($isSlug) $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    }

    $data = [];
    $i = 1;
    foreach ($month as $item) {
        $data[] = [
            'name'  => $item,
            'code'  => $i,
            'value' => 0
        ];
        $i++;
    }

    return collect($data);
}
