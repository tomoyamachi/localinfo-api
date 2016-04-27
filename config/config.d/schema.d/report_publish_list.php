<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('report_publish_list', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('report_segment_id', ['notNull' => true]),
    Column::getInteger('product_id', ['notNull' => true]),
    Column::getVarchar('column_type', ['notNull' => true]),
    Column::getVarchar('column_value', ['notNull' => true]),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['report_segment_id','product_id']),
        ]
]);
