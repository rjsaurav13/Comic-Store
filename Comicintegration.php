<?php
$url = get_headers('https://c.xkcd.com/random/comic', true);
$art = file_get_contents($url['Location'][true] . 'info.0.json');
$artwork = json_decode($art, true);
$image = $artwork['img'];
$heading = $artwork['safe_title'];
