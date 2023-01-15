<?php

namespace ContactManagement;

use ContactManagement\Failure\ContactCreationFailure;
use ContactManagement\Failure\ContactNotFoundFailure;
use ContactManagement\Repository\ContactRepository;
use ContactManagement\Repository\PostgresContactRepository;
use PDOException;

require "Repository/ContactRepository.php";
require "ContactFactory.php";
require "Repository/PostgresContactRepository.php";

final class ContactService {
    private const START_PAGE_CONTACT_LIST_SIZE = 5;

    private ContactRepository $repository;

    /**
     * @param ContactRepository $repository
     */
    private function __construct(ContactRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @throws ContactCreationFailure
     * @throws PDOException
     */
    public function saveContact(array $parameters): Contact {
        $contact = ContactFactory::fromParameters($parameters);
        return $this->repository->save($contact);
    }

    /**
     * @throws ContactNotFoundFailure
     */
    public function findById(array $parameters): Contact {
        if (!isset($parameters["id"])) {
            throw ContactNotFoundFailure::create("Bitte gebe eine ID als URL-GET-Parameter an.");
        }
        $id = intval($parameters["id"]);
        $contact = $this->repository->findById($id);
        if ($contact == null){
            throw ContactNotFoundFailure::create("Kein Kontakt mit der ID $id gefunden.");
        }
        return $contact;
    }

    /**
     * @throws ContactCreationFailure
     */
    public function findAll(): array {
        return $this->repository->findAll();
    }

    /**
     * @throws ContactCreationFailure
     */
    public function findAllForTeaser(): array {
        return $this->repository->findAll(self::START_PAGE_CONTACT_LIST_SIZE);
    }

    public static function create(): ContactService {
        return new ContactService(PostgresContactRepository::create());
    }
}