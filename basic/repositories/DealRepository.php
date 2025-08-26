<?php

namespace app\repositories;

use app\models\Deal;
use Throwable;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class DealRepository
{
    public function find(): ActiveQuery
    {
        return Deal::find();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function get(int $id): Deal
    {
        $deal = $this->find()->andWhere(['id' => $id])->one();

        if (!$deal) {
            throw new NotFoundHttpException('Сделка не найдена.');
        }

        return $deal;
    }

    /**
     * @throws Exception
     */
    public function save(Deal $deal): int
    {
        $deal->save();
        return $deal->id;
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function delete(Deal $deal): bool
    {
        return $deal->delete() !== false;
    }

    public function getAll(): array
    {
        return $this->find()->orderBy(['created_at' => SORT_ASC])->all();
    }
}