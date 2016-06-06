<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('localinfo_image', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('localinfo_id'),
    Column::getVarchar('file'),
    Column::getVarchar('image'),
    Column::getVarchar('status'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['localinfo_id']),
        ]
]);
