<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('sales_history', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('customer_id'),
    Column::getVarchar('sales_type'),
    Column::getDateTime('sales_date'),
    Column::getInteger('sales_member_id'),
    Column::getDateTime('recall_date'),
    Column::getInteger('recall_member_id'),
    Column::getVarchar('recall_status'),
    Column::getText('detail'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['customer_id']),
        ]
]);
