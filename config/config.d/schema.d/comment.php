<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('comment', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('account_id', ['notNull' => true]),
    Column::getVarchar('treasure_id', ['notNull' => true]),
    Column::getInteger('comment'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
