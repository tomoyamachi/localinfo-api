<?php
/**
 * Treasure\Forms\Model
 */
namespace Treasure\Forms\Model;

/**
 * CustomerMember
 */
class CustomerMember extends \Treasure\Forms\Model\Base\CustomerMember
{

    public function configureAuthority()
    {
        $params = array(
                        'name' => 'authority',
                        'options' => ['customer' => '顧客', 'employee' => '社内バイト', 'admin' => 'サイト管理者']
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
