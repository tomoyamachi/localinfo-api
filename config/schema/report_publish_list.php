<?php
return array (
  'title' => '賞品レポートの期間ID',
  'fields' =>  array (
    'id' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ID',
    ),
    'report_segment_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => 'レポートセグメントID',
    ),
    'product_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '賞品ID',
    ),
    'column_type' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '保存するカラム',
    ),
    'column_value' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '保存するデータ',
    ),
  ),
  'placeholder' =>  array (
  ),
  'search_filter' =>  array (
    'report_segment_id' => 'レポートセグメントID',
    'product_id' => '賞品ID',
  ),
  'editform' =>  array (
  ),
);
