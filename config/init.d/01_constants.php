<?php
define('CONFIG_DIR', dirname(__DIR__));
define('TOP_DIR', dirname(CONFIG_DIR));



define('APP_DIR', TOP_DIR.'/app');
define('BIN_DIR', TOP_DIR.'/bin');
define('DATA_DIR', TOP_DIR.'/data');
define('SRC_DIR', TOP_DIR.'/src');
define('TEST_DIR', TOP_DIR.'/test');
define('TMP_DIR', TOP_DIR.'/tmp');
define('VAR_DIR', TOP_DIR.'/var');
define('COMPOSER_DIR', VAR_DIR.'/composer');

// アプリの実行環境
define('APPLICATION_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'prod');
define('APP_IMAGE_DOMAIN', getenv('APP_IMAGE_DOMAIN'));
define('IMAGE_VERSION', 1);
define('APP_CODE', 'localinfo'); // PFに登録してあるm_application_code
define('APP_NAME', 'お宝ログ'); // サイト名
