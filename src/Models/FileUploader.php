<?php
namespace Lapi\Models;

/*
 * scpでのファイルアップロードを行う
 * pecl : ssh2が必要
 * <project>/var/nopassword/ 以下に id_dsa.pub, id_dsaが必要
 */
class FileUploader
{
    protected $connection = null;
    const IMAGE_FOLDER_PATH = '/var/home/platform-image/localinfo/';

    /**
     * request用のモデルを作成
     */
    public function __construct()
    {
        $connection = ssh2_connect('images.platform.gochipon.com', 22, ['hostkey' => 'ssh-dss']);
        $auth = ssh2_auth_pubkey_file($connection, 'root', VAR_DIR.'/nopassword/id_dsa.pub', VAR_DIR.'/nopassword/id_dsa');
        if ($auth == false) {
            \Api\Models\Log::ex('Papi', "Can't established ssh connection");
        }
        $this->connection = $connection;
    }

    /*
     * connectionを削除
     */
    public function __destruct() {
        $this->disconnect();
    }

    /*
     * フォルダを作成して、作成したフォルダにファイルをscpする
     */
    public function scpFile($localFile, $uploadFilePath, $uploadFileName)
    {
        // フォルダを作成
        $this->exec('mkdir -p '.self::IMAGE_FOLDER_PATH.$uploadFilePath);
        return ssh2_scp_send($this->connection,
                             $localFile,
                             self::IMAGE_FOLDER_PATH.$uploadFilePath.$uploadFileName,
                             0644);
    }

    /*
     * コマンドを実行
     */
    public function exec($cmd) {
        if (!($stream = ssh2_exec($this->connection, $cmd))) {
            \Api\Models\Log::ex('Papi', "SSH command failed");
        }
        stream_set_blocking($stream, true);
    }

    /*
     * connectionを削除
     */
    public function disconnect() {
        $this->exec('exit');
        $this->connection = null;
    }
}
