<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Treasure\Models\Model\UAchievement;
use \Treasure\Models\ApiConnector;

/**
 * ProductAchievement
 */
class ProductAchievement extends \Treasure\Models\Model\ProductReferenceAbstract
{
    protected $referenceLabel = 'achievement';
    protected static $defaultData = ['id' => null,
                            'status' => parent::STATUS_VALID_NEW,
                            'product_delivery_rate_group_id' => null,
                            'point' => null,
                            'total_limit' => null,
                            'personal_limit' => 1,
                            'begin_date' => 'now',
                            'end_date' => 'now',
                            ];

    protected $toolColumnLabels = [
                         'tool_start_end_date_visible' => '表示期間',
                         'label_by_status' => '状態',
                         'tool_delivery_ratio' => '配信比率',
                         'tool_current_conversion_degree' => '進捗',
                         ];

    /**
     * 賞品に応募
     * @param void
     * @return boolean
     */
    public function register($accountId)
    {
        // 自分がすでに当選していないか確認
        if (UAchievement::isRegistered($this->id, $accountId)) {
            return false;
        }

        // 住所登録済みで、応募条件を満たしている
        if (ApiConnector::canRegister($accountId) === false) {
            return false;
        }

        // アカウントAPIに対して、ポイントを消費する処理
        if (ApiConnector::consumePoint($accountId, $this->point) === false) {
            return false;
        }

        // 成功すれば、応募完了状態にする
        if (UAchievement::register($this->id, $accountId) === false) {
            return false;
        }

        // 応募完了したら、完了ステータスを返す
        return true;
    }



    /**
     * 保証しているPV数とそうではないPV数の進捗を確認
     * @return string
     */
    public function getToolCurrentConversionDegree()
    {
        $currentUsed = UAchievement::getCountTargetAchievementId($this->id);
        $rate = floor(($currentUsed * 100)/$this->total_limit);
        return sprintf('%d / %d 個消費 (%d%%)', $currentUsed, $this->total_limit, $rate);
    }

    public function getToolPanelSendSet()
    {
        $conditions = ['product_achievement_id' => $this->id];
        $users = UAchievement::findByParams(['conditions' => $conditions]);
        $userDatas = ApiConnector::getToolSendSet($users);
        return $userDatas;
    }
}
