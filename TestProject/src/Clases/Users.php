<?php

return array(
    "validAuth" => [
        'Basic' => "Authorization",
        'BasicValue' => 'Basic cGFuZGFoYXB2YTprYWNoYW1haw=='],

    "invalidAuth" => [
        'Basic' => "Authorization",
        'BasicValue' => 'Basic CGFuZGFoYXB2YTprYWNoYW1haw=='],

    "noAuth" => [
        'Basic' => "Authorization",
        'BasicValue' => 'Basic '
    ]


);