<?php
namespace Papi\Models\Model;

/**
 * ユーザーが作成するデータ
 */
class UserAbstract extends \Api\Models\ModelAbstract
{
    protected $config = ['storage' => 'Memcached',
                      'servers' => [['localhost', 11211, 10]]];

    public static function __callStatic($method, $arguments = null)
    {
        return parent::__callStatic($method, $arguments);
    }

    /**
     * Update時の事前実行
     */
    public function beforeUpdate()
    {
        $date = new \Gcl\Util\GDate(time());
        $this->updated_at = $date->now();
    }


    /**
     * Insert時の事前実行
     */
    public function beforeCreate()
    {
        $date = new \Gcl\Util\GDate(time());
        $this->updated_at = $date->now();
        $this->created_at = $date->now();
    }

    // {{{ public function afterCreate( )
    /**
     * Insert後
     */
    public function afterCreate()
    {
        $cache = $this->getCacheManager();
        $key = $this->getCacheKey($this->id);
        $cache->setCache($key, $this);
    }
    // }}}

    // {{{ public function afterUpdate( )
    /**
     * 更新後の事後実行
     */
    public function afterUpdate()
    {
        $cache = $this->getCacheManager();
        $key = $this->getCacheKey($this->id);
        $cache->deleteCache($key);
    }
    // }}}

    // {{{ public function addFirstData( )
    /**
     * 名前などの入力
     * @param  array $postData
     * @param array $config
     * @return boolean 成功/失敗
     */
    public function addFirstData($postData, $config)
    {
        $from = 'form';
        return \Api\Models\Validator::setAndValidatePostData($this, $postData, $config, $from);
    }
    // }}}
}
