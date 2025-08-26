<?php

namespace app\services;

use app\exceptions\ValidationException;
use app\models\Contact;
use app\models\Deal;
use app\models\forms\ContactForm;
use app\models\forms\DealForm;
use app\repositories\ContactRepository;
use app\repositories\DealRepository;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class ContactService
{
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getAllContacts(): array
    {
        return $this->contactRepository->getAll();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getContact(int $id): Contact
    {
        return $this->contactRepository->get($id);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function createContact(ContactForm $form): int
    {
        $contact = $form->createContact();
        return $this->contactRepository->save($contact);
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws ValidationException
     */
    public function updateContact(int $id, ContactForm $form): bool
    {
        $contact = $this->getContact($id);

        $newContact = $form->createContact();

        $contact->first_name = $newContact->first_name;
        $contact->second_name = $newContact->second_name;
//        $contact->deals = $newContact->deals;

        return $this->contactRepository->save($contact);
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function deleteContact(int $id): bool
    {
        $contact = $this->getContact($id);
        return $this->contactRepository->delete($contact);
    }


}