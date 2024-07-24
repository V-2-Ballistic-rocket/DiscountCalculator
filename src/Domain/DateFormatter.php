<?php

namespace App\Domain;

class DateFormatter
{
    public function formatDate(string $date) : \DateTime
    {
        $date_arr = explode('-', $date); // разбиваем строку на массив
        
        $formatted_date = $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr[0]; // меняем формат на YYYY-MM-DD

        return new \DateTime($formatted_date);
    }
}