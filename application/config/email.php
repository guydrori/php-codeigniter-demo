<?php
$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => '',
    'smtp_port' => 587,
    'smtp_user' => '',
    'smtp_pass' => '',
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'stream' => [
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]
);