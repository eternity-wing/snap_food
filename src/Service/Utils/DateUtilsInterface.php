<?php

namespace App\Service\Utils;

interface DateUtilsInterface
{
    public static function strToDate(string $strDate, string $format): \DateTime;
}