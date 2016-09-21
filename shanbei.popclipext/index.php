#!/usr/bin/env php
<?php

error_reporting(0);

function __($txt)
{
    echo $txt;
    die();
}

$API_SEARCH = "https://api.shanbay.com/bdc/search/?word=%s";

$url = sprintf($API_SEARCH, getenv('POPCLIP_TEXT'));

$contextOptions = [
    "ssl" => [
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ],
];

$ret = file_get_contents($url, false, stream_context_create($contextOptions));

if (empty($ret)) {
    __("ERROR: network error");
}

$json = json_decode($ret, true);

if (!is_array($json)) {
    __("ERROR: decode json");
}

if ($json['status_code'] == 1) {
    __($json['msg']);
} elseif ($json['status_code'] != 0) {
    __("ERROR: request error");
}

__(sprintf("【%s】%s", $json['data']['pronunciation'], str_replace("\n", "; ", $json['data']['definition'])));
