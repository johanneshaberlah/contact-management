<?php

namespace ContactManagement\Client;

final class DatabaseCredentials {
    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;

    /**
     * @param string $host
     * @param int $port
     * @param string $database
     * @param string $username
     * @param string $password
     */
    public function __construct(
        string $host,
        int $port,
        string $database,
        string $username,
        string $password
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function host(): string {
        return $this->host;
    }

    public function port(): int {
        return $this->port;
    }

    public function database(): string {
        return $this->database;
    }

    public function username(): string {
        return $this->username;
    }

    public function password(): string {
        return $this->password;
    }

    public static function fromEnvironment(): DatabaseCredentials {
//        return new DatabaseCredentials(
//            strval(getenv("DB_HOST")),
//            intval(getenv("DB_PORT")),
//            strval(getenv("DB_DATABASE")),
//            strval(getenv("DB_USERNAME")),
//            strval(getenv("DB_PASSWORD"))
//        );
        return new DatabaseCredentials(
            "localhost",
            5432,
            "contact_management",
            "postgres",
            "postgres"
        );
    }
}