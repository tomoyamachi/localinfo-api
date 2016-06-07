<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('import_log', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('type'),
    Column::getVarchar('table_name'),
    Column::getVarchar('user_name'),
    Column::getInteger('add_num'),
    Column::getInteger('mod_num'),
    Column::getInteger('del_num'),
    Column::getText('message'),
    Column::getDateTime('created_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
