<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Gcl\Util\GArray;
use \Api\Models\Tool\Label;

/**
 * MessageCollection
 */
class MessageCollection extends \Treasure\Models\Model\UserAbstract
{
    const BEFORE_SEND = 'before_send';
    const AFTER_SEND = 'after_send';
    const REPORT_HEADER = 'report_header';
    const ORDER_MAIL_TITLE = 'order_mail_title';
    const ORDER_MAIL_BODY = 'order_mail_body';

    public $labelMaps = [
                            'bofore_send' => '配送前状態',
                            'after_send' => '配送済み状態',
                            'report_header' => 'レポートページの上部文言',
                            'recall_mail_title' => '再コールお知らせメールタイトル',
                            'recall_mail_body' => '再コールお知らせメール本文',
                            'order_mail_title' => '注文確定メールタイトル',
                            'order_mail_body' => '注文確定メール本文',
                            ];

    public $subKeyMaps = [
                          'default' => '基本',
                          'food' => '食品',
                          'hotel' => '宿泊'
                          ];

    /**
     * Labelとsubkeyの組み合わせがなければ、defaultのものを取得
     * @param string $label
     * @param mixed $subKey
     * @return resultset
     */
    public static function findFirstByLabelAndSubKey($label, $subKey = '')
    {
        if (!empty($subKey)) {
            $conditions = ['label' => $label, 'sub_key' => $subKey];
            $result = self::findFirstByParams(['conditions' => $conditions]);
            if ($result instanceof self) {
                return $result;
            }
        }

        $conditions = ['label' => $label, 'sub_key' => 'default'];
        $result = self::findFirstByParams(['conditions' => $conditions]);
        return $result;
    }

    /**
     * 管理ツールに表示するためのラベル詳細を返す。
     * クラスで指定されていなければ、DBに登録されているデータを返す。
     * @return string
     */
    public function getToolLabel()
    {
        return GArray::get($this->labelMaps, $this->label, $this->label);
    }

    /**
     * 管理ツールに表示するためのラベル詳細を返す。
     * クラスで指定されていなければ、DBに登録されているデータを返す。
     * @return string
     */
    public function getToolSubkey()
    {
        return GArray::get($this->subKeyMaps, $this->sub_key, $this->sub_key);
    }

    /**
     * HTML表示用にタグを変換したりする
     * @return string
     */
    public function getViewText()
    {
        return nl2br($this->txt);
    }

    /**
     * 編集ページヘ
     * @return string
     */
    public function getToolEditButton()
    {
        $urlParam = ['id' => $this->id];
        return $this->getButtonHtmlFromTool(Label::EDIT, '/message/edit', $urlParam);
    }
}
