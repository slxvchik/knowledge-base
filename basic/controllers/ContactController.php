<?php

namespace app\controllers;

use app\exceptions\ValidationException;
use app\models\forms\ContactForm;
use app\models\forms\DealForm;
use app\services\ContactService;
use app\services\DealService;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ContactController extends Controller
{
    private ContactService $contactService;
    private DealService $dealService;

    public function __construct($id, $module, ContactService $contactService, DealService $dealService, $config = [])
    {
        $this->contactService = $contactService;
        $this->dealService = $dealService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $contacts = $this->contactService->getAllContacts();

        return $this->render('index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $contact = $this->contactService->getContact($id);

        return $this->render('view', [
            'contact' => $contact,
        ]);
    }

    /**
     * @throws Exception
     * @throws ValidationException
     */
    public function actionCreate(): Response|string
    {
        $form = new ContactForm();

        if ($form->load(Yii::$app->request->post())) {

            $contact = $this->contactService->createContact($form);

            $contact->unlinkAll('deals', true);
            if ($form->deal_ids) {
                foreach ($form->deal_ids as $dealId) {
                    $deal = $this->dealService->getDeal($dealId);
                    $contact->link('deals', $deal);
                }
            }

            Yii::$app->session->setFlash('success', 'Контакт успешно создан.');

            return $this->redirect(['view', 'id' => $contact->id]);
        }

        $deals = $this->dealService->getAllDeals();

        return $this->render('create', [
            'model' => $form,
            'deals' => $deals,
        ]);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $contact = $this->contactService->getContact($id);
        $form = new ContactForm();

        $form->loadFromModel($contact);

        if ($form->load(Yii::$app->request->post()) && $this->contactService->updateContact($id, $form)) {

            $contact->unlinkAll('deals', true);
            if ($form->deal_ids) {
                foreach ($form->deal_ids as $dealId) {
                    $deal = $this->dealService->getDeal($dealId);
                    $contact->link('deals', $deal);
                }
            }

            Yii::$app->session->setFlash('success', 'Контакт успешно обновлен.');
            return $this->redirect(['view', 'id' => $contact->id]);
        }

        $deals = $this->dealService->getAllDeals();

        return $this->render('update', [
            'model' => $form,
            'contact' => $contact,
            'deals' => $deals,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        try {

            $contact = $this->contactService->getContact($id);
            $contact->unlinkAll('deals', true);

            $this->contactService->deleteContact($id);

            Yii::$app->session->setFlash('success', 'Контакт успешно удален.');
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash('error', 'Не удалось удалить контакт: ' . $e->getMessage());
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
            $contact = $this->contactService->getContact($id);
            $contactDeals = $contact->getDeals()->all();

            return $this->renderPartial('_ajax-content', [
                'contact' => $contact,
                'deals' => $contactDeals
            ]);

        } catch (\Exception $e) {

            return $this->renderPartial('_error', [
                'message' => 'Ошибка загрузки данных сделки: ' . $e->getMessage()
            ]);
        }
    }
}
