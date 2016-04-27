<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\ProductAchievement as Achievement;
use \Treasure\Response\Achievement as RAchievement;

class AchievementController extends \Treasure\V1\Controllers\GetUserController
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

        // 引数に問題がなければ検索
        $achievements = Achievement::find($params);
        $result = RAchievement::getMultipleContent($achievements);
        return $this->responseValidStatus($result);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $achievementId = $this->dispatcher->getParam('achievement_id');
        $response = $this->checkPositiveInteger($achievementId);
        if ($response !== true) {
            return;
        }

        try {
            $achievement = Achievement::findFirst($achievementId);
            $result = RAchievement::getContent($achievement);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }

    /**
     * 応募
     */
    public function registAction()
    {
        $achievementId = $this->dispatcher->getParam('achievement_id');
        $response = $this->checkPositiveInteger($achievementId);
        if ($response !== true) {
            return;
        }

        $achievement = Achievement::findFirst($achievementId);
        $success = $achievement->register($this->account['account_id']);

        $result = RAchievement::getContent($achievement);
        $result['success'] = $success;
        return $this->responseValidStatus($result);
    }
}
