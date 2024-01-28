<?php

namespace App\Helpers;

class CutString
{
    public function cut(string $string, int $toString): string
    {
        return substr($string, 0, $toString).'...';
    }
}
