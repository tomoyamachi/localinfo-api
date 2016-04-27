<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Api\Models\Tool\Label;

/**
 * CustomerMember
 */
class CustomerMember extends \Treasure\Models\Model\UserAbstract
{
    const AUTHORITY_ADMIN = 'admin'; //管理者
    const AUTHORITY_CUSTOMER = 'customer'; //顧客
    const AUTHORITY_EMPLOYEE = 'employee'; //バイト
    const CALL_CUSTOMER_ID = 1; //自社のIDを指定

    protected static $defaultData = [
                                     'id' => null,
                                     'authority' => 'メンバー',
                                     'name' => null,
                                     'name_kana' => null,
                                     'position' => '代表者',
                                     'phone_number' => null,
                                     'mail' => null,
                                     'password' => null,
                                     'memo' => null,
                                     ];
    public function initializeByFirst($customerId)
    {
        $this->set('customer_id', $customerId);
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            $this->set($column, $default);
        }
    }

    /**
     * 管理者かどうか
     * @return boolean
     */
    public function isAdmin()
    {
        return ($this->authority === self::AUTHORITY_ADMIN);
    }

    /**
     * メールか電話からアドレスを返す
     * @param string $mail
     * @param string $password
     * @return mixed
     */
    public static function getMemberMailAndPassword($mail, $password)
    {
        // TODO : とりあえずパスワードの暗号化はしない
        $conditions = ['mail' => $mail, 'password' => $password];
        return self::findFirstByParams(['conditions' => $conditions]);
    }

    /**
     * 編集ページへのリンク
     * @return string
     */
    public function getToolEditDataButton()
    {
        $urlParam = ['customer_id' => $this->customer_id];
        $label = Label::CREATE;

        if (property_exists($this, 'id') && $this->id) {
            $label = Label::EDIT;
            $urlParam['member_id'] = $this->id;
        }

        return $this->getButtonHtmlFromTool($label, '/member/edit', $urlParam);
    }

    /**
     * 電話をかける人をセレクトフォームとして表示させる
     */
    public static function getToolCallMemberSelectForm($formName, $memberId = '')
    {
        $parameter = ['conditions' => ['customer_id' => self::CALL_CUSTOMER_ID]];
        $html = sprintf('<SELECT name="%s">', $formName);
        foreach (self::findByParams($parameter) as $member) {
            $selected = ($member->id == $memberId) ? 'selected': '';
            $html .= sprintf('<option value="%s" %s>%s</option>', $member->id, $selected, $member->name);
        }
        return $html.'</SELECT>';
    }
}
