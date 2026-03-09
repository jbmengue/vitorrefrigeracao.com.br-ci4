<?php

if (! function_exists('whatsapp_conversion_onclick')) {
    function whatsapp_conversion_onclick(?string $message = null): string
    {
        $number = (string) (appConfig()->whatsappLink ?? '');
        $number = preg_replace('/\D+/', '', $number);

        if ($number === '') {
            return "return false;";
        }

        $url = 'https://wa.me/' . $number;

        if (! empty($message)) {
            $url .= '?text=' . rawurlencode($message);
        }

        return "return gtag_report_conversion('{$url}')";
    }
}