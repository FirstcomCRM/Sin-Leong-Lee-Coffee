<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
          //  'dsn' => 'mysql:host=localhost;dbname=sinleong_crm',
        //    'username' => 'sinleonglee',
        //    'password' => '^QZth6~8K7{D',
              'dsn' => 'mysql:host=localhost;dbname=sinleong_crm',
              'username' => 'root',
              'password' => '',
              'charset' => 'utf8',
              'enableSchemaCache' => true,
              'enableQueryCache' => true,
              'schemaCacheDuration' => 3600,
              'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
