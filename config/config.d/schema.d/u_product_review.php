<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('u_product_review', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('product_id', ['notNull' => true]),
    Column::getInteger('account_id', ['notNull' => true]),
    Column::getVarchar('reference_type'),
    Column::getText('comment', ['notNull' => true]),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['product_id']),
        Index::getIndex(['account_id']),
        ]
]);
