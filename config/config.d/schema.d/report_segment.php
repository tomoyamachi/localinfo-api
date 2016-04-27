<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('report_segment', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getDateTime('begin_date'),
    Column::getDateTime('end_date'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
