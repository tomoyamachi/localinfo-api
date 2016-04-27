<?php
/**
 * Papi\Models\Model
 */
namespace Papi\Models\Model;

use \Gcl\Util\GDate;
use \Api\Models\Tool\Label;

/**
 * ReportSegment
 */
class ReportSegment extends \Papi\Models\Model\UserAbstract
{
    private $productId;
    private $productName;

    /**
     * レポート表示画面に表示できるデータだけを返す
     * @param Resultset $products
     * @return array
     */
    public static function getToolReportExistData($products)
    {
        $reportExistData = [];
        $reports = self::find();
        foreach ($reports as $report) {
            foreach ($products as $product) {
                foreach ($product->getReferences() as $referenceModels) {
                    foreach ($referenceModels as $model) {
                        if ($report->filterReferenceModel($model)) {
                            $report->setProductId($product->id);
                            $report->setProductName($product->name.' '.$product->detail);
                            $report->setShipmentData($model);
                            $reportExistData[$report->id] = $report;
                        }
                    }
                }
            }
        }
        return $reportExistData;
    }



    /**
     * 商品に紐づくキャンペーンがレポートの集計期間中かを確認
     * @param \Papi\Models\Model\ProductXxxx $model
     * @return bool
     */
    public function filterReferenceModel($model)
    {
        $modelBegin = new GDate($model->begin_date);
        if ($modelBegin->isDateInRange($this->begin_date, $this->end_date) === false) {
            return false;
        }
        $modelEnd = new GDate($model->end_date);
        if ($modelEnd->isDateInRange($this->begin_date, $this->end_date) === false) {
            return false;
        }
        return true;
    }

    /**
     * 発送状況を保存する場所
     * @param \Papi\Models\Model\ProductXxxxx $model
     * @return void
     */
    public function setShipmentData($model)
    {
        // TODO : shipment_managementからデータを取得
        return $model;
    }

    /**
     * 発送済みかどうか
     * @param void
     * @return string
     */
    public function getToolShipmentLabel()
    {
        return '<span class="label label-primary">発送済み</span> 10/30(33%)';
    }


    /**
     * レポート編集ページへのボタン
     * @param void
     * @return string
     */
    public function getToolEditButton()
    {
        $urlParam = ['product_id' => $this->productId,
                     'report_id' => $this->id];
        $html = $this->getButtonHtmlFromTool(Label::TO_EDIT, '/report/edit', $urlParam);
        return $html;
    }

    /**
     * レポート用のURLを作成するためにproduct_idを設定する
     * @param int $productId
     * @return void
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }


    /**
     * レポート用のURLを作成するためにproduct_nameを設定する
     * @param int $productName
     * @return voname
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }


    /**
     * 商品名を返す
     * @return string
     */
    public function getToolProductName()
    {
        return $this->productName;
    }
}
