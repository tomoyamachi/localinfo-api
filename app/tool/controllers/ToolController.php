<?php
namespace Treasure\Tool\Controllers;

class ToolController extends \Treasure\Tool\Controllers\AbstractController
{
    public function indexAction()
    {
        $tables = \Api\Models\Tool\Config::getDatabase();
        $tableDatas = [];
        foreach ($tables as $table) {
            $tableName = $table[0];
            $tableDatas[$tableName] = new \Api\Models\Tool\Config($tableName);
        }
        $this->view->tables = $tableDatas;
    }

    // {{{ public function schemaAction( )
    /**
     * 記事の詳細ページ
     * @param void
     * @return void
     */
    public function schemaAction()
    {
        $req = $this->request;
        $table = $req->get('table');
        $config = new \Api\Models\Tool\Config($table);

        $this->view->config = $config;
    }
    // }}}

    // {{{ public function listAction( )
    /**
     * データベースから実データを読み込む
     * @param void
     * @return void
     */
    public function listAction()
    {
        $req = $this->request;
        $table = $req->get('table');

        $namespace = '\\Treasure\\Models\\Model\\'.\Gcl\Util\Inflector::upperCamel($table);
        $model = $namespace::query();
        $config = new \Api\Models\Tool\Config($table);

        $httpParam = ['table' => $table];
        $this->view->paginator = $this->returnPaginatorByModel($model, $req, $httpParam, 50);
        $this->view->table = $table;
        $this->view->config = $config;
        $this->view->searchFilter = $config->search_filter;
        $this->view->httpParam = $httpParam;
    }
    // }}}
}
