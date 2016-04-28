<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('treasure', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('account_id'),
    Column::getVarchar('image'),
    Column::getText('comment'),
    Column::getInteger('m_prefecture_id'),
    Column::getInteger('m_area_id'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
