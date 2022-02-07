<?php

namespace App\Service\Utils;

class DateUtils implements DateUtilsInterface
{
    public static function strToDate(string $strDate, string $format='Y-m-d'): \DateTime
    {
        return \DateTime::createFromFormat($format, $strDate);
    }
}