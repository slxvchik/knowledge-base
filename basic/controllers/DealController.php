<?php

namespace app\controllers;

use app\exceptions\ValidationException;
use app\models\forms\DealForm;
use app\services\DealService;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DealController extends Controller
{
    private DealService $dealService;

    public function __construct($id, $module, DealService $dealService, $config = [])
    {
        $this->dealService = $dealService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $deals = $this->dealService->getAllDeals();
        return $this->render('index', [
            'deals' => $deals,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $deal = $this->dealService->getDeal($id);

        return $this->render('view', [
            'deal' => $deal,
        ]);
    }

    /**
     * @throws Exception
     * @throws ValidationException
     */
    public function actionCreate(): Response|string
    {
        $form = new DealForm();

        if ($form->load(Yii::$app->request->post())) {

            $dealId = $this->dealService->createDeal($form);

            if ($dealId) {
                Yii::$app->session->setFlash('success', 'Сделка успешно создана.');
                return $this->redirect(['view', 'id' => $dealId]);
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $deal = $this->dealService->getDeal($id);
        $form = new DealForm();

        $form->loadFromModel($deal);

        if ($form->load(Yii::$app->request->post()) && $this->dealService->updateDeal($id, $form)) {
            Yii::$app->session->setFlash('success', 'Сделка успешно обновлена.');
            return $this->redirect(['view', 'id' => $deal->id]);
        }

        return $this->render('update', [
            'model' => $form,
            'deal' => $deal,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        try {
            $this->dealService->deleteDeal($id);
            Yii::$app->session->setFlash('success', 'Сделка успешно удалена.');
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash('error', 'Не удалось удалить сделку: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['GET', 'POST'],
                    'update' => ['GET', 'POST'],
                    'delete' => ['POST'],
                ]
            ]
        ];
    }
}
