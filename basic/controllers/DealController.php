<?php

namespace app\controllers;

use app\exceptions\ValidationException;
use app\models\forms\DealForm;
use app\services\ContactService;
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
    private ContactService $contactService;

    public function __construct($id, $module, DealService $dealService, ContactService $contactService, $config = [])
    {
        $this->dealService = $dealService;
        $this->contactService = $contactService;
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
            'deal' => $deal
        ]);
    }

    /**
     * @throws Exception
     * @throws ValidationException
     * @throws NotFoundHttpException
     */
    public function actionCreate(): Response|string
    {
        $form = new DealForm();

        if ($form->load(Yii::$app->request->post())) {

            $deal = $this->dealService->createDeal($form);

            $deal->unlinkAll('contacts', true);
            if ($form->contact_ids) {
                foreach ($form->contact_ids as $contactId) {
                    $contact = $this->contactService->getContact($contactId);
                    $deal->link('contacts', $contact);
                }
            }

            Yii::$app->session->setFlash('success', 'Сделка успешно создана.');
            return $this->redirect(['view', 'id' => $deal->id]);
        }

        $contacts = $this->contactService->getAllContacts();

        return $this->render('create', [
            'model' => $form,
            'contacts' => $contacts,
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

            $deal->unlinkAll('contacts', true);
            if ($form->contact_ids) {
                foreach ($form->contact_ids as $contactId) {
                    $contact = $this->contactService->getContact($contactId);
                    $deal->link('contacts', $contact);
                }
            }

            Yii::$app->session->setFlash('success', 'Сделка успешно обновлена.');
            return $this->redirect(['view', 'id' => $deal->id]);
        }

        $contacts = $this->contactService->getAllContacts();

        return $this->render('update', [
            'model' => $form,
            'deal' => $deal,
            'contacts' => $contacts,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        try {
            $deal = $this->dealService->getDeal($id);
            $deal->unlinkAll('contacts', true);
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
                    'ajax' => ['GET']
                ]
            ]
        ];
    }

    public function actionAjax(int $id)
    {

        try {
            $deal = $this->dealService->getDeal($id);
            $dealContacts = $deal->getContacts()->all();

            return $this->renderPartial('_ajax-content', [
                'deal' => $deal,
                'contacts' => $dealContacts
            ]);

        } catch (\Exception $e) {

            return $this->renderPartial('_error', [
                'message' => 'Ошибка загрузки данных сделки: ' . $e->getMessage()
            ]);
        }
    }
}
