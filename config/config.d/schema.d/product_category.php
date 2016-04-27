<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('product_category', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('parent_category_id'),
    Column::getVarchar('label'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['parent_category_id']),
        ]
]);
