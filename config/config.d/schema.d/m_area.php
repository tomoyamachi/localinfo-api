<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('m_area', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('m_prefecture_id'),
    Column::getVarchar('name', ['notNull' => true]),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        Index::getIndex(['m_prefecture_id']),
        ]
]);
