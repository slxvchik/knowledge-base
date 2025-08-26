<?php

namespace app\models\forms;

use yii\base\Model;

class DealForm extends Model
{
    public $name;
    public $sum;
    public $contacts = array();
    public function rules(): array
    {
        return [
            [['name'], 'required'],
        ];
    }
}