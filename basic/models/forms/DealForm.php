<?php

namespace app\models\forms;

use app\exceptions\ValidationException;
use app\models\Deal;
use yii\base\Model;
use yii\db\Exception;

class DealForm extends Model
{
    public $name;
    public $sum;
//    public $contact = array();
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['sum'], 'integer', 'min' => 0],
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'name' => 'Название сделки',
            'sum' => 'Сумма сделки',
//            'contact' => 'Контакты'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function createDeal(): Deal
    {
        if (!$this->validate()) {
            throw new ValidationException($this->errors);
        }

        $deal = new Deal();
        $deal->name = $this->name;
        $deal->sum = $this->sum;
//        $deal->contact = $this->contact;

        return $deal;
    }

    public function loadFromModel(Deal $deal): void
    {
        $this->name = $deal->name;
        $this->sum = $deal->sum;
//        $this->contact = $deal->contact;
    }
}