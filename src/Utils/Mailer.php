<?php
/**
 * Papi\Utils
 */
namespace Papi\Utils;

use Gcl\Util\GArray;

/**
 * メーラー
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag) $exceptions
 */
class Mailer extends \PHPMailer
{

    protected $enabled = false;

    /**
     * __construct
     * @param boolean $exceptions
     */
    public function __construct($mail, $exceptions = false)
    {
        parent::__construct($exceptions);
        $this->set('CharSet', 'iso-2022-jp');
        $this->set('Encoding', '7bit');
        $this->set('From', $mail);
        $this->set('ReturnPath', $mail);

        $config = \Phalcon\DI::getDefault()->get('config')->config->toArray();

        $sendmail = GArray::get($config, 'sendmail', false);

        if ($sendmail) {
            $this->enabled = GArray::get($sendmail, 'enabled', false);
            $params = GArray::get($sendmail, $mail, []);
            foreach ($params as $name => $value) {
                $this->set($name, $value);
            }
        }

        $smtp = GArray::get($config, 'smtp', false);
        if ($smtp) {
            $this->enabled = GArray::get($smtp, 'enabled', false);
            if ($this->enabled) {
                $this->IsSMTP();
                $this->SMTPAuth = true;
                $params = GArray::get($smtp, $mail, []);
                foreach ($params as $name => $value) {
                    $this->set($name, $value);
                }
            }
        }
    }

    /**
     * プロパティのセット
     * @param string $name
     * @param mixed $value
     * @return boolean
     */
    public function set($name, $value = '')
    {
        switch ($name) {
            case 'Body':
                $value = mb_convert_encoding($value, 'JIS');
                break;

            case 'FromName':
            case 'Subject':
                $value = mb_encode_mimeheader(mb_convert_encoding($value, 'JIS'), 'JIS');
                break;
        }

        return parent::set($name, $value);
    }

    public function send()
    {
        if ($this->enabled) {
            return parent::send();
        }
    }
}
