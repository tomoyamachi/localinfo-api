<?php
return array (
  'title' => '顧客の担当者情報',
  'fields' =>  array (
    'id' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ID',
    ),
    'customer_id' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '顧客ID',
    ),
    'authority' =>    array (
      'validation' =>      array (
      ),
      'label' => '権限',
    ),
    'name' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '担当者名',
    ),
    'name_kana' =>    array (
      'validation' =>      array (
      ),
      'label' => '担当者名(かな)',
    ),
    'position' =>    array (
      'validation' =>      array (
      ),
      'label' => '職位',
    ),
    'phone_number' =>    array (
      'validation' =>      array (
        'format' => 'integer',
      ),
      'label' => '電話番号',
    ),
    'mail' =>    array (
      'validation' =>      array (
        'require' => true,
        'format' => 'mail',
      ),
      'label' => 'メールアドレス',
    ),
    'password' =>    array (
      'validation' =>      array (
      ),
      'label' => 'パスワード',
    ),
    'memo' =>    array (
      'validation' =>      array (
      ),
      'label' => '担当者用のメモ',
    ),
    'created_at' =>    array (
      'validation' =>      array (
      ),
      'label' => '作成日',
    ),
    'updated_at' =>    array (
      'validation' =>      array (
      ),
      'label' => '最終契約更新日',
    ),
  ),
  'placeholder' =>  array (
    'name' => 'ごち村 ごち太郎',
    'name_kana' => 'ごちむらごちたろう',
    'position' => '担当etc',
    'phone_number' => '09041413119',
    'mail' => 'hoge@mail.com',
  ),
  'search_filter' =>  array (
    'customer_id' => '顧客ID',
    'name' => '担当者名',
    'name_kana' => '担当者名(かな)',
    'phone_number' => '電話番号',
    'mail' => 'メールアドレス',
  ),
  'editform' =>  array (
  ),
);
