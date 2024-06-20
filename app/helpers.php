<?php

if (!function_exists('isset_and_not_empty')) {
    function isset_and_not_empty($variable)
    {
        return isset($variable) && !empty($variable);
    }
}

if (!function_exists('calculate_cart_total')) {
    function calculate_cart_total($quantity, $unitPrice)
    {
        return $quantity * $unitPrice;
    }
}
