<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Treasure\Models\Model\CustomerMember;
use \Gcl\Util\GDate;

/**
 * SalesHistory
 */
class SalesHistory extends \Treasure\Models\Model\UserAbstract
{

    const RECALL_STATUS_INIT = 'init';
    const RECALL_STATUS_FINISH = 'finish';

    /**
     * 電話担当者の名前
     * @return string
     */
    public function getToolCallerName()
    {
        $member = CustomerMember::findFirst($this->sales_member_id);
        return $member->name;
    }


    /**
     * 再コール担当者の名前
     * @return string
     */
    public function getToolRecallerName()
    {
        $member = CustomerMember::findFirst($this->recall_member_id);
        return $member->name;
    }

    /**
     * コール日時
     * @return string
     */
    public function getToolDateVisible()
    {
        $date = new GDate($this->sales_date);
        return $date->d2selectForm('sales_history_call_date');
    }

    /**
     * コール日時
     * @return string
     */
    public function getToolFormBegin()
    {
        return '<form action="?customer_id='.$this->customer_id.'" method="POST">';
    }

    /**
     * コール日時
     * @return string
     */
    public function getToolFormEnd()
    {
        return '</form>';
    }

    /**
     * 再コール関連の処理
     * @return string
     */
    public function getToolRecallDateEdit()
    {
        if ($this->recall_status === self::RECALL_STATUS_FINISH) {
            return '再コール済みです';
        }

        if ($this->recall_status !== self::RECALL_STATUS_INIT) {
            return '再コールの予定はありません';
        }

        $date = new GDate($this->recall_date);
        $html = '<span style="color:red;">再コールされていません</span><br/>';
        $html .= '担当者 : ';
        $html .= CustomerMember::getToolCallMemberSelectForm('sales_history_recall_member_id', $this->recall_member_id);
        $html .= '<br/>';

        $html .= $date->d2selectForm('sales_history_recall_date');
        $html .= '<br/><input type="checkbox" name="sales_history_recall_status" value="finish">完了する';
        return $html;
    }

    /**
     * 詳細を編集できるように
     * @return string
     */
    public function getToolDetailEdit()
    {
        $html = sprintf('<input type="hidden" value="%d" name="customer_id">', $this->customer_id);
        $html = sprintf('<input type="hidden" value="%d" name="sales_history_id">', $this->id);
        $html .= sprintf('<input type="hidden" value="%d" name="sales_history_customer_id">', $this->customer_id);
        $html .= sprintf('<textarea name="%s" rows="4" cols="60">%s</textarea>', 'sales_history_detail', $this->detail);
        $html .= '<br/><button class="btn btn-default" type="submit">更新</button></form></td></tr>';
        return $html;
    }

    /**
     * 新しい営業履歴を入力するフォーム
     * @param int $customer_id
     * @return string
     */
    public static function getNewHistoryForm($customerId)
    {
        $html = '<div class="bgcolor-data"><table class="table table-bordered">';
        $html .= '<form action="?customer_id='.$customerId.'" method="POST">';
        $html .= '<tr><td><span style="font-weight:bold;">再コール</span></td><td>';

        $html .= '<input type="checkbox" name="sales_history_recall_status" value="init">する ';
        $date = new GDate(time());
        $html .=  $date->d2selectForm('sales_history_recall_date');

        $html .= '</td></tr>';

        $html .= '<tr><td><span style="font-weight:bold;">再コール担当者</span></td><td>';
        $html .= CustomerMember::getToolCallMemberSelectForm('sales_history_recall_member_id');
        $html .= '</td></tr>';

        $html .= '<tr><td><span style="font-weight:bold;">新規登録</span></td>';
        $html .= '<td>';
        $html .= sprintf('<input type="hidden" value="%d" name="sales_history_sales_type">', 'call');

        // 顧客データから新規作成するときは不要
        if ($customerId) {
            $html .= sprintf('<input type="hidden" value="%d" name="sales_history_customer_id">', $customerId);
        }

        $html .= sprintf('<input type="hidden" value="%s" name="sales_history_sales_date">', $date->d2s('hiddenform'));

        $html .= '<textarea name="sales_history_detail" rows="4" cols="60"></textarea><br/>';
        $html .= '<button class="btn btn-default" type="submit">作成</button>';
        $html .= '</td></tr></table>';
        $html .= '</form>';

        $html .= '</div><div class="spacer20"/>';
        return $html;
    }



    /**
     * 賞品に関連した企業を取得
     * @return \Company
     */
    public function getCustomer()
    {
        return Customer::findFIrstByIdStrict($this->customer_id);
    }
}
