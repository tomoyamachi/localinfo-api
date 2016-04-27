<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('customer_member', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('customer_id', ['notNull' => true]),
    Column::getVarchar('authority'),
    Column::getVarchar('name', ['notNull' => true]),
    Column::getVarchar('name_kana'),
    Column::getVarchar('position'),
    Column::getVarchar('phone_number'),
    Column::getVarchar('mail', ['notNull' => true]),
    Column::getText('password'),
    Column::getText('memo'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['customer_id']),
        ]
]);
