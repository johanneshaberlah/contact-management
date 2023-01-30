<?php

namespace ContactManagement\Failure;

/**
 * @author Johannes Haberlah
 */
final class ContactNotFoundFailure extends \Exception {
    private const MESSAGE_FORMAT = "Der Kontakt konnte nicht gefunden werden: %s";

    private function __construct(string $message) {
        parent::__construct($message);
    }

    public static function create(string $message): ContactNotFoundFailure {
        return new ContactNotFoundFailure(sprintf(self::MESSAGE_FORMAT, $message));
    }
}