<?php

namespace app\repositories;

use app\models\Contact;
use Throwable;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class ContactRepository
{
    public function find(): ActiveQuery
    {
        return Contact::find();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function get(int $id): Contact
    {
        $contact = $this->find()->andWhere(['id' => $id])->one();

        if (!$contact) {
            throw new NotFoundHttpException('Контакт не найден.');
        }

        return $contact;
    }

    /**
     * @throws Exception
     */
    public function save(Contact $contact): Contact
    {
        if (!$contact->save()) {
            throw new Exception('Can not save contact.');
        }
        return $contact;
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function delete(Contact $contact): bool
    {
        return $contact->delete() !== false;
    }

    public function getAll(): array
    {
        return $this->find()->orderBy(['created_at' => SORT_ASC])->all();
    }

}