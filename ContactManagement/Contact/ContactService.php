<?php

namespace ContactManagement;

use ContactManagement\Failure\ContactCreationFailure;
use ContactManagement\Failure\ContactNotFoundFailure;
use ContactManagement\Repository\ContactRepository;
use ContactManagement\Repository\PostgresContactRepository;
use PDOException;

require_once "ContactRepository.php";
require_once "ContactFactory.php";
require_once "PostgresContactRepository.php";

final class ContactService {
    private const START_PAGE_CONTACT_LIST_SIZE = 5;

    private ContactRepository $contactRepository;
    private ContactFactory $contactFactory;

    /**
     * @param ContactRepository $repository
     * @param TagRepository $tagRepository
     */
    private function __construct(ContactRepository $repository, TagRepository $tagRepository) {
        $this->contactRepository = $repository;
        $this->contactFactory = ContactFactory::create($tagRepository);
    }

    /**
     * @throws ContactCreationFailure
     * @throws PDOException
     */
    public function saveContact(array $parameters): Contact {
        $contact = $this->contactFactory->fromParameters($parameters);
        return $this->contactRepository->save($contact);
    }

    /**
     * @throws ContactNotFoundFailure
     */
    public function findById(array $parameters): Contact {
        if (!isset($parameters["id"])) {
            throw ContactNotFoundFailure::create("Bitte gebe eine ID als URL-GET-Parameter an.");
        }
        $id = intval($parameters["id"]);
        $contact = $this->contactRepository->findById($id);
        if ($contact == null){
            throw ContactNotFoundFailure::create("Kein Kontakt mit der ID $id gefunden.");
        }
        return $contact;
    }

    /**
     * @throws ContactCreationFailure
     * @returns Contact[]
     */
    public function randomContacts(): array {
        $contacts = $this->findAll();
        shuffle($contacts);
        return array_slice($contacts, 0, self::START_PAGE_CONTACT_LIST_SIZE);
    }

    /**
     * @throws ContactCreationFailure
     * @returns Contact[]
     */
    public function findAll(): array {
        return $this->contactRepository->findAll();
    }

    public function deleteById(int $id): void {
        $this->contactRepository->deleteById($id);
    }

    public static function create(): ContactService {
        $tagRepository = PostgresTagRepository::create();
        return new ContactService(
            PostgresContactRepository::create($tagRepository),
            $tagRepository
        );
    }
}