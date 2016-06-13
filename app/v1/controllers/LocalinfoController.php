<?php
namespace Lapi\V1\Controllers;

use \Lapi\Models\Model\Localinfo;
use \Lapi\Models\Model\LocalinfoImage;
use \Lapi\Response\Localinfo as RLocalinfo;
use \Api\Models\Validator;

class LocalinfoController extends \Lapi\V1\Controllers\GetUserController
{

    protected $withoutAccountActions = ['get' => 1, 'getTarget' => 1, 'getTargetUsers' => 1, 'getTargetPrefectures' => 1, 'getTargetAreas' => 1];

    /**
     * 全データを返却
     */
    public function getAction()
    {
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        // 引数に問題がなければ検索
        $localinfoModel = Localinfo::getInstance();
        $localinfos = $localinfoModel->findStatusValid($params);
        // 欲しいFieldを取得
        $fields = [];
        $fieldTexts = $this->request->get('fields');
        if ($fieldTexts) {
            $fields = explode(',', $fieldTexts);
        }

        $result = RLocalinfo::getMultipleContent($localinfos, $fields);
        $params['result'] = $result;
        $params['count'] = count($localinfos);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $localinfoModel->getTotalStatusValid($params);
        }

        return $this->responseValidStatus($params);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        if (ctype_digit($localinfoId)) {
            $this->checkPositiveInteger($localinfoId);
        }
        try {
            $condition = ['id' => $localinfoId];
            $localinfo = Localinfo::findFirstByParams(['conditions' => $condition]);
            $result = RLocalinfo::getcontent($localinfo);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }

    /**
     * 対象のアカウントのレビューを取得
     */
    public function getTargetUsersAction()
    {

        return $this->getTargetAttributes('account');
    }


    /**
     * 対象の県のレビューを取得
     */
    public function getTargetPrefecturesAction()
    {
        return $this->getTargetAttributes('prefecture');
    }


    /**
     * 対象の県のレビューを取得
     */
    public function getTargetAreasAction()
    {
        return $this->getTargetAttributes('area');
    }


    /**
     * フィルタリング
     * @param  $attribute
     * @return Response
     */
    private function getTargetAttributes($attribute)
    {
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        // IDに問題がないか確認
        $attributeId = $this->dispatcher->getParam($attribute.'_id');
        $response = $this->checkPositiveInteger($attributeId);
        if ($response !== true) {
            return $response;
        }

        // 引数に問題がなければ検索
        $localinfoModel = Localinfo::getInstance();
        $params['conditions'] = [$attribute.'_id' => $attributeId];
        $localinfos = $localinfoModel->findStatusValid($params);

        $result = RLocalinfo::getMultipleContent($localinfos);
        $params['result'] = $result;
        $params['count'] = count($localinfos);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $localinfoModel->getTotalStatusValid($params);
        }

        return $this->responseValidStatus($params);
    }

    /**
     * レビューを作成
     */
    public function createAction()
    {
        $required = ['title', 'comment', 'prefecture_id', 'area_id'];
        $this->checkRequired($required);

        /* レビューデータを作成 */
        $localinfo = new Localinfo();
        $localinfo->initializeByFirst();

        $params = [];
        foreach ($required as $key) {
            $params[$key] = $this->request->getPost($key);
        }

        $transaction = $this->transactionManager->get();
        $localinfo->setTransaction($transaction);

        $result = $this->getCreateResult($localinfo, $params, $transaction);

        return $this->responseValidStatus($result);
    }

    /**
     * レビューを更新
     */
    public function updateAction()
    {
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        if (ctype_digit($localinfoId)) {
            $this->checkPositiveInteger($localinfoId);
        }

        $required = ['title', 'comment', 'prefecture_id', 'area_id'];
        $params = [];
        foreach ($required as $key) {
            if ($this->request->getPut($key)) {
                $params[$key] = $this->request->getPut($key);
            }
        }

        $condition = ['id' => $localinfoId];
        $localinfo = Localinfo::findFirstByParams(['conditions' => $condition]);

        if (! $localinfo instanceof Localinfo) {
            return $this->responseParameterError('指定された情報が見つかりません');
        }

        if ($localinfo->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        $transaction = $this->transactionManager->get();
        $localinfo->setTransaction($transaction);

        $result = $this->getCreateResult($localinfo, $params, $transaction);
        return $this->responseValidStatus($result);
    }

    /**
     * create, updateの共通部分
     * @param \UProductLocalinfo $localinfo
     * @param array $params
     * @return array
     */
    private function getCreateResult($localinfo, $params, $transaction)
    {
        $accountId = $this->account['account_id'];
        $params['account_id'] = $accountId;

        $config = new \Api\Models\Tool\Config('localinfo');

        $addData = $localinfo->addFirstData($params, $config);

        /* 更新成功してもしなくてもHTTPステータスは200で、successのステータスが変わる */
        $result = [];
        if ($addData === false) {
            $errorMessages = Validator::changeMassagesToHash($localinfo->getMessages());
            $result['success'] = false;
            $result['message'] = $errorMessages;
        } else {
            if ($localinfo->save() == false)  {
                $transaction->rollback("Cannot save");
            }

            //アップロードされるファイルがあるか確認し、あれば適切な場所に移動。
            if ($this->request->hasFiles() == true) {

                // ssh通信を開始
                $uploader = new \Lapi\Models\FileUploader();
                foreach ($this->request->getUploadedFiles() as $file) {
                    $image = LocalinfoImage::createDataFromPostFile($localinfo, $file, $uploader, $transaction,  $this->account['account_id']);
                    // postのフィールド名がmainだったら、それをmain画像に指定
                    if ($image && ($file->getKey() === 'main')) {
                        $localinfo->set('main_image_id', $image->id);
                    }
                }
                $localinfo->save();
            }
            $transaction->commit();

            $result = RLocalinfo::getContent($localinfo);
            $result['success'] = true;
        }

        return $result;
    }


    /**
     * 物理削除する
     */
    public function deleteAction()
    {
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $response = $this->checkPositiveInteger($localinfoId);
        if ($response !== true) {
            return;
        }

        $condition = ['id' => $localinfoId];
        $localinfo = Localinfo::findFirstByParams(['conditions' => $condition]);

        if ($localinfo->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        if ($localinfo->delete()) {
            $result['success'] = true;
        } else {
            $result['success'] = false;
        }
        return $this->responseValidStatus($result);
    }
}
