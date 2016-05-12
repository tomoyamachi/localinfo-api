<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('account', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('nickname'),
    Column::getText('login_token'),
    Column::getInteger('treasure_count'),
    Column::getInteger('comment_count'),
    Column::getInteger('like_count'),
    Column::getVarchar('status'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
