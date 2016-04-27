<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('product_delivery_rate', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('group_id'),
    Column::getInteger('m_application_id'),
    Column::getInteger('weight'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['group_id']),
        Index::getIndex(['m_application_id']),
        ]
]);
