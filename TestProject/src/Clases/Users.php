<?php

return array(
    "ValidAuth" => [
        'Basic' => "Authorization",
        'BasicValue' => 'Basic cGFuZGFoYXB2YTprYWNoYW1haw=='],

    "InvalidAuth" => [
        'Basic' => "Authorization",
        'BasicValue' => 'Basic CGFuZGFoYXB2YTprYWNoYW1haw=='],

    "NoAuth" => [
        'Basic' => "Authorization",
        'BasicValue' => 'Basic '
    ]


);