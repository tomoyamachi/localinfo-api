<?php
return array (
  'title' => 'お宝へのコメント',
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
      'label' => '投稿者',
    ),
    'treasure_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => 'お宝',
    ),
    'comment' =>    array (
      'validation' =>      array (
      ),
      'label' => 'コメント内容',
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
    'account_id' => '投稿者',
    'treasure_id' => 'お宝',
    'comment' => 'コメント内容',
    'status' => '状態',
    'created_at' => '作成日',
    'updated_at' => '更新日',
  ),
  'editform' =>  array (
  ),
);
