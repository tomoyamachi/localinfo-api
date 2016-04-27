<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('u_achievement', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('product_achievement_id'),
    Column::getInteger('account_id'),
    Column::getVarchar('status'),
    Column::getInteger('m_application_id'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['product_achievement_id']),
        Index::getIndex(['account_id']),
        ]
]);
