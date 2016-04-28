<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('like', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('account_id', ['notNull' => true]),
    Column::getInteger('treasure_id', ['notNull' => true]),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
