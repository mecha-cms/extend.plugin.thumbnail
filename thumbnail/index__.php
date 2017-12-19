<?php

require __DIR__ . DS . 'engine' . DS . 'plug' . DS . 'to.php';

function fn_thumbnail_h_t_t_p_header() {
    $i = 60 * 60 * 24 * 30 * 12; // 1 Year
    HTTP::header([
        'Pragma' => 'private',
        'Cache-Control' => 'private, max-age=' . $i,
        'Expires' => gmdate('D, d M Y H:i:s', time() + $i) . ' GMT'
    ]);
}

$t = Plugin::state(__DIR__, 'path');
$hook = 'on.' . Path::B(__DIR__) . '.enter';

Hook::set($hook, 'fn_thumbnail_h_t_t_p_header', 1);

Route::set($t . '/%i%/%*%', function($size = 0, $path = "") use($hook) {
    if(!$path = File::exist(ASSET . DS . $path)) {
        HTTP::status(404);
        exit;
    }
    Hook::fire($hook, [$size, $path]);
    Image::take($path)->resize($size)->draw();
    exit;
}, 10.2);

Route::set($t . '/%i%/%i%/%*%', function($width = 0, $height = 0, $path = "") use($hook) {
    if(!$path = File::exist(ASSET . DS . $path)) {
        HTTP::status(404);
        exit;
    }
    Hook::fire($hook, [$width, $height, $path]);
    Image::take($path)->crop($width, $height)->draw();
    exit;
}, 10.1);

Route::set($t . '/%i%/%i%/%i%/%i%/%*%', function($x = 0, $y = 0, $width = 0, $height = 0, $path = "") use($hook) {
    if(!$path = File::exist(ASSET . DS . $path)) {
        HTTP::status(404);
        exit;
    }
    Hook::fire($hook, [$x, $y, $width, $height, $path]);
    Image::take($path)->crop($x, $y, $width, $height)->draw();
    exit;
}, 10);