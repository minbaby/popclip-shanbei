#!/usr/bin/env php
<?php

function __($txt) {
    echo $txt;
    die(); 
}

$API_SEARCH = "https://api.shanbay.com/bdc/search/?word=%s";

$url = sprintf($API_SEARCH, $_ENV['POPCLIP_TEXT']);
$ret = file_get_contents($url);

if (empty($ret)) {
    __("ERROR: network error");
}

$json = json_decode($ret, true);

if(!is_array($json)) {
    __("ERROR: decode json");
}

if ($json['status_code'] == 1) {
    __($json['msg']);
} elseif ($json['status_code'] != 0) {
    __("ERROR: request error");
}

__(sprintf("【%s】%s", $json['data']['pronunciation'], str_replace("\n", "; ", $json['data']['definition'])));




