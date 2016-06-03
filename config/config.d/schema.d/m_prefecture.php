<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('m_prefecture', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('name', ['notNull' => true]),
    Column::getVarchar('longitude'),
    Column::getVarchar('latitude'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
