<?php
namespace Lapi\V1\Controllers;

use \Lapi\Models\Model\Localinfo;
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
        $response = $this->checkPositiveInteger($localinfoId);
        if ($response !== true) {
            return;
        }


        try {
            $localinfoModel = Localinfo::getInstance();
            $localinfo = $localinfoModel->findFirstById($localinfoId);
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

        //アップロードされるファイルがあるか確認し、あれば適切な場所に移動。
        if ($this->request->hasFiles() == true) {
            $baseLocation = TOP_DIR.'/files/';
            foreach ($this->request->getUploadedFiles() as $file) {
                $path = sprintf(
                    '%s/%s_%s_%s',
                    $file->getKey(),
                    $this->account['account_id'],
                    time(),
                    $file->getName()
                );

                if ($file->moveTo($baseLocation . $path)) {
                    $params[$file->getKey()] = $path;
                }
            }
        }


        $result = $this->getCreateResult($localinfo, $params);

        return $this->responseValidStatus($result);
    }

    /**
     * レビューを更新
     */
    public function updateAction()
    {
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $response = $this->checkPositiveInteger($localinfoId);
        if ($response !== true) {
            return;
        }

        $required = ['title', 'comment', 'prefecture_id', 'area_id'];
        $params = [];
        foreach ($required as $key) {
            if ($this->request->getPut($key)) {
                $params[$key] = $this->request->getPut($key);
            }
        }

        $localinfo = Localinfo::findFirstByIdStrict($localinfoId);

        if (! $localinfo instanceof Localinfo) {
            return $this->responseParameterError('指定されたレビューが見つかりません');
        }

        if ($localinfo->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        $result = $this->getCreateResult($localinfo, $params);
        return $this->responseValidStatus($result);
    }

    /**
     * create, updateの共通部分
     * @param \UProductLocalinfo $localinfo
     * @param array $params
     * @return array
     */
    private function getCreateResult($localinfo, $params)
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
            $localinfo->save();
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

        $localinfo = Localinfo::findFirstByIdStrict($localinfoId);

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
