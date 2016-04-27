<?php
/**
 * Treasure\Forms\Model
 */
namespace Treasure\Forms\Model;

use \Treasure\Models\Model\Product as MProduct;

/**
 * Product
 */
class Product extends \Treasure\Forms\Model\Base\Product
{
    /**
     * configureStatus
     */
    public function configureStatus($allowed = ['pending' => 1])
    {

        $statusLabel = [];
        foreach (MProduct::$statusLabel as $status => $label) {
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
     * configureType
     */
    public function configureType()
    {
        $params = array(
                        'name' => 'type',
                        'options' => MProduct::$typeLabel
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

    /**
     * カスタマー用のフォームを用意する
     */
    public function getCustomer()
    {
        return new Customer();
    }
}
