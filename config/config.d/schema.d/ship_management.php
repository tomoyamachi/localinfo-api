<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('ship_management', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('account_id'),
    Column::getInteger('account_address_id'),
    Column::getVarchar('reference_type'),
    Column::getInteger('reference_id'),
    Column::getInteger('u_reference_id'),
    Column::getVarchar('auto_confirmation'),
    Column::getVarchar('ship_status'),
    Column::getVarchar('delivery_service'),
    Column::getVarchar('delivery_id'),
    Column::getDateTime('begin_delivery_date'),
    Column::getDateTime('end_delivery_date'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
