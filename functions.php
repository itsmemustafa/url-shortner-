<?php

define('DB', 'urls.json');

function get_data() {
    if (!file_exists(DB)) {
        return [];
    }
    $j = file_get_contents(DB);
    $d = json_decode($j, true) ?? [];

    $m = false;
    foreach ($d as $c => $v) {
        if (is_string($v)) {
            $d[$c] = [
                'url' => $v,
                'clicks' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $m = true;
        }
    }

    if ($m) {
        save_data($d);
    }

    return $d;
}

function save_data($u) {
    file_put_contents(DB, json_encode($u, JSON_PRETTY_PRINT));
}

function gen_code($l = 6) {
    $ch = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $c = '';
    for ($i = 0; $i < $l; $i++) {
        $c .= $ch[rand(0, strlen($ch) - 1)];
    }
    return $c;
}

function shorten($u) {
    $us = get_data();

    foreach ($us as $c => $d) {
        if ($d['url'] === $u) {
            return $c;
        }
    }

    $c = gen_code();
    while (!empty($us[$c])) {
        $c = gen_code();
    }

    $us[$c] = [
        'url' => $u,
        'clicks' => 0,
        'created_at' => date('Y-m-d H:i:s')
    ];
    save_data($us);

    return $c;
}

function get_url($c) {
    $us = get_data();
    return !empty($us[$c]) ? $us[$c]['url'] : null;
}

function click($c) {
    $us = get_data();
    if (!empty($us[$c])) {
        $us[$c]['clicks']++;
        save_data($us);
    }
}
