<?php

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=mymessanger',
            'username' => 'sp2111user',
            'password' => 'sp2111pswd',
            'tablePrefix' => 'keys_',
        ],
        'mailer' => [
            //'useFileTransport' => true,
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'lvg.zp.ua@gmail.com',
                'password' => 'zzaaqq112233',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];