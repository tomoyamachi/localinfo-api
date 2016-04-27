<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('product', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('customer_id'),
    Column::getVarchar('name'),
    Column::getVarchar('detail'),
    Column::getInteger('category_id'),
    Column::getInteger('price'),
    Column::getVarchar('code'),
    Column::getVarchar('type'),
    Column::getText('introduction'),
    Column::getVarchar('status'),
    Column::getDateTime('status_limit_date'),
    Column::getDateTime('status_updated_at'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['code']),
        ]
]);
