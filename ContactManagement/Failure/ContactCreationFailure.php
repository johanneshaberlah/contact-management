<?php

namespace ContactManagement\Failure;

final class ContactCreationFailure extends \Exception {
    private const MESSAGE_FORMAT = "Der Kontakt konnte nicht erstellt werden: %s";

    private function __construct(string $message) {
        parent::__construct($message);
    }

    public static function create(string $message): ContactCreationFailure {
        return new ContactCreationFailure(sprintf(self::MESSAGE_FORMAT, $message));
    }
}