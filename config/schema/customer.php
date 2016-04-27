<?php
return array (
  'title' => '顧客情報',
  'fields' =>  array (
    'id' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ID',
    ),
    'name' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '顧客名',
    ),
    'name_kana' =>    array (
      'validation' =>      array (
      ),
      'label' => '顧客名(かな)',
    ),
    'phone_number' =>    array (
      'validation' =>      array (
        'require' => true,
        'min' => 10,
        'max' => 15,
        'format' => 'integer',
      ),
      'label' => '代表電話番号',
    ),
    'fax_number' =>    array (
      'validation' =>      array (
      ),
      'label' => 'fax番号',
    ),
    'contact' =>    array (
      'validation' =>      array (
      ),
      'label' => '連絡方法',
    ),
    'mail' =>    array (
      'validation' =>      array (
      ),
      'label' => '代表メールアドレス',
    ),
    'status' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => 'アカウント状態',
    ),
    'postcode' =>    array (
      'validation' =>      array (
        'min' => 7,
        'max' => 7,
        'format' => 'integer',
      ),
      'label' => '郵便番号(ハイフンなし)',
    ),
    'prefecture' =>    array (
      'validation' =>      array (
        'min' => 3,
        'max' => 5,
      ),
      'label' => '都道府県',
    ),
    'city' =>    array (
      'validation' =>      array (
      ),
      'label' => '市区町村',
    ),
    'address' =>    array (
      'validation' =>      array (
      ),
      'label' => '番地など',
    ),
    'house' =>    array (
      'validation' =>      array (
      ),
      'label' => '建物名・部屋番号（マンションなどの場合）',
    ),
    'open_information' =>    array (
      'validation' =>      array (
      ),
      'label' => '開店時間',
    ),
    'url' =>    array (
      'validation' =>      array (
      ),
      'label' => 'サイトリンク',
    ),
    'detail' =>    array (
      'validation' =>      array (
      ),
      'label' => '店舗詳細',
    ),
    'memo' =>    array (
      'validation' =>      array (
      ),
      'label' => '会社用のメモなど',
    ),
    'support' =>    array (
      'validation' =>      array (
      ),
      'label' => '営業担当者',
    ),
    'prohibit_call' =>    array (
      'validation' =>      array (
      ),
      'label' => 'コール禁止',
    ),
    'docs_mail_date' =>    array (
      'validation' =>      array (
      ),
      'label' => 'メールで資料送付済み',
    ),
    'docs_post_date' =>    array (
      'validation' =>      array (
      ),
      'label' => '郵送で資料送付済み',
    ),
    'docs_fax_date' =>    array (
      'validation' =>      array (
      ),
      'label' => 'faxで資料送付済み',
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
    'name' => '株式会社 日本一',
    'name_kana' => 'にほんいち',
  ),
  'search_filter' =>  array (
    'name' => '顧客名',
    'name_kana' => '顧客名(かな)',
    'phone_number' => '代表電話番号',
    'postcode' => '郵便番号(ハイフンなし)',
    'prefecture' => '都道府県',
  ),
  'editform' =>  array (
  ),
);
