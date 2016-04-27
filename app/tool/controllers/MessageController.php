<?php
/**
 *  MessageControllerクラス
 *  画面に表示するテキストの管理
 */
namespace Treasure\Tool\Controllers;

use \Treasure\Models\Model\MessageCollection;
use \Api\Models\Tool\Label;
use \Api\Models\Validator;
use \Api\Models\Paginator;
use \Phalcon\Mvc\View;
use \Gcl\Util\GDate;

class MessageController extends \Treasure\Tool\Controllers\AbstractController
{
    /**
     * メッセージ一覧
     */
    public function indexAction()
    {
        $model = MessageCollection::query();
        $this->view->paginator = $this->returnPaginatorByModel($model, $this->request, [], 100);

        $this->view->fields = ['tool_label' => '利用箇所',
                               'tool_subkey' => '補助タイプ',
                               'view_text' => '本文',
                               'tool_edit_button' => '編集'
                               ];
    }

    /**
     * 編集
     */
    public function editAction()
    {
        $req = $this->request;
        $id = $req->get('id');
        $message = MessageCollection::findFirstByIdStrict($id);
        $config = new \Api\Models\Tool\Config('message_collection');
        $errorMessages = []; // POST時のエラーメッセージがあれば保存
        if ($req->isPost()) {
            $addData = $message->addFirstData($req->getPost(), $config);
            if (! $addData) {
                $errorMessages = Validator::changeMassagesToHash($message->getMessages());
            } else {
                $message->save();
                $this->view->flash = Label::MESSAGE_UPDATED;
            }
        }
        $this->view->editModel = $message;
        $this->view->form = new \Treasure\Forms\Model\MessageCollection();
        $this->view->modelName = 'message_collection';
        $this->view->hiddenColumn = ['id','label','sub_key'];
        $this->view->unnecessaryColumn = [];
        $this->view->config = $config;
        $this->view->errorMessages = $errorMessages;
    }
}
