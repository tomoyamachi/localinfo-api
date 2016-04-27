<?php
use Gpl\Db\Table;
use Gpl\Db\Column;
use Gpl\Db\Index;

return Table::getDefinition('customer', [
        'columns' => [
    Column::getPrimaryKey('id'),
    Column::getVarchar('name', ['notNull' => true]),
    Column::getVarchar('name_kana'),
    Column::getVarchar('phone_number', ['notNull' => true]),
    Column::getVarchar('fax_number'),
    Column::getVarchar('contact'),
    Column::getVarchar('mail'),
    Column::getVarchar('status', ['notNull' => true]),
    Column::getVarchar('postcode'),
    Column::getVarchar('prefecture'),
    Column::getVarchar('city'),
    Column::getVarchar('address'),
    Column::getVarchar('house'),
    Column::getVarchar('open_information'),
    Column::getVarchar('url'),
    Column::getText('detail'),
    Column::getText('memo'),
    Column::getVarchar('support'),
    Column::getInteger('prohibit_call'),
    Column::getDateTime('docs_mail_date'),
    Column::getDateTime('docs_post_date'),
    Column::getDateTime('docs_fax_date'),
    Column::getDateTime('created_at'),
    Column::getDateTime('updated_at'),
                      ],
        'indexes' => [
           Index::getPrimary(['id']),
        ]
]);
