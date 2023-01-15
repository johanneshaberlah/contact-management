<?php

namespace ContactManagement\Client;

use PDO;

require_once "DatabaseCredentials.php";

final class PostgresClient {
    private const CONNECTION_STRING_FORMAT = "pgsql:host=%s;port=%d;dbname=%s;";

    private PDO $connection;
    private DatabaseCredentials $credentials;

    /**
     * @param DatabaseCredentials $credentials
     */
    private function __construct(DatabaseCredentials $credentials) {
        $this->credentials = $credentials;
        $this->connection = $this->connect();
    }

    public function connect(): PDO {
        return $this->createConnection(
            $this->buildConnectionString(),
            $this->credentials->username(),
            $this->credentials->password()
        );
    }

    public function query(string $query): array {
        $rows = $this->connection->query($query);
        return $rows->fetchAll();
    }

    public function update(string $query, ?array $parameter = []): void {
        $this->connection
            ->prepare($query)
            ->execute($parameter);
    }

    public function lastInsertId(): int {
        return $this->connection->lastInsertId();
    }

    private function createConnection(string $connectionString, string $username, string $password): PDO {
        return new PDO(
            $connectionString,
            $username,
            $password
        );
    }

    private function buildConnectionString(): string {
        return sprintf(
            self::CONNECTION_STRING_FORMAT,
            $this->credentials->host(),
            $this->credentials->port(),
            $this->credentials->database()
        );
    }

    public static function create(DatabaseCredentials $credentials): PostgresClient {
        return new PostgresClient($credentials);
    }
}