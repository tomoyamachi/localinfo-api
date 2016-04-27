<?php
/**
 * Papi\Forms\Model
 */
namespace Papi\Forms\Model;

use \Papi\Models\Model\Customer as MCustomer;

/**
 * Customer
 */
class Customer extends \Papi\Forms\Model\Base\Customer
{

    public function configureDocsMailDate()
    {
        $params = array(
                        'name' => 'docs_mail_date',
                        'options' => [0 => '未送信', '2016-1-1' => '送信済み']
        );
        $formType = \Gpl\Forms\ElementFactory::TYPE_SELECT;
        return $this->configureElement($params, $formType);
    }

    public function configureStatus()
    {
        $params = array(
                        'name' => 'status',
                        'options' => MCustomer::$editStatusLabel
        );
        $formType = \Gpl\Forms\ElementFactory::TYPE_SELECT;
        return $this->configureElement($params, $formType);
    }

    public function configureDocsPostDate()
    {
        $params = array('name' => 'docs_post_date',
                        'options' => [0 => '未送信', '2016-1-1' => '送信済み']
        );
        $formType = \Gpl\Forms\ElementFactory::TYPE_SELECT;
        return $this->configureElement($params, $formType);
    }

    public function configureDocsFaxDate()
    {
        $params = array(
                        'name' => 'docs_fax_date',
                        'options' => [0 => '未送信', '2016-1-1' => '送信済み']
        );
        $formType = \Gpl\Forms\ElementFactory::TYPE_SELECT;
        return $this->configureElement($params, $formType);
    }

    public function configureProhibitCall()
    {
        $params = array(
                        'name' => 'prohibit_call',
                        'options' => [0 => '許可', 1 => '禁止']
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
