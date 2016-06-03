<?php
namespace Lapi\Models\Validator;

use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;
use Phalcon\Mvc\EntityInterface;
use Lapi\Models\Model\Localinfo;

class LocalinfoIdValidator extends Validator implements ValidatorInterface
{
    public function validate(EntityInterface $model)
    {
        $field = $this->getOption('field');

        if (! $this->validPositiveInteger($model->$field)) {
            $message = sprintf("1以上の値を指定してください");
            $this->appendMessage($message, $field, "LocalinfoIdValidator");
            return false;
        }

        if (! $this->validLocalinfoId($model->$field)) {
            $message = sprintf("データがありません");
            $this->appendMessage($message, $field, "LocalinfoIdValidator");
            return false;
        }

        return true;
    }

    /**
     * 文字数チェック
     * @return boolean
     */
    public function validPositiveInteger($parameter)
    {
        if ((is_int($parameter) || ctype_digit($parameter)) && (int)$parameter > 0) {
            return true;
        }
        return false;
    }

    /**
     * 文字数チェック
     * @return boolean
     */
    public function validLocalinfoId($parameter)
    {
        $localinfo = Localinfo::findFirst($parameter);
        if ($localinfo == null) {
            return false;
        }

        if ($localinfo->id == $parameter) {
            return true;
        }
        return false;
    }
}
