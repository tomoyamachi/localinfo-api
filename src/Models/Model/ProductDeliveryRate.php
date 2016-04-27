<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

/**
 * ProductDeliveryRate
 */
class ProductDeliveryRate extends \Treasure\Models\Model\UserAbstract
{
    /**
     * group_idを返す。現在無い情報であれば作成する
     * @param array $deliveryRates
     * @return int
     */
    public static function getGroupIdFindOrCreate($deliveryRates)
    {
        // 現在あるテーブルの中で見つかれば、そのgroup_idを返す
        foreach (self::getToolAllHash() as $groupId => $applicationHash) {
            $diff = array_diff_assoc($applicationHash, $deliveryRates);
            if (empty($diff)) {
                return $groupId;
            }
        }

        // 現在の最大のgroup_idよりも大きい値をgroup_idにする
        // foreachの処理が長い場合、レコードの更新が競合する可能性があるので、再度とり直す。
        // TODO : transactionをつかう
        $maxGroupIdData = self::maximum(["column" => "group_id"]);
        $createGroupIdData = $maxGroupIdData + 1;

        foreach ($deliveryRates as $mApplicationId => $weight) {
            $model = new self();
            $model->group_id = $createGroupIdData;
            $model->m_application_id = $mApplicationId;
            $model->weight = $weight < 0 ? 0 : $weight;
            $model->save();
        }
        return $createGroupIdData;
    }


    /**
     * 管理ツール用 既存のデータの中に、今回の指定データと同じ組み合わせがあるかを見るためのもの
     * @return array
     */
    public static function getToolAllHash()
    {
        $datas = self::find();
        $group = [];
        foreach ($datas as $data) {
            $group[$data->group_id][$data->m_application_id] = $data->weight;
        }
        return $group;
    }
}
