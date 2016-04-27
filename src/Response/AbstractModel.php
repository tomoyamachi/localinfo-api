<?php
namespace Papi\Response;

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
    public static function getMultipleContent($models)
    {
        $result = [];
        foreach ($models as $model) {
            $result[] = self::getContent($model);
        }
        return $result;
    }

    /**
     * APIで返すとき用
     * @param \Model\Xxxx $model
     * @return array
     */
    public static function getContent($model, $params = [])
    {
        $response = [];
        $params = array_merge($params, static::$defaultFields);

        if (! $model) { // 有効なモデルでなければ
            throw new \Exception("invalid Model instance");
            return;
        }

        foreach ($params as $param) {
            // TODO : property_existsでは、magick methodを感知できない
            // 一旦、存在しないpropertyも取得する
            $response[$param] = $model->$param;
        }
        return $response;
    }
}
