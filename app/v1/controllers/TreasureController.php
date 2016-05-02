<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\Treasure;
use \Treasure\Response\Treasure as RTreasure;
use \Api\Models\Validator;

class TreasureController extends \Treasure\V1\Controllers\GetUserController
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
        $treasureModel = Treasure::getInstance();
        $treasures = $treasureModel->findStatusValid($params);


        $result = RTreasure::getMultipleContent($treasures);
        $params['result'] = $result;
        $params['count'] = count($treasures);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $treasureModel->getTotalStatusValid($params);
        }

        return $this->responseValidStatus($params);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $treasureId = $this->dispatcher->getParam('treasure_id');
        $response = $this->checkPositiveInteger($treasureId);
        if ($response !== true) {
            return;
        }


        try {
            $treasureModel = Treasure::getInstance();
            $treasure = $treasureModel->findFirstById($treasureId);
            $result = RTreasure::getcontent($treasure);
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
        $treasureModel = Treasure::getInstance();
        $params['conditions'] = [$attribute.'_id' => $attributeId];
        $treasures = $treasureModel->findStatusValid($params);

        $result = RTreasure::getMultipleContent($treasures);
        $params['result'] = $result;
        $params['count'] = count($treasures);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $treasureModel->getTotalStatusValid($params);
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
        $treasure = new Treasure();
        $treasure->initializeByFirst();

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


        $result = $this->getCreateResult($treasure, $params);

        return $this->responseValidStatus($result);
    }

    /**
     * レビューを更新
     */
    public function updateAction()
    {
        $treasureId = $this->dispatcher->getParam('treasure_id');
        $response = $this->checkPositiveInteger($treasureId);
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

        $treasure = Treasure::findFirstByIdStrict($treasureId);

        if (! $treasure instanceof Treasure) {
            return $this->responseParameterError('指定されたレビューが見つかりません');
        }

        if ($treasure->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        $result = $this->getCreateResult($treasure, $params);
        return $this->responseValidStatus($result);
    }

    /**
     * create, updateの共通部分
     * @param \UProductTreasure $treasure
     * @param array $params
     * @return array
     */
    private function getCreateResult($treasure, $params)
    {
        $accountId = $this->account['account_id'];
        $params['account_id'] = $accountId;

        $config = new \Api\Models\Tool\Config('treasure');
        $addData = $treasure->addFirstData($params, $config);

        /* 更新成功してもしなくてもHTTPステータスは200で、successのステータスが変わる */
        $result = [];
        if ($addData === false) {
            $errorMessages = Validator::changeMassagesToHash($treasure->getMessages());
            $result['success'] = false;
            $result['message'] = $errorMessages;
        } else {
            $treasure->save();
            $result = RTreasure::getContent($treasure);
            $result['success'] = true;
        }

        return $result;
    }


    /**
     * 物理削除する
     */
    public function deleteAction()
    {
        $treasureId = $this->dispatcher->getParam('treasure_id');
        $response = $this->checkPositiveInteger($treasureId);
        if ($response !== true) {
            return;
        }

        $treasure = Treasure::findFirstByIdStrict($treasureId);

        if ($treasure->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        if ($treasure->delete()) {
            $result['success'] = true;
        } else {
            $result['success'] = false;
        }
        return $this->responseValidStatus($result);
    }
}
