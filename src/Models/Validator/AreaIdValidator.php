<?php
namespace Treasure\Models\Validator;

use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;
use Phalcon\Mvc\EntityInterface;
use Treasure\Models\Model\MArea;

class AreaIdValidator extends Validator implements ValidatorInterface
{
    public function validate(EntityInterface $model)
    {
        $field = $this->getOption('field');

        if (! $this->validPositiveInteger($model->$field)) {
            $message = sprintf("1以上の値を指定してください");
            $this->appendMessage($message, $field, "AreaIdValidator");
            return false;
        }

        if (! $this->validAreaId($model->$field)) {
            $message = sprintf("データがありません");
            $this->appendMessage($message, $field, "AreaIdValidator");
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
    public function validAreaId($parameter)
    {
        $prefecture = MArea::findFirst($parameter);

        if ($prefecture->id == $parameter) {
            return true;
        }
        return false;
    }
}
