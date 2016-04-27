<?php
return array (
  'title' => '賞品へのレビュー',
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
    'account_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '当選者ID',
    ),
    'reference_type' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ふくびき/完全当選/ECか',
    ),
    'comment' =>    array (
      'validation' =>      array (
        'require' => true,
        'min' => 10,
      ),
      'label' => 'コメント',
    ),
    'created_at' =>    array (
      'validation' =>      array (
      ),
      'label' => '作成日',
    ),
    'updated_at' =>    array (
      'validation' =>      array (
      ),
      'label' => '最終更新日',
    ),
  ),
  'placeholder' =>  array (
  ),
  'search_filter' =>  array (
  ),
  'editform' =>  array (
  ),
);
