<?php
namespace Treasure\Response;

/**
 * Productの情報を配列にして返す
 */
class AbstractModel
{
    protected static $defaultFields;

    /**
     * 複数返す
     * @param \Resultset\Simple $models
     * @return array
     */
    public static function getMultipleContent($models ,$fields = [])
    {
        $result = [];
        foreach ($models as $model) {
            $result[] = self::getContent($model, $fields);
        }
        return $result;
    }

    /**
     * APIで返すとき用
     * @param \Model\Xxxx $model
     * @return array
     */
    public static function getContent($model, $fields = [])
    {
        $response = [];
        if (empty($fields)) {
            $fields = static::$defaultFields;
        }

        if (! $model) { // 有効なモデルでなければ
            throw new \Exception("invalid Model instance");
            return;
        }

        foreach ($fields as $field) {
            // TODO : property_existsでは、magick methodを感知できない
            // 一旦、存在しないpropertyも取得する

            // create直後はモデルのデータなのでint型になっていない。
            // 無理やりint型に変換。
            if (($field === 'id' || strpos($field, '_id') > 0) && ctype_digit($model->$field)) {
                $response[$field] = (int)$model->$field;
            } else {
                $response[$field] = $model->$field;
            }
        }
        return $response;
    }
}
