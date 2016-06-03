<?php
namespace Lapi\V1\Controllers;

use \Lapi\Models\Model\Like as Like;
use \Lapi\Response\Like as RLike;
use \Api\Models\Validator;
use \Lapi\Models\Model\Localinfo;

class LikeController extends \Lapi\V1\Controllers\GetUserController
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
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $response = $this->checkPositiveInteger($localinfoId);
        if ($response !== true) {
            return $response;
        }

        // 引数に問題がなければ検索
        $params['conditions'] = ['localinfo_id' => $localinfoId];
        $likeModel = Like::getInstance();
        $likes = $likeModel->findStatusValid($params);
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
        $likeModel = Like::getInstance();
        $likes = $likeModel->findStatusValid($params);
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
        $this->db->begin();

        $like = new Like();
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $like->initializeByFirst($localinfoId);
        $result = $this->getCreateResult($like);
        if ($result instanceof \Gpl\Http\Response) {
            $this->db->rollback();
            return;
        }

        // お宝に紐づくいいね数を増やす
        $localinfoModel = Localinfo::getInstance();
        $localinfo = $localinfoModel->findFirstById($localinfoId);
        if ($localinfo instanceof Localinfo) {
            $localinfo->addLikeCount();
            if ($localinfo->update() == false) {
                $this->db->rollback();
                return;
            }
        }

        $this->db->commit();

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
     * @param \ULocalinfoLike $like
     * @return array
     */
    private function getCreateResult($like)
    {
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $response = $this->checkPositiveInteger($localinfoId);
        if ($response !== true) {
            return $response;
        }

        $accountId = $this->account['account_id'];
        $createParams = ['localinfo_id' => $localinfoId, 'account_id' => $accountId];

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
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $response = $this->checkPositiveInteger($localinfoId);
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
            // お宝に紐づくいいね数を減らす
            $localinfoModel = Localinfo::getInstance();
            $localinfo = $localinfoModel->findFirstById($localinfoId);
            if ($localinfo instanceof Localinfo) {
                $localinfo->removeLikeCount();
                if ($localinfo->update() == false) {
                    $this->db->rollback();
                    return;
                }
            }

            $result['success'] = true;
        } else {
            $result['success'] = false;
        }
        return $this->responseValidStatus($result);
    }
}
