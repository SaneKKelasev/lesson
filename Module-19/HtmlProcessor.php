<?php

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $text = json_decode(file_get_contents('php://input'));

        if (empty($text)) {
           http_response_code(500);
           break;
        }

        $patterns = '/<a[^>]*?>(.*?)<\/a>/si';
        $text = preg_replace_callback($patterns, function ($matches) {
            return $matches[1];
        }, $text->raw_text);
        $jsonText = json_encode(['formatted_text' => $text]);
        echo $jsonText;
        break;
}