<?php
return array (
  'title' => '賞品の完全当選',
  'fields' =>  array (
    'id' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ID',
    ),
    'product_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '賞品ID',
    ),
    'status' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '契約状況',
    ),
    'product_delivery_rate_group_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '配信比率ID',
    ),
    'point' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '応募に必要なポイント',
    ),
    'total_limit' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '付与上限数',
    ),
    'personal_limit' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '1人あたりの当選個数',
    ),
    'begin_date' =>    array (
      'validation' =>      array (
      ),
      'label' => '開始日時',
    ),
    'end_date' =>    array (
      'validation' =>      array (
      ),
      'label' => '終了日時',
    ),
  ),
  'placeholder' =>  array (
  ),
  'search_filter' =>  array (
  ),
  'editform' =>  array (
  ),
);
