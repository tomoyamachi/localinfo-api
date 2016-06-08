<?php
return array (
  'title' => 'エリア一覧',
  'fields' =>  array (
    'id' =>    array (
      'validation' =>      array (
      ),
      'label' => 'ID',
    ),
    'prefecture_id' =>    array (
      'validation' =>      array (
      ),
      'label' => '都道府県ID',
    ),
    'name' =>    array (
      'validation' =>      array (
        'require' => true,
      ),
      'label' => '名前',
    ),
    'longitude' =>    array (
      'validation' =>      array (
      ),
      'label' => '経度',
    ),
    'latitude' =>    array (
      'validation' =>      array (
      ),
      'label' => '緯度',
    ),
  ),
  'placeholder' =>  array (
  ),
  'search_filter' =>  array (
    'name' => '名前',
  ),
  'editform' =>  array (
  ),
);
