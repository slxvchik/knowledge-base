<?php

namespace app\services;

use app\exceptions\ValidationException;
use app\interfaces\ThemeServiceInterface;
use app\models\Contact;
use app\models\forms\ContactForm;
use app\repositories\ContactRepository;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class ContactService implements ThemeServiceInterface
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
    public function createContact(ContactForm $form): Contact
    {
        $contact = $form->createContact();
        return $this->contactRepository->save($contact);
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws ValidationException
     */
    public function updateContact(int $id, ContactForm $form): Contact
    {
        $contact = $this->getContact($id);

        $newContact = $form->createContact();

        $contact->first_name = $newContact->first_name;
        $contact->second_name = $newContact->second_name;

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


    public function getAll(): array
    {
        return $this->contactRepository->getAll();
    }

    public function getAjaxUrl(): string
    {
        return '/contacts/ajax';
    }
}