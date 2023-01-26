<?php

namespace ContactManagement;

use ContactManagement\Client\DatabaseCredentials;
use ContactManagement\Client\PostgresClient;

require_once __DIR__ . "/../Common/PostgresClient.php";
require_once "TagRepository.php";

final class PostgresTagRepository implements TagRepository {
    private PostgresClient $client;

    /**
     * @param PostgresClient $client
     */
    private function __construct(PostgresClient $client) {
        $this->client = $client;
        $this->client->update(
            "CREATE TABLE IF NOT EXISTS tags (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                color VARCHAR(255) NOT NULL
            );"
        );
    }


    public function save(Tag $tag): Tag {
        if ($tag->id() != null){
            $this->client->update("UPDATE tags SET name = ?, color = ? WHERE id = ?", [
                $tag->name(),
                $tag->color(),
                $tag->id()
            ]);
        } else {
            $this->client->update("INSERT INTO tags (name, color) VALUES (?, ?)", [
                $tag->name(),
                $tag->color()
            ]);
            $tag = $tag->copyWithId($this->client->lastInsertId());
        }
        return $tag;
    }

    public function findById(int $id): ?Tag {
        $results = $this->client->query(
            sprintf("SELECT * FROM tags WHERE id = %d", $id)
        );
        if (count($results) != 1) {
            return null;
        }
        $firstResult = (array) $results[0];
        return Tag::create(
            $firstResult["id"],
            $firstResult["name"],
            $firstResult["color"]
        );
    }

    public function findAll(): array {
        $tags = [];
        $results = $this->client->query("SELECT * FROM tags");
        foreach ($results as $result) {
            $tags[] = TagFactory::fromParameters($result);
        }
        return $tags;
    }

    public function findByName(string $name): ?Tag {
        $results = $this->client->query(
            sprintf("SELECT * FROM tags WHERE name = '%s'", $name)
        );
        if (count($results) != 1) {
            return null;
        }
        $firstResult = (array) $results[0];
        return TagFactory::fromParameters($firstResult);
    }

    public function deleteById(int $id): void
    {
        $this->client->update("UPDATE contacts SET tag = ? WHERE tag = ?", [
            null,
            $id
        ]);
        $this->client->update("DELETE FROM tags WHERE id = ?", [
            $id
        ]);
    }

    public function delete(Tag $tag): void {
        $this->deleteById($tag->id());
    }

    public static function create(): PostgresTagRepository {
        return new PostgresTagRepository(
            PostgresClient::create(
                DatabaseCredentials::fromEnvironment()
            )
        );
    }
}