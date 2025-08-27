<?php

namespace app\models\forms;

use app\exceptions\ValidationException;
use app\models\Contact;
use yii\base\InvalidConfigException;
use yii\base\Model;

class ContactForm extends Model
{
    public $first_name;
    public $second_name;
    public $deal_ids = array();
    public function rules(): array
    {
        return [
            [['first_name'], 'required'],
            [['second_name'], 'string'],
            [['deal_ids'], 'each', 'rule' => ['integer']],
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'deal_ids' => 'Сделки'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function createContact(): Contact
    {
        if (!$this->validate()) {
            throw new ValidationException($this->errors);
        }

        $contact = new Contact();
        $contact->first_name = $this->first_name;
        $contact->second_name = $this->second_name;

        return $contact;
    }

    /**
     * @throws InvalidConfigException
     */
    public function loadFromModel(Contact $contact): void
    {
        $this->first_name = $contact->first_name;
        $this->second_name = $contact->second_name;
        $this->deal_ids = $contact->getDeals()->select('id')->column();
    }
}