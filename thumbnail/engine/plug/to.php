<?php

To::_('thumbnail', function(...$lot) use($url) {
    $in = array_shift($lot);
    if (!is_string($in)) return $in;
    if (strpos($in, $u = To::URL(ASSET) . '/') === 0) {
        return str_replace($u, $url . '/' . Plugin::state('thumbnail', 'path') . '/' . implode('/', array_filter($lot)) . '/', $in);
    }
    return $in;
});