<?php

namespace ContactManagement\Repository;

use ContactManagement\Client\DatabaseCredentials;
use ContactManagement\Client\PostgresClient;
use ContactManagement\Contact;
use ContactManagement\ContactFactory;
use ContactManagement\Failure\ContactCreationFailure;
use ContactManagement\TagRepository;

require_once __DIR__ . "/../Common/PostgresClient.php";

/**
 * @author Johannes Haberlah
 */
final class PostgresContactRepository implements ContactRepository {
    private PostgresClient $client;

    private ContactFactory $contactFactory;

    /**
     * @param PostgresClient $client
     */
    private function __construct(PostgresClient $client, TagRepository $tagRepository) {
        $this->client = $client;
        $this->client->connect();
        $this->client->update(
            "CREATE TABLE IF NOT EXISTS contacts (id SERIAL PRIMARY KEY, name VARCHAR(64), phone VARCHAR(16), mail VARCHAR(64), birthday DATE, tag INTEGER REFERENCES tags(id));");
        $this->contactFactory = ContactFactory::create($tagRepository);
    } //TODO varchar kürzen

    /**
     * @throws ContactCreationFailure
     */
    public function findAll(?int $limit = null): array {
        $contacts = [];
        $results = $this->client->query("SELECT * FROM contacts" . ($limit != null ? " LIMIT $limit" : "") . ";");
        foreach ($results as $result){
            $contacts[] = $this->contactFactory->fromParameters($result);
        }
        return $contacts;
    }

    /**
     * @throws ContactCreationFailure
     */
    public function findById(int $id): ?Contact {
        $results = $this->client->query(sprintf("SELECT * FROM contacts WHERE id = %d", $id));
        if (count($results) != 1){
            return null;
        }
        $firstResult = (array) $results[0];
        return $this->contactFactory->fromParameters($firstResult);
    }

    public function save(Contact $contact): Contact {
        if ($contact->id() != null){
            $this->client->update("UPDATE contacts SET name = ?, phone = ?, mail = ?, birthday = ?, tag = ? WHERE id = ?", [
                $contact->name(),
                $contact->phone(),
                $contact->mail(),
                $contact->birthday()?->format("Y-m-d"),
                $contact->tag()?->id(),
                $contact->id()
            ]);
        } else {
            $this->client->update("INSERT INTO contacts (name, phone, mail, birthday, tag) VALUES (?, ?, ?, ?, ?)", [
                $contact->name(),
                $contact->phone(),
                $contact->mail(),
                $contact->birthday()?->format("Y-m-d"),
                $contact->tag()?->id()
            ]);
            $contact = $contact->copyWithId($this->client->lastInsertId());
        }
        return $contact;
    }

    public static function of(PostgresClient $client, TagRepository $tagRepository): PostgresContactRepository {
        return new PostgresContactRepository($client, $tagRepository);
    }

    public static function create(TagRepository $tagRepository): PostgresContactRepository {
        return self::of(
            PostgresClient::create(
                DatabaseCredentials::fromConfiguration(),
            ),
            $tagRepository
        );
    }

    public function deleteById(int $id): void
    {
        $this->client->update("DELETE FROM contacts WHERE id = ?", [
            $id
        ]);
    }

    public function delete(Contact $contact): void
    {
        $this->deleteById($contact->id());
    }
}