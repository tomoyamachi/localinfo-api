<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Treasure\Models\Model\ProductAchievement;

/**
 * UAchievement
 *
 * @SuppressWarnings(PHPMD)
 */
class UAchievement extends \Treasure\Models\Model\UProductAbstract
{

    const STATUS_INIT = 'init';
    const STATUS_VALID = 'valid';

    // ShipManagementのreference_typeカラムと同じproperty名で取得できるようcamelcaseにしている
    protected $reference_type = 'achievement';
    protected $productIdCache = false;

    /**
     * すでに登録済みか確認
     * @param int $productAchievementId
     * @param int $accountId
     * @return boolean
     */
    public static function isRegistered($productAchievementId, $accountId)
    {
        $conditions = ['product_achievement_id' => $productAchievementId, 'account_id' => $accountId];
        $result = self::findFirstByParams(['conditions' => $conditions]);
        return ($result instanceof self);
    }

    /**
     * 登録する
     * @param int $productAchievementId
     * @param int $accountId
     * @return boolean
     */
    public static function register($productAchievementId, $accountId)
    {
        $uachievement = new self();
        $uachievement->set('account_id', $accountId);
        $uachievement->set('status', self::STATUS_INIT);
        $uachievement->set('product_achievement_id', $productAchievementId);
        return $uachievement->save();
    }

    /**
     * 対象のproduct_achievement_idですでに応募済みの個数を返す
     * @param int $productAchievementId
     * @return int
     */
    public static function getCountTargetAchievementId($productAchievementId)
    {
        $conditions = ['product_achievement_id' => $productAchievementId];
        $result = self::findFirstByParams(['conditions' => $conditions,
                                           'columns' => ['count' => 'count(*)']]);
        if ($result) {
            return $result->count;
        }
        return 0;
    }
}
