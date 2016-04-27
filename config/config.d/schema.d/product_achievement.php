<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('product_achievement', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('product_id', ['notNull' => true]),
    Column::getVarchar('status', ['notNull' => true]),
    Column::getInteger('product_delivery_rate_group_id', ['notNull' => true]),
    Column::getInteger('point', ['notNull' => true]),
    Column::getInteger('total_limit', ['notNull' => true]),
    Column::getInteger('personal_limit', ['notNull' => true]),
    Column::getDateTime('begin_date'),
    Column::getDateTime('end_date'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['product_id']),
        Index::getIndex(['begin_date','end_date']),
        ]
]);
