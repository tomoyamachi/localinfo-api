<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('product_lottery', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('product_id'),
    Column::getVarchar('status'),
    Column::getInteger('product_delivery_rate_group_id'),
    Column::getInteger('total_limit'),
    Column::getInteger('personal_limit'),
    Column::getInteger('relot_span_hour'),
    Column::getInteger('weight'),
    Column::getDateTime('begin_date'),
    Column::getDateTime('end_date'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
