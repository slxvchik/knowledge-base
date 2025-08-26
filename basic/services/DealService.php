<?php

namespace app\services;

use app\exceptions\ValidationException;
use app\models\Deal;
use app\models\forms\DealForm;
use app\repositories\DealRepository;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class DealService
{
    private DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function getAllDeals(): array
    {
        return $this->dealRepository->getAll();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getDeal(int $id): Deal
    {
        return $this->dealRepository->get($id);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function createDeal(DealForm $form): int
    {
        $deal = $form->createDeal();
        return $this->dealRepository->save($deal);
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws ValidationException
     */
    public function updateDeal(int $id, DealForm $form): bool
    {
        $deal = $this->getDeal($id);

        $newDeal = $form->createDeal();

        $deal->name = $newDeal->name;
        $deal->sum = $newDeal->sum;
//        $deal->contact = $newDeal->contact;
        return $this->dealRepository->save($deal);
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function deleteDeal(int $id): bool
    {
        $deal = $this->getDeal($id);
        return $this->dealRepository->delete($deal);
    }


}