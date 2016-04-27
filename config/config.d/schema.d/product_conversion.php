<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('product_conversion', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('product_id'),
    Column::getVarchar('status'),
    Column::getInteger('product_delivery_rate_group_id'),
    Column::getVarchar('type', ['notNull' => true]),
    Column::getInteger('product_per_conversion', ['notNull' => true]),
    Column::getInteger('max_product_quantity', ['notNull' => true]),
    Column::getVarchar('tag'),
    Column::getDateTime('begin_date'),
    Column::getDateTime('end_date'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
