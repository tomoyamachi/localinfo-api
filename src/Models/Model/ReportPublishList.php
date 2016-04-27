<?php
/**
 * Papi\Models\Model
 */
namespace Papi\Models\Model;

class ReportPublishList extends \Papi\Models\Model\UserAbstract
{

    /**
     * 管理ツール用のハッシュを作成する
     * @param int $reportId, $productId,
     * @return array
     */
    public static function getToolPublishHash($reportId, $productId)
    {
        $result = [];
        $conditions = ['report_segment_id' => $reportId, 'product_id' => $productId];
        $targetDatas = self::findByParams(['conditions' => $conditions]);
        foreach ($targetDatas as $data) {
            $result[$data->column_type][$data->column_value] = $data->column_value;
        }
        return $result;
    }
}
