<?php
/**
 *  ReportControllerクラス
 *  顧客へのレポート送付関連
 */
namespace Treasure\Tool\Controllers;

use \Treasure\Models\ApiConnector;
use \Treasure\Models\Model\ReportSegment;
use \Treasure\Models\Model\ReportPublishList;
use \Treasure\Models\Model\ConversionReport;
use \Treasure\Models\Model\Customer;
use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\ProductConversion;
use \Treasure\Models\Model\ProductLottery;
use \Treasure\Models\Model\ProductAchievement;
use \Treasure\Models\Model\UProductReview;
use \Treasure\Models\Model\MessageCollection;

use \Api\Models\Tool\Label;
use \Api\Models\Validator;
use \Api\Models\Paginator;
use \Phalcon\Mvc\View;
use \Gcl\Util\GDate;

class ReportController extends \Treasure\Tool\Controllers\AbstractController
{
    protected $customerActions = ['detail' => 1,]; // 顧客
    protected $employeeActions = ['list' => 1, 'edit' => 1, 'detail' => 1,]; // 社内バイト

    /**
     * その商品のレポート一覧
     */
    public function listAction()
    {
        $req = $this->request;
        $customerId = $req->get('customer_id');
        if (empty($customerId)) {
            throw new \Exception("please set customer_id;");
        }
        $page = $req->get('page');
        $limit = 100;

        $this->view->customer = Customer::findFirstByIdStrict($customerId);
        $products = $this->view->customer->getProducts();

        // 商品に紐づくキャンペーンを全て取得
        // TODO : データが増えて、処理が重くなれば、都度確認ではなくキャッシュなどにデータを保持する
        $reportExistData = ReportSegment::getToolReportExistData($products);

        $this->view->fields = ['id' => 'レポートID',
                               'tool_product_name' => '商品名',
                               'begin_date' => '集計開始',
                               'end_date' => '集計終了',
                               'tool_shipment_label' => '発送状況',
                               'tool_edit_button' => Label::TO_CONFIRM];

        $paginator = Paginator::factory($reportExistData)->init($page, $limit);
        $this->view->paginator = $paginator;
    }

    /**
     * ReportPublishListを作成する
     * @param int $reportId, $productId, $postData
     * @return bool
     */
    private function createNewReportPublish($reportId, $productId, $posts)
    {

        $validType = ['achievement_check' => 1, 'review' => 1];
        foreach ($posts as $columnType => $postData) {
            if (isset($validType[$columnType])) {
                if (! is_array($postData)) {
                    continue;
                    //throw new \Exception("invalid postData : ".$columnType);
                }
                foreach ($postData as $data) {
                    $publish = new ReportPublishList();
                    $publish->set('report_segment_id', $reportId);
                    $publish->set('product_id', $productId);
                    $publish->set('column_type', $columnType);
                    $publish->set('column_value', $data);
                    $publish->save();
                }
            }
        }
    }


    /**
     * こちらで選択する画面
     */
    public function editAction()
    {

        $this->reportDuplicationProcess();
        $this->view->accountFields = ['check' => '反映',
                          'name' => '名前',
                          'phone_number' => '電話番号',
                          'postcode' => '郵便番号',
                          'address' => '住所'];
        $this->view->reviewFields = ['check' => '反映',
                                     'comment' => 'コメント'];
        $urlParam = ['report_id' => $this->view->report->id,
                   'product_id' => $this->view->product->id];
        $this->view->footerButton = $this->getButtonHtmlFromTool('公開ページへ', '/report/detail', $urlParam);
    }

    /**
     * お客さんに見せる画面
     */
    public function detailAction()
    {
        $this->reportDuplicationProcess();
        $this->view->accountFields = ['name' => '名前',
                          'phone_number' => '電話番号',
                          'postcode' => '郵便番号',
                          'address' => '住所'];
        $this->view->reviewFields = ['comment' => 'コメント'];

        $urlParam = ['report_id' => $this->view->report->id,
                   'product_id' => $this->view->product->id];
        $this->view->footerButton = $this->getButtonHtmlFromTool(Label::TO_EDIT, '/report/edit', $urlParam);



        // メール送信用フォーム部分
        $customer = Customer::findFirst($this->view->product->customer_id);
        $mailSendBody = '<form action="/mail/send" method="POST">';
        $mailSendBody .= sprintf('送信先 : <input type="text" name="send_to" value="%s" size="140"/><br/>', $customer->mail);
        $mailTitle = MessageCollection::findFirstByLabelAndSubKey(MessageCollection::ORDER_MAIL_TITLE, $this->view->product->type);
        $mailSendBody .= sprintf('TITLE : <input type="text" name="mail_title" value="%s" size="140"/><br/>', $mailTitle->view_text);
        $mailBody = MessageCollection::findFirstByLabelAndSubKey(MessageCollection::ORDER_MAIL_BODY, $this->view->product->type);
        $mailSendBody .= sprintf('<textarea rows="40" cols="150" name="mail_body">%s</textarea>', $mailBody->txt);
        $urlParam = ['report_id' => $this->view->report->id,
                     'product_id' => $this->view->product->id];
        $mailSendBody .= '<div class="spacer20"></div>';
        $mailSendBody .= sprintf('<button type="submit" class="btn btn-primary">%s</button>', Label::SEND_MAIL);
        $mailSendBody .= '</form>';
        $this->view->mailSendBody = $mailSendBody;
    }

    /**
     * edit, detailの共通処理
     */
    private function reportDuplicationProcess()
    {
        $req = $this->request;
        $productId = $req->get('product_id');
        $reportId = $req->get('report_id');

        $product = Product::findFirstByIdStrict($productId);
        $report = ReportSegment::findFirstByIdStrict($reportId);

        if ($req->isPost()) {
            $posts = $req->getPost();
            $this->createNewReportPublish($reportId, $productId, $posts);
        }

        $reportBeginDate = new GDate($report->begin_date);
        $reportEndDate = new GDate($report->end_date);

        $customer = Customer::findFirst($product->customer_id);

        $reportHeaderMessage = MessageCollection::findFirstByLabelAndSubKey(MessageCollection::REPORT_HEADER, $product->type);

        $panelStatSets = [['headline' => $customer->name.' : '.$product->name,
                           'body' => $reportHeaderMessage->getViewText()],
                          ['headline' => '集計期間',
                           'body' => $reportBeginDate->d2s().' 〜 '.$reportEndDate->d2s()]
        ];
        $panelSendSets = [];
        foreach ($product->getReferences() as $reference => $referenceModels) {
            foreach ($referenceModels as $model) {
                if ($report->filterReferenceModel($model)) {
                    $panelStatSets[$reference] = $model->getToolPanelStatSet();
                    $panelSendSets[$reference] = $model->getToolPanelSendSet();
                }
            }
        }
        $this->view->report = $report;
        $this->view->panelStatSets = $panelStatSets;
        $this->view->panelSendSets = $panelSendSets;
        $this->view->product = $product;

        $this->view->publishData = ReportPublishList::getToolPublishHash($reportId, $product->id);
        $this->view->reviewSet = UProductReview::findToolReportByProductId($product->id);
    }

    /**
     * ボタン用のHTMLを作成
     * @param string $label
     * @param string $url
     * @param array $params
     * @return string
     */
    private function getButtonHtmlFromTool($label, $url, $params = [])
    {
        if (!empty($params)) {
            $url .= '?'.http_build_query($params);
        }
        return sprintf("<input type=\"button\" value=\"%s\" onClick=\"location.href='%s'\" class=\"btn btn-primary btn-lg pull-right\">", $label, $url);
    }
}
