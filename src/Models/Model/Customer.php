<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\SalesHistory;
use \Api\Models\Tool\Label;
use Gcl\Util\GDate;

/**
 * Customer
 */
class Customer extends \Treasure\Models\Model\UserAbstract
{
    const STATUS_INIT = 'init'; // 新規
    const STATUS_CONTINUE = 'continue'; // 継続
    const STATUS_BEFORE = 'before'; // 見込み
    const STATUS_DELETE = 'delete'; // 削除

    public static $editStatusLabel = ['init' => '新規',
                                      'before' => '見込み',
                                      'continue' => '継続',];

    protected static $defaultData = [
                                     'id' => null,
                                     'name' => null,
                                     'name_kana' => null,
                                     'phone_number' => null,
                                     'fax_number' => null,
                                     'mail' => null,
                                     'contact' => '電話',
                                     'open_information' => null,
                                     'status' => 'init',
                                     'postcode' => null,
                                     'prefecture' => null,
                                     'city' => null,
                                     'address' => null,
                                     'house' => null,
                                     'url' => 'http://',
                                     'detail' => null,
                                     'memo' => null,
                                     'support' => null,
                                     'prohibit_call' => 0,
                                     'docs_post_date' => null,
                                     'docs_fax_date' => null,
                                     'docs_mail_date' => null,
                                     ];

    public function initializeByFirst($member)
    {
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            // 担当者は利用者の名前
            if ($column === 'support') {
                $default = $member->name;
            }
            $this->set($column, $default);
        }
    }

    /**
     * 顧客に紐付いている商品一覧を取得
     * @param void
     * @return Resultset
     */
    public function getProducts()
    {
        $conditions = ['customer_id' => $this->id];
        $products = Product::findByParams(['conditions' => $conditions]);
        return $products;
    }

    /**
     * 住所をくっつけて返却
     * @return string
     */
    protected function getAllAddress()
    {
        return $this->prefecture.$this->city.$this->address.$this->house;
    }

    /**
     * URLリンク
     */
    protected function getUrlHtmlLink()
    {
        if (!empty($this->url)) {
            return sprintf('<a href="%s">リンク</a>', $this->url);
        }
        return Label::NO_DATA;
    }

    /**
     * メイン情報
     */
    protected function getToolMainInfo()
    {
        $html = '<h4>'.$this->name.'</h4>';

        $fields = ['phone_number' => '代表電話', 'all_address' => '住所', 'url_html_link' => 'サイト'];
        $html .= '<table class="table table-bordered">';
        //フォームの内容
        foreach ($fields as $method => $label) {
            $html.= sprintf('<tr><td>%s</td><td>%s</td></tr>', $label, $this->$method);
        }
        //終了タグ
        $html .= '</table>';

        $html .= $this->getToolEditButton();
        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $html .= $this->getToolGoToReportButton();
        return $html;
    }

    /**
     * 営業履歴
     */
    protected function getToolSalesHistory()
    {
        $html = '';
        $conditions = ['customer_id' => $this->id];
        $histories = SalesHistory::findByParams(['conditions' => $conditions,
                                                 'order' => 'id DESC']);

        $html .= SalesHistory::getNewHistoryForm($this->id);
        if (count($histories) > 0) {
            // 一定の領域だけ表示させる
            $html .= '<div style="height:400px;overflow:auto;">';

            // テーブルのカラムを作成
            $columnLabels = [
                             'tool_date_visible' => 'コール日時',
                             'tool_caller_name' => 'コール担当',
                             'tool_recall_date_edit' => '再コール状況',
                             'tool_detail_edit' => '詳細',
                             ];
            // 履歴を検索
            foreach ($histories as $history) {
                //開始タグ
                $html .= '<div class="bgcolor-data">';
                $html .= $history->tool_form_begin;
                $html .= '<table class="table table-bordered">';

                //フォームの内容
                foreach ($columnLabels as $method => $label) {
                    $html.= sprintf('<tr><td>%s</td><td>%s</td></tr>', $label, $history->$method);
                }

                //終了タグ
                $html .= '</table>';
                $html .= $history->tool_form_end;
                $html .= '</div>';
            }
            // 一定の領域だけ表示させる
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * 管理ツールに表示する会社のメンバーリスト
     *
     * @SuppressWarnings(PHPMD)
     */
    protected function getToolMemberList()
    {
        $conditions = ['customer_id' => $this->id];
        $members = CustomerMember::findByParams(['conditions' => $conditions]);

        if (count($members) > 0) {
            // テーブルのカラムを作成
            $columnLabels = ['担当者名', '役職', '連絡先', '編集'];
            $html = $this->getTableHeaderFromTool($columnLabels);
            foreach ($members as $member) {
                $record = [$member->name, $member->position, $member->phone_number, $member->tool_edit_data_button];

                // 担当という文字列があれば太字にする
                if ((strpos('担当', $member->position) !== false)) {
                    $record = array_map([$this, 'makeStrongTag'], $record);
                }

                $html .= $this->getTableRecordFromTool($record);
            }
            $html .= $this->getTableFooterFromTool();
        } else {
            $html = '<span style="color:red;">'.Label::NO_DATA.'</span>';
            $html .= '<div class="spacer10" />';
        }

        $createMember = new CustomerMember();
        $createMember->set('customer_id', $this->id);
        $html .= $createMember->getToolEditDataButton();

        return $html;
    }

    /**
     * 強調して返す
     * @param string $text
     * @return string
     */
    public function makeStrongTag($text)
    {
        return '<b>'.$text.'</b>';
    }

    /**
     * 管理ツールに表示する商品データ
     */
    protected function getToolProductCount()
    {
        $conditions = ['customer_id' => $this->id];
        $results = Product::findByParams(['conditions' => $conditions]);

        if (count($results) > 0) {

            $columnLabels = ['商品名', Label::CONVERSION, Label::LOTTERY, Label::ACHIEVEMENT];
            $html = $this->getTableHeaderFromTool($columnLabels);

            // 各商品のキャンペーン情報を取得する
            foreach ($results as $result) {
                $record = [];
                $record[] = $result->getToolNameEditButton();
                $countCondition = 'product_id = '.$result->id;
                // 各商品関連テーブルの情報をもってきて、リンクを貼り付ける
                foreach (ProductReferenceAbstract::getNameSpaceLabels() as $relation => $namespace) {
                    $url = '/customer/checkProduct';
                    $urlParam = ['product_id' => $result->id, 'type' => $relation];

                    $record[] = sprintf(
                        '<a href="%s">%s</a>件',
                        $url.'?'.http_build_query($urlParam),
                        $namespace::count($countCondition)
                    );
                }
                $html .= $this->getTableRecordFromTool($record);
            }
            $html .= $this->getTableFooterFromTool();
        } else {
            $html = Label::NO_DATA;
            $html .= '<div class="spacer10" />';
        }
        $html .= $this->getToolProductsButton();
        return $html;
    }

    public function getToolProductsButton()
    {
        $urlParam = ['customer_id' => $this->id];
        return $this->getButtonHtmlFromTool('商品一覧へ', '/customer/products', $urlParam);
    }

    public function getEditProductPageButtonHtml()
    {
        $urlParam = ['customer_id' => $this->id];
        return $this->getButtonHtmlFromTool('商品を新規作成', '/product/edit', $urlParam);
    }

    /**
     * 商品レポートへのボタンリンク
     * @return string
     */
    public function getToolGoToReportButton()
    {
        $urlParam = ['customer_id' => $this->id];
        return $this->getButtonHtmlFromTool('集計済みレポートを'.Label::CONFIRM, '/report/list', $urlParam);
    }

    public function getToolEditButton()
    {
        $label = Label::CREATE;
        $urlParam = [];
        if (property_exists($this, 'id')) {
            $label = Label::TO_DETAIL;
            $urlParam = ['customer_id' => $this->id];
        }
        return $this->getButtonHtmlFromTool($label, '/customer/edit', $urlParam);
    }


    /**
     * 顧客削除ボタン
     * @return string
     */
    public function getToolDeleteButton($status = self::STATUS_DELETE, $label = Label::TO_DELETE)
    {
        $urlParam = ['customer_id' => $this->id, 'status' => $status];
        $url = '/customer/delete?'.http_build_query($urlParam);
        return sprintf("<input type=\"button\" value=\"%s\" onClick=\"location.href='%s'\" class=\"btn btn-danger\">", $label, $url);
    }

    // 地方を取得
    public function getRegion()
    {
        return $this->prefecture;
    }

    /**
     * 担当者を取得
     * @return CustomerMember
     */
    private function getResponser()
    {
        $conditions = ['customer_id' => $this->id];
        $members = CustomerMember::findByParams(['conditions' => $conditions]);
        if (count($members) === 0) {
            return false;
        }
        if (count($members) === 1) {
            return $members->getFirst();
        }

        $responserOrder = [1 => '担当',
                           2 => '代表'];
        foreach ($responserOrder as $position) {
            foreach ($members as $member) {
                if (strpos($member->position, $position) !== false) {
                    return $member;
                }
            }
        }
        return false;
    }

    /**
     * 担当者名を取得
     * @return string
     */
    public function getResponserName()
    {
        $responser = $this->getResponser();
        if ($responser === false) {
            return '';
        }
        return $responser->name;
    }

    /**
     * 担当者の電話番号
     * @return string
     */
    public function getResponserPhone()
    {
        $responser = $this->getResponser();
        if ($responser === false) {
            return '';
        }
        return $responser->phone_number;
    }
}
