<?php
/**
 * Papi\Forms\Model
 */
namespace Papi\Forms\Model;

use \Papi\Models\Model\ProductReferenceAbstract as Reference;

/**
 * ProductAchievement
 */
class ProductAchievement extends \Papi\Forms\Model\Base\ProductAchievement
{
    /**
     * configureStatus
     */
    public function configureStatus($allowed = ['pending' => 1])
    {
        $statusLabel = [];
        foreach (Reference::$statusLabel as $status => $label) {
            if (isset($allowed[$status])) {
                $statusLabel[$status] = $label;
            }
        }
        $params = array(
                        'name' => 'status',
                        'options' => $statusLabel
        );
        $formType = \Gpl\Forms\ElementFactory::TYPE_SELECT;
        return $this->configureElement($params, $formType);
    }

    /**
     * initialize
     */
    public function initialize()
    {
        $this->setupDefault();
    }
}
