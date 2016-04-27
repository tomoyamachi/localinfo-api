<?php
return array (
  'title' => '賞品の表示目標マスタ',
  'fields' =>  array (
    'id' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ID',
    ),
    'product_id' =>    array (
      'validation' =>      array (
      ),
      'label' => '賞品ID',
    ),
    'status' =>    array (
      'validation' =>      array (
      ),
      'label' => '契約状況',
    ),
    'product_delivery_rate_group_id' =>    array (
      'validation' =>      array (
      ),
      'label' => '配信比率ID',
    ),
    'type' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => 'コンバージョン種類',
    ),
    'product_per_conversion' =>    array (
      'validation' =>      array (
        'require' => true,
        'format' => 'integer',
      ),
      'label' => 'コンバージョン回数',
    ),
    'max_product_quantity' =>    array (
      'validation' =>      array (
        'require' => true,
        'format' => 'integer',
      ),
      'label' => '最大個数',
    ),
    'tag' =>    array (
      'validation' =>      array (
      ),
      'label' => 'コンバージョンタグ(初期不要)',
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
