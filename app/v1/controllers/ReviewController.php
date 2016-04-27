<?php
namespace Papi\V1\Controllers;

use \Papi\Models\Model\UProductReview as Review;
use \Papi\Response\Review as RReview;
use \Api\Models\Validator;

class ReviewController extends \Papi\V1\Controllers\GetUserController
{
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
        $productId = $this->dispatcher->getParam('product_id');
        $response = $this->checkPositiveInteger($productId);
        if ($response !== true) {
            return $response;
        }

        // 引数に問題がなければ検索
        $params['conditions'] = ['product_id' => $productId];
        $reviews = Review::findByParams($params);
        $result = RReview::getMultipleContent($reviews);
        return $this->responseValidStatus($result);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $reviewId = $this->dispatcher->getParam('review_id');
        $response = $this->checkPositiveInteger($reviewId);
        if ($response !== true) {
            return;
        }

        try {
            $review = Review::findFirst($reviewId);
            $result = RReview::getContent($review);
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

        // IDに問題がないか確認
        $accountId = $this->dispatcher->getParam('account_id');
        $response = $this->checkPositiveInteger($accountId);
        if ($response !== true) {
            return $response;
        }

        // 引数に問題がなければ検索
        $params['conditions'] = ['account_id' => $accountId];
        $reviews = Review::findByParams($params);
        $result = RReview::getMultipleContent($reviews);
        return $this->responseValidStatus($result);
    }

    /**
     * レビューを作成
     */
    public function createAction()
    {
        $required = ['comment'];
        $this->checkRequired($required);

        /* レビューデータを作成 */
        $review = new Review();
        $comment = $this->request->getPost('comment');
        $result = $this->getCreateResult($review, $comment);
        return $this->responseValidStatus($result);
    }

    /**
     * レビューを更新
     */
    public function updateAction()
    {
        $reviewId = $this->dispatcher->getParam('review_id');
        $response = $this->checkPositiveInteger($reviewId);
        if ($response !== true) {
            return;
        }
        $comment = $this->request->getPut('comment');
        $review = Review::findFirstByIdStrict($reviewId);

        if (! $review instanceof Review) {
            return $this->responseParameterError('指定されたレビューが見つかりません');
        }

        // TODO : accountIdが作成者と同じか確認する
        if ($review->account_id != $this->account['account_id']) {
            return $this->responseAuthorizeError();
        }

        $result = $this->getCreateResult($review, $comment);
        return $this->responseValidStatus($result);
    }

    /**
     * create, updateの共通部分
     * @param \UProductReview $review
     * @return array
     */
    private function getCreateResult($review, $comment)
    {
        $productId = $this->dispatcher->getParam('product_id');
        $response = $this->checkPositiveInteger($productId);
        if ($response !== true) {
            return $response;
        }

        $accountId = $this->account['account_id'];
        $createParams = ['product_id' => $productId, 'account_id' => $accountId, 'comment' => $comment];

        $config = new \Api\Models\Tool\Config('u_product_review');
        $addData = $review->addFirstData($createParams, $config);

        /* 更新成功してもしなくてもHTTPステータスは200で、successのステータスが変わる */
        $result = [];
        if ($addData === false) {
            $errorMessages = Validator::changeMassagesToHash($review->getMessages());
            $result['success'] = false;
            $result['message'] = $errorMessages;
        } else {
            $review->save();
            $result = ['success' => true,
                       'id' => (int)$review->id,
                       'comment' => $review->comment];
        }

        return $result;
    }


    /**
     * 物理削除する
     */
    public function deleteAction()
    {
        $productId = $this->dispatcher->getParam('product_id');
        $response = $this->checkPositiveInteger($productId);
        if ($response !== true) {
            return $response;
        }

        $reviewId = $this->dispatcher->getParam('review_id');
        $response = $this->checkPositiveInteger($reviewId);
        if ($response !== true) {
            return;
        }
        $review = Review::findFirstByIdStrict($reviewId);

        if ($review->delete()) {
            $result['success'] = true;
        } else {
            $result['success'] = false;
        }
        return $this->responseValidStatus($result);
    }
}
