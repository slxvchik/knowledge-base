<?php

namespace app\models\forms;

use app\exceptions\ValidationException;
use app\models\Contact;
use yii\base\Model;

class ContactForm extends Model
{
    public $first_name;
    public $second_name;
//    public $deals = array();
    public function rules(): array
    {
        return [
            [['first_name'], 'required'],
            [['second_name'], 'string']
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
//            'contact' => 'Контакты'
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
//        $contact->contact = $this->contact;

        return $contact;
    }

    public function loadFromModel(Contact $contact): void
    {
        $this->first_name = $contact->first_name;
        $this->second_name = $contact->second_name;
//        $this->contact = $deal->contact;
    }
}