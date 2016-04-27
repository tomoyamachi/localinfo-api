<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Treasure\Models\Model\ProductReferenceAbstract;
use \Treasure\Models\Model\ConversionReport;

/**
 * ProductConversion
 */
class ProductConversion extends ProductReferenceAbstract
{
    const CONVERSION_TYPE_PV = 'pv';
    protected static $defaultData = ['id' => null,
                            'status' => parent::STATUS_VALID_NEW,
                            'product_delivery_rate_group_id' => null,
                            'type' => self::CONVERSION_TYPE_PV,
                            'product_per_conversion' => null,
                            'max_product_quantity' => null,
                            'tag' => null,
                            'begin_date' => 'now',
                            'end_date' => 'now',
                            ];
    protected $toolColumnLabels = [
                         'tool_start_end_date_visible' => '表示期間',
                         'label_by_status' => '状態',
                         'tool_delivery_ratio' => '配信比率',
                         'product_per_conversion' => 'CV/1商品',
                         'max_product_quantity' => '最大個数',
                         'tool_current_conversion_degree' => '進捗',
                         ];

    protected $referenceLabel = 'conversion';


    /**
     * コンバージョンの箇所に到達したので保存
     * @param string $tag
     * @return boolean
     */
    public function reach($tag)
    {
        if ($tag == $this->tag) {
            $conditions = ['product_conversion_id' => $this->id,
                           'product_conversion_tag' => $tag];
            $report = ConversionReport::findFirstByParams(['conditions' => $conditions]);
            if (! $report instanceof ConversionReport) {
                $report = new ConversionReport();
                $report->initializeByFirst($this->id, $tag);
            }
            $report->addValue();
            $report->save();
            return true;
        }

        return false;
    }

    /**
     * 保証しているPV数とそうではないPV数の進捗を確認
     * @return string
     */
    public function getToolCurrentConversionDegree()
    {
        $currentViewed = 0;
        $conditions = ['product_conversion_id' => $this->id, 'product_conversion_tag' => 'pv'];
        $report = ConversionReport::findFirstByParams(['conditions' => $conditions]);
        if ($report) {
            $currentViewed = $report->current_value;
        }

        $assureranceViewed = $this->product_per_conversion * $this->max_product_quantity;
        $rate = floor(($currentViewed * 100)/$assureranceViewed);
        return sprintf('%d / %d 個消費 (%d%%)', $currentViewed, $assureranceViewed, $rate);
    }


    /**
     * コンバージョンの保証回数
     * @param void
     * @return int
     */
    public function getWarrantyConversion()
    {
        return $this->product_per_conversion * $this->max_product_quantity;
    }


    /**
     * コンバージョンのユーザーデータを確認
     * @param void
     * @return ConversionReport
     */
    public function getConversionReport()
    {
        $conditions = ['product_conversion_id' => $this->id];
        return ConversionReport::findFirstByParams(['conditions' => $conditions]);
    }

    /**
     * レポート用のスクリプトを返却
     * @param void
     * @return string
     */
    public function getToolPanelStatSet()
    {
        $panelHeadline = '商品カード閲覧数';

        $warrantyConversion = $this->getWarrantyConversion();
        $conversionReport = $this->getConversionReport();
        $currentConversion = $conversionReport->current_value;
        $panelBody = '<div id="pv-bar" style="height:100%;"></div>';
        $panelBody .= sprintf('保証回数 : %d回<br/>今回の結果 : %d回', $warrantyConversion, $currentConversion);

        // jsグラフ用
        $panelBody .= <<<EOF
<script>
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {
      var data = google.visualization.arrayToDataTable([
        ['', ''],
        ['結果', {$currentConversion}],
        ['目標値', {$warrantyConversion}]
      ]);

      var options = {chartArea: {width: '100%'},hAxis: {minValue: 0},vAxis: {title: '表示回数'}};
      var chart = new google.visualization.BarChart(document.getElementById('pv-bar'));
      chart.draw(data, options);
    }
</script>
EOF;
        return ['headline' => $panelHeadline, 'body' => $panelBody];
    }
}
