<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\Like as Like;
use \Treasure\Response\Like as RLike;
use \Api\Models\Validator;

class LikeController extends \Treasure\V1\Controllers\GetUserController
{
    protected $withoutAccountActions = ['get' => 1, 'getTarget' => 1, 'getTargetUsers' => 1];

    /**
     * 全データを返却
     */
    public function getAction()
    {
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        // IDに問題がないか確認
        $treasureId = $this->dispatcher->getParam('treasure_id');
        $response = $this->checkPositiveInteger($treasureId);
        if ($response !== true) {
            return $response;
        }

        // 引数に問題がなければ検索
        $params['conditions'] = ['treasure_id' => $treasureId];
        $likes = Like::findByParams($params);
        $result = RLike::getMultipleContent($likes);

        $params['result'] = $result;
        $params['count'] = count($likes);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $likeModel->getTotalStatusValid($params);
        }

        return $this->responseValidStatus($params);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $likeId = $this->dispatcher->getParam('like_id');
        $response = $this->checkPositiveInteger($likeId);
        if ($response !== true) {
            return;
        }

        try {
            $like = Like::findFirst($likeId);
            $result = RLike::getContent($like);
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
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        // idに問題がないか確認
        $accountId = $this->dispatcher->getParam('account_id');
        $response = $this->checkPositiveInteger($accountId);
        if ($response !== true) {
            return $response;
        }

        // 引数に問題がなければ検索
        $params['conditions'] = ['account_id' => $accountId];
        $likes = Like::findByParams($params);
        $result = RLike::getMultipleContent($likes);

        $params['result'] = $result;
        $params['count'] = count($likes);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $likeModel->getTotalStatusValid($params);
        }

        return $this->responseValidStatus($params);
    }

    /**
     * レビューを作成
     */
    public function createAction()
    {
        /* レビューデータを作成 */
        $like = new Like();
        $treasureId = $this->dispatcher->getParam('treasure_id');
        $like->initializeByFirst($treasureId);
        $result = $this->getCreateResult($like);
        if ($result instanceof \Gpl\Http\Response) {
            return;
        }

        return $this->responseValidStatus($result);
    }

    /**
     * レビューを更新
     */
    public function updateAction()
    {
        $likeId = $this->dispatcher->getParam('like_id');
        $response = $this->checkPositiveInteger($likeId);
        if ($response !== true) {
            return;
        }
        $like = Like::findFirstByIdStrict($likeId);

        if (! $like instanceof Like) {
            return $this->responseParameterError('指定されたコメントが見つかりません');
        }

        // accountIdが作成者と同じか確認する
        if ($like->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        $result = $this->getCreateResult($like);
        return $this->responseValidStatus($result);
    }

    /**
     * create, updateの共通部分
     * @param \UTreasureLike $like
     * @return array
     */
    private function getCreateResult($like)
    {
        $treasureId = $this->dispatcher->getParam('treasure_id');
        $response = $this->checkPositiveInteger($treasureId);
        if ($response !== true) {
            return $response;
        }

        $accountId = $this->account['account_id'];
        $createParams = ['treasure_id' => $treasureId, 'account_id' => $accountId];

        $config = new \Api\Models\Tool\Config('like');
        $addData = $like->addFirstData($createParams, $config);

        /* 更新成功してもしなくてもHTTPステータスは200で、successのステータスが変わる */
        $result = [];
        if ($addData === false) {
            $errorMessages = Validator::changeMassagesToHash($like->getMessages());
            $result['success'] = false;
            $result['message'] = $errorMessages;
        } else {
            $like->save();
            $result = RLike::getContent($like);
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
            return $response;
        }

        $likeId = $this->dispatcher->getParam('like_id');
        $response = $this->checkPositiveInteger($likeId);
        if ($response !== true) {
            return;
        }
        $like = Like::findFirstByIdStrict($likeId);


        if ($like->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        if ($like->delete()) {
            $result['success'] = true;
        } else {
            $result['success'] = false;
        }
        return $this->responseValidStatus($result);
    }
}
