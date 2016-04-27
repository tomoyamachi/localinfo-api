<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('u_lottery', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('product_lottery_id'),
    Column::getInteger('account_id'),
    Column::getVarchar('status'),
    Column::getInteger('m_application_id'),
    Column::getDateTime('relot_date'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['product_lottery_id']),
        Index::getIndex(['account_id']),
        Index::getIndex(['product_lottery_id','status']),
        ]
]);
