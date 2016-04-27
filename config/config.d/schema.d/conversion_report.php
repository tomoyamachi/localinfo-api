<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('conversion_report', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('product_conversion_id'),
    Column::getVarchar('product_conversion_tag'),
    Column::getInteger('current_value'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
