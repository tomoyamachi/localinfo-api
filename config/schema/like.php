<?php
return array (
  'title' => 'いいね',
  'fields' =>  array (
    'id' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ID',
    ),
    'account_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => 'いいねした人',
    ),
    'localinfo_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => 'お宝',
    ),
    'status' =>    array (
      'validation' =>      array (
      ),
      'label' => '状態',
    ),
    'created_at' =>    array (
      'validation' =>      array (
      ),
      'label' => '作成日',
    ),
    'updated_at' =>    array (
      'validation' =>      array (
      ),
      'label' => '更新日',
    ),
  ),
  'placeholder' =>  array (
  ),
  'search_filter' =>  array (
    'account_id' => 'いいねした人',
    'localinfo_id' => 'お宝',
    'created_at' => '作成日',
    'updated_at' => '更新日',
  ),
  'editform' =>  array (
  ),
);
