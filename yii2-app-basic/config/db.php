<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=localhost\SQLEXPRESS;Database=todo',
    'username' => 'todo',
    'password' => '951753',
    'charset' => 'utf8',
    'enableSchemaCache' => false,

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
