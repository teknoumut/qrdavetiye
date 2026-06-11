<?php

if (! function_exists('formatCurrency')) {
    function formatCurrency(float $amount): string
    {
        return number_format($amount, 2, ',', '.').' TL';
    }
}
