<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('account', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('nickname'),
    Column::getText('login_token'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
