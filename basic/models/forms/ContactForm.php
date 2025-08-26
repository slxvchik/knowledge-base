<?php

namespace app\models\forms;

use yii\base\Model;

class ContactForm extends Model
{
    public $first_name;
    public $second_name;
    public $contacts = array();
    public function rules(): array
    {
        return [
            [['first_name'], 'required'],
        ];
    }
}