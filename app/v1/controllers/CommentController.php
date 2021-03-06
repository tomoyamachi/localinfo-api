<?php
namespace Lapi\V1\Controllers;

use \Lapi\Models\Model\Comment as Comment;
use \Lapi\Models\Model\Localinfo;
use \Lapi\Response\Comment as RComment;
use \Api\Models\Validator;

class CommentController extends \Lapi\V1\Controllers\GetUserController
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
        $commentModel = Comment::getInstance();
        $comments = $commentModel->findStatusValid($params);
        $result = RComment::getMultipleContent($comments);

        $params['result'] = $result;
        $params['count'] = count($comments);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $commentModel->getTotalStatusValid($params);
        }

        return $this->responseValidStatus($params);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $commentId = $this->dispatcher->getParam('comment_id');
        $response = $this->checkPositiveInteger($commentId);
        if ($response !== true) {
            return;
        }

        try {
            $comment = Comment::getInstance()->findFirstById($commentId);
            $result = RComment::getContent($comment);
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
        $commentModel = Comment::getInstance();
        $comments = $commentModel->findStatusValid($params);
        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $commentModel->getTotalStatusValid($params);
        }
        $result = RComment::getMultipleContent($comments);

        $params['result'] = $result;
        $params['count'] = count($comments);



        return $this->responseValidStatus($params);
    }

    /**
     * レビューを作成
     */
    public function createAction()
    {
        $required = ['comment'];
        $this->checkRequired($required);

        /* レビューデータを作成 */
        $this->db->begin();

        $comment = new Comment();
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $comment->initializeByFirst($localinfoId);
        $postCommentData = $this->request->getPost('comment');
        $result = $this->getCreateResult($comment, $postCommentData);
        if ($result instanceof \Gpl\Http\Response) {
            $this->db->rollback();
            return;
        }

        // お宝に紐づくコメント数を増やす
        $localinfoModel = Localinfo::getInstance();
        $localinfo = $localinfoModel->findFirstById($localinfoId);
        if ($localinfo instanceof Localinfo) {
            $localinfo->addCommentCount();
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
        $commentId = $this->dispatcher->getParam('comment_id');
        $response = $this->checkPositiveInteger($commentId);
        if ($response !== true) {
            return;
        }

        $postCommentData = $this->request->getPut('comment');
        $comment = Comment::getInstance()->findFirstById($commentId);

        if (! $comment instanceof Comment) {
            return $this->responseParameterError('指定されたコメントが見つかりません');
        }

        // accountIdが作成者と同じか確認する
        if ($comment->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        $result = $this->getCreateResult($comment, $postCommentData);
        return $this->responseValidStatus($result);
    }

    /**
     * create, updateの共通部分
     * @param \ULocalinfoComment $comment
     * @return array
     */
    private function getCreateResult($comment, $postCommentData)
    {
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $response = $this->checkPositiveInteger($localinfoId);
        if ($response !== true) {
            return $response;
        }

        $accountId = $this->account['account_id'];
        $createParams = ['localinfo_id' => $localinfoId, 'account_id' => $accountId, 'comment' => $postCommentData];

        $config = new \Api\Models\Tool\Config('comment');
        $addData = $comment->addFirstData($createParams, $config);

        /* 更新成功してもしなくてもHTTPステータスは200で、successのステータスが変わる */
        $result = [];
        if ($addData === false) {
            $errorMessages = Validator::changeMassagesToHash($comment->getMessages());
            $result['success'] = false;
            $result['message'] = $errorMessages;
        } else {
            $comment->save();
            $result = RComment::getContent($comment);
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

        $commentId = $this->dispatcher->getParam('comment_id');
        $response = $this->checkPositiveInteger($commentId);
        if ($response !== true) {
            return;
        }
        $comment = Comment::findFirstByIdStrict($commentId);


        if ($comment->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        $this->db->begin();

        if ($comment->delete()) {

            // お宝に紐づくコメント数を減らす
            $localinfoModel = Localinfo::getInstance();
            $localinfo = $localinfoModel->findFirstById($localinfoId);
            if ($localinfo instanceof Localinfo) {
                $localinfo->removeCommentCount();
                if ($localinfo->update() == false) {
                    $this->db->rollback();
                    return;
                }
            }

            $result['success'] = true;
            $this->db->commit();
        } else {
            $result['success'] = false;
        }
        return $this->responseValidStatus($result);
    }
}
