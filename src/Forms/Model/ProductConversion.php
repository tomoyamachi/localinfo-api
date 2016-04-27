<?php
/**
 * Papi\Forms\Model
 */
namespace Papi\Forms\Model;

use \Papi\Models\Model\ProductReferenceAbstract as Reference;

/**
 * ProductConversion
 */
class ProductConversion extends \Papi\Forms\Model\Base\ProductConversion
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

    public function configureType()
    {
        $params = array(
                        'name' => 'type',
                        'options' => ['pv' => 'ページビュー', 'tag' => 'コンバージョンタグ'],
        );
        $formType = \Gpl\Forms\ElementFactory::TYPE_SELECT;
        return $this->configureElement($params, $formType);
    }

    public function configureBeginDate()
    {
        $params = array(
                        'name' => 'begin_date',
        );
        $formType = \Gpl\Forms\ElementFactory::TYPE_DATE;
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
