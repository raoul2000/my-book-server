<?php

namespace app\components\helpers;

use Yii;

class ValidationErrorHelper
{
    public static function mergeErrorMessages($validationErrors)
    {
        $result = "";
        if (count($validationErrors) !== 0) {
            foreach ($validationErrors as $key => $val) {
                $result .= ' - ' . $key . ': ' . join(", ", $val);
            }
        }
        return $result;
    }
}
