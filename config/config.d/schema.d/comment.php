<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('comment', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('account_id', ['notNull' => true]),
    Column::getVarchar('localinfo_id', ['notNull' => true]),
    Column::getText('comment'),
    Column::getVarchar('status'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['localinfo_id','status']),
        Index::getIndex(['account_id','status']),
        ]
]);
