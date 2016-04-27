<?php
namespace Papi\Models\Model;

use \Papi\Models\Model\Product;
use \Papi\Models\Model\ProductDeliveryRate;
use \Papi\Models\ApiConnector;
use \Gcl\Util\GArray;
use \Gcl\Util\GDate;
use \Api\Models\Tool\Label;

/**
 * 商品関連テーブルの共通処理部分
 */
abstract class ProductReferenceAbstract extends \Papi\Models\Model\UserAbstract
{
    const STATUS_VALID_NEW = 'valid_new';
    const STATUS_VALID_COMEBACK = 'valid_comeback';
    const STATUS_VALID_CONTINUE = 'valid_continue';
    const STATUS_INVALID = 'invalid';
    const STATUS_PENDING_REVIEW = 'pending';

    public static $statusLabel = [self::STATUS_PENDING_REVIEW => '審査待ち',
                                  self::STATUS_VALID_NEW => '有効(新規)',
                                  self::STATUS_VALID_COMEBACK => '有効(戻り)',
                                  self::STATUS_VALID_CONTINUE => '有効(継続)',
                                  self::STATUS_INVALID => '無効',];

    public static $tableLabels = ['conversion' => '表示管理', 'lottery' => 'ふくびき', 'achievement' => '完全当選'];

    // デフォルトデータ
    protected static $defaultData;

    protected $referenceLabel;
    protected $toolColumnLabels;


    /**
     * 現在開催中のものを選ぶ
     * @param array $parameter
     * @return mixed
     */
    public static function findByParamsInValidTerm($parameter)
    {
        $nowDate = new GDate(time());
        $parameter['conditions']['begin_date <='] = $nowDate->now();
        $parameter['conditions']['end_date >'] = $nowDate->now();
        return static::findByParams($parameter);
    }

    /**
     * 該当賞品の最新の1件を返す
     * @param array conditions
     * @return ProductXxxx
     */
    public static function findFirstLatest($conditions = [])
    {
        $parameter = [];
        $parameter['conditions'] = $conditions;
        $parameter['order'] = 'begin_date DESC';
        return static::findFirstByParams($parameter);
    }

    /**
     * namespace用のlabelだけを配列で返す
     * @param void
     * @return array
     */
    public static function getNameSpaceLabels()
    {
        $namespaces = [];
        foreach (array_keys(self::$tableLabels) as $relation) {
            $namespace = '\\Papi\\Models\\Model\\Product'.ucwords($relation);
            $namespaces[$relation] = $namespace;
        }
        return $namespaces;
    }



    public function initializeByFirst($productId)
    {
        $this->set('product_id', $productId);
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            $this->set($column, $default);
        }
    }


    /**
     * 商品データを取得
     * @param void
     * @return mixed
     */
    public function getProduct()
    {
        return Product::findFirstByIdStrict($this->product_id);
    }


    /**
     * 会社データを取得
     * @param void
     * @return mixed
     */
    public function getCustomer()
    {
        $product = $this->getProduct();
        if ($product) {
            return $product->getCustomer();
        }
    }

    /**
     * 商品名を取得
     * @param void
     * @return mixed
     */
    public function getProductName()
    {
        $product = $this->getProduct();
        if ($product) {
            return $product->name;
        }
        return null;
    }



    /**
     * 表示グループの情報を渡す
     * @param void
     * @return array[$m_application_id => $value]
     */
    public function getDeliveryRateData()
    {
        $mApplications = ApiConnector::getApplications();

        $conditions = ['group_id' => $this->product_delivery_rate_group_id];
        $rates = ProductDeliveryRate::findByParams(['conditions' => $conditions]);
        $result = [];
        foreach ($rates as $rate) {
            if (GArray::get($mApplications, $rate->m_application_id, false) === false) {
                throw new \Exception("invalid m_application_id");
            }
            $result[$rate->m_application_id]['weight'] = $rate->weight;
            $result[$rate->m_application_id]['name'] = $mApplications[$rate->m_application_id]['name'];
        }

        foreach ($mApplications as $mApplication) {
            if (!isset($result[$mApplication['id']])) {
                $result[$mApplication['id']]['weight'] = 0;
                $result[$mApplication['id']]['name'] = $mApplication['name'];
            }
        }
        return $result;
    }


    /**
     * 表示グループから表示する対象を決定
     */
    public function getToolDeliveryRatio()
    {
        $html = '<table class="table table-bordered">';
        //$html .= '<tr><th>アプリ名</th><th>配信する？</th></tr>';

        $result = $this->getDeliveryRateData();
        // アプリ別に重み付けして出す場合は確率で計算する
        /* $totalWeight = 0; */
        /* foreach ($result as $rate) { */
        /*     $totalWeight += $rate['weight']; */
        /* } */

        foreach ($result as $rate) {
            $html .= sprintf(
                '<tr><td>%s</td><td>%s</td>',
                $rate['name'],
                $rate['weight'] > 0 ? '◯' : '×'
                //floor(($rate['weight'] / $totalWeight) * 100)
            );
        }
        return $html.'</table>';
    }

    /**
     * 新規作成/編集時のリンクを返す
     */
    public function getToolEditDataUrl()
    {
        $urlParam = ['product_id' => $this->product_id,
                     'reference' => $this->product_reference_type,];
        if (property_exists($this, 'id')) {
            $urlParam['reference_id'] = $this->id;
        }

        return '/product/editReference?'.http_build_query($urlParam);
    }

    /**
     * 新規作成用のボタンHTMLを返却
     */
    public function getToolCreateDataButton()
    {
        $url = $this->getToolEditDataUrl();
        return $this->getButtonHtmlFromTool(Label::CREATE, $url);
    }


    /**
     * 編集用のボタンHTMLを返却
     */
    public function getToolEditDataButton()
    {
        $url = $this->getToolEditDataUrl();
        return $this->getButtonHtmlFromTool(Label::EDIT, $url);
    }

    /**
     * 説明文を追加
     */
    public function getToolTableLabel()
    {
        return \Gcl\Util\GArray::get(self::$tableLabels, $this->getProductReferenceType(), '設定されていません');
    }

    /**
     * ProductXxxxのXxxx部分を xxxxにして返す
     */
    protected function getProductReferenceType()
    {
        $className = get_class($this);
        $class = new \ReflectionClass($className);
        $callClass = preg_replace("/Product/", '', $class->getShortName());
        return \Gcl\Util\Inflector::snakeCase($callClass);
    }

    // {{{ public function addFirstData( )
    /**
     * 名前などの入力
     * @param  array $postData
     * @param array $config
     * @return boolean 成功/失敗
     */
    public function addFirstData($postData, $config)
    {
        $from = 'form';

        if (isset($postData['product_delivery'])) {
            $groupId = ProductDeliveryRate::getGroupIdFindOrCreate($postData['product_delivery']);
            $this->set('product_delivery_rate_group_id', $groupId);
        } else {
            throw new \Exception("Must set product_delivery_data!");
        }

        return \Api\Models\Validator::setAndValidatePostData($this, $postData, $config, $from);
    }
    // }}}

    /**
     * 管理ツール用に開始日と終了日を指定
     * @return string
     */
    public function getToolStartEndDateVisible()
    {
        $beginDate = new GDate($this->begin_date);
        $endDate = new GDate($this->end_date);
        $dateText =  $beginDate->d2s().'〜'.$endDate->d2s();

        $nowDate = new GDate(time());
        if ($nowDate->isDateInRange($this->begin_date, $this->end_date)) {
            $dateText .= ' ('.Label::IN_TERM.')';
        }
        return $dateText;
    }


    /**
     * 管理ツール用のhtmlを返す
     * @param void
     * @return string
     */
    public function getToolReferenceHistory()
    {
        $html = '<table class="table-bordered bgcolor-data">';
        foreach ($this->toolColumnLabels as $method => $label) {
            $html.= sprintf('<tr><td>%s</td><td>%s</td></tr>', $label, $this->$method);
        }
        $html.= sprintf('<tr><td>%s</td><td>%s</td></tr>', Label::EDIT, $this->getEditPageButtonHtml());
        return $html.'</table><div class="spacer20"></div>';
    }

    /**
     * 編集/新規追加ページへのリンクボタン
     * @param void
     * @return string
     */
    protected function getEditPageButtonHtml()
    {
        $urlParam = ['product_id' => $this->product_id,
                     'reference' => $this->referenceLabel,
                     'reference_id' => $this->id];
        return $this->getButtonHtmlFromTool(Label::TO_EDIT, '/product/editReference', $urlParam);
    }


    /**
     * レポート用のスクリプトを返却
     * @param void
     * @return string
     */
    public function getToolPanelStatSet()
    {
        return false;
    }


    /**
     * レポート用の当選者情報一覧を返却
     * @param void
     * @return string
     */
    public function getToolPanelSendSet()
    {
        return false;
    }

    /**
     * ステータスのラベルを取得
     */
    public function getLabelByStatus()
    {
        return isset(self::$statusLabel[$this->status]) ? self::$statusLabel[$this->status] : $this->status;
    }
}
