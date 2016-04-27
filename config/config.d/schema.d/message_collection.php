<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('message_collection', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('label'),
    Column::getVarchar('sub_key'),
    Column::getText('txt'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
