<?php
namespace Lapi\Models\Validator;

use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;
use Phalcon\Mvc\EntityInterface;
use Lapi\Models\Model\Treasure;

class TreasureIdValidator extends Validator implements ValidatorInterface
{
    public function validate(EntityInterface $model)
    {
        $field = $this->getOption('field');

        if (! $this->validPositiveInteger($model->$field)) {
            $message = sprintf("1以上の値を指定してください");
            $this->appendMessage($message, $field, "TreasureIdValidator");
            return false;
        }

        if (! $this->validTreasureId($model->$field)) {
            $message = sprintf("データがありません");
            $this->appendMessage($message, $field, "TreasureIdValidator");
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
    public function validTreasureId($parameter)
    {
        $treasure = Treasure::findFirst($parameter);
        if ($treasure == null) {
            return false;
        }

        if ($treasure->id == $parameter) {
            return true;
        }
        return false;
    }
}
