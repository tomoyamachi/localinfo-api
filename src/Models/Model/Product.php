<?php
/**
 * Papi\Models\Model
 */
namespace Papi\Models\Model;

use \Papi\Models\Model\ProductConversion;
use \Papi\Models\Model\ProductLottery;
use \Papi\Models\Model\ProductAchievement;
use \Api\Models\Tool\Label;

/**
 * Product
 */
class Product extends \Papi\Models\Model\UserAbstract
{
    const THUMBNAIL_FOLDER = '100x100';

    const STATUS_PROSPECT = 'prospect';
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    const STATUS_PENDING_REVIEW = 'pending';

    protected static $defaultData = [
                                     'id' => null,
                                     'name' => null,
                                     'detail' => null,
                                     'category_id' => 1,
                                     'price' => null,
                                     'code' => null,
                                     'type' => 'food',
                                     'introduction' => null,
                                     'status' => 'valid',
                                     'status_limit_date' => 'now',
                                     'status_updated_at' => 'now'
                                     ];

    public static $statusLabel = [self::STATUS_PENDING_REVIEW => '審査待ち',
                                  self::STATUS_PROSPECT => '見込み',
                                  self::STATUS_VALID => '有効',
                                  self::STATUS_INVALID => '無効',];

    public static $typeLabel = ['food' => '食品',
                            'inn' => '宿',
                            'amuse' => '体験型',
                            'ticket' => 'クーポン',
                            'object' => 'もの'];

    public function initializeByFirst($customerId)
    {
        $this->set('customer_id', $customerId);
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            $this->set($column, $default);
        }
    }

    /**
     * 商品に関連する情報を取得する
     * @param void
     * @return array['conversion' => Result,...]
     */
    public function getReferences()
    {
        $result = [];
        foreach (ProductReferenceAbstract::getNameSpaceLabels() as $relation => $namespace) {
            $conditions = ['product_id' => $this->id];
            $result[$relation] = $namespace::findByParams(['conditions' => $conditions]);
        }
        return $result;
    }

    /**
     * 管理ツールで商品に紐づくデータを一覧するときのメソッド
     * @return string
     */
    public function getToolReferenceHistory()
    {
        $result = $this->getReferences();

        $html = '<table class="table table-bordered">';
        $html .= '<tr>';
        foreach (array_keys($result) as $reference) {
            $urlParam = ['product_id' => $this->id, 'reference' => $reference];
            $html .= '<th>'.ProductReferenceAbstract::$tableLabels[$reference].
                $this->getButtonHtmlFromTool(Label::CREATE, '/product/editReference', $urlParam).'</th>';

        }
        $html .= '</tr>';
        $html .= '<tr>';
        foreach ($result as $reference => $dataList) {
            $html .= '<td>';
            $html .= '<div style="width:300px;height:400px;overflow:auto;">';

            if (count($dataList) == 0) {
                $html .= '<span style="color:red;">データがありません</span>';
            }

            foreach ($dataList as $referenceData) {
                $html .= $referenceData->getToolReferenceHistory();
            }
            $html .= '</div>';
            $html .= '</td>';
        }
        $html .= '</tr>';

        $html .= '</table>';
        return $html;
    }

    /**
     * 商品編集ページへのボタン
     * @param void
     * @return string
     */
    public function getToolNameEditButton()
    {
        $urlParam = ['customer_id' => $this->customer_id,
                     'product_id' => $this->id];
        $html = $this->name.'<br/>'.$this->detail.'<br/>';
        $html .= $this->getButtonHtmlFromTool(Label::EDIT, '/product/edit', $urlParam);
        return $html;
    }

    /**
     * 賞品に関連した企業を取得
     * @return \Company
     */
    public function getCustomer()
    {
        return Customer::findFIrstByIdStrict($this->customer_id);
    }

    /**
     * 賞品タイプのラベルを取得
     */
    public function getLabelByType()
    {
        return isset(self::$typeLabel[$this->type]) ? self::$typeLabel[$this->type] : $this->type;
    }


    /**
     * ステータスのラベルを取得
     */
    public function getLabelByStatus()
    {
        return isset(self::$statusLabel[$this->status]) ? self::$statusLabel[$this->status] : $this->status;
    }

    /**
     * 画像タグとして返却
     * @return string
     */
    public function getThumbnailImageTag()
    {
        $tag = new \Api\Helper\AppTag();
        $imagePath = sprintf('/products/%s/%d.png', self::THUMBNAIL_FOLDER, $this->id);
        return $tag->appImage($imagePath, []);
    }

    /**
     * 最新のProductConversionを戻す
     * @return ProductConversion
     */
    public function getLatestConversion()
    {
        $conditions = ['product_id' => $this->id];
        return ProductConversion::findFirstLatest($conditions);
    }
}
