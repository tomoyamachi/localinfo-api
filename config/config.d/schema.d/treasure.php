<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('localinfo', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getInteger('account_id'),
    Column::getVarchar('title'),
    Column::getInteger('comment_count'),
    Column::getInteger('like_count'),
    Column::getVarchar('thumbnail'),
    Column::getVarchar('image'),
    Column::getText('comment'),
    Column::getInteger('prefecture_id'),
    Column::getInteger('area_id'),
    Column::getVarchar('status'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
