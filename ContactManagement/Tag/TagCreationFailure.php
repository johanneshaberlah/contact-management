<?php

namespace ContactManagement\Failure;

/**
 * @author Lukas Klein
 */
final class TagCreationFailure extends \Exception {
    private const MESSAGE_FORMAT = "Der Tag konnte nicht erstellt werden: %s";

    private function __construct(string $message) {
        parent::__construct($message);
    }

    public static function create(string $message): TagCreationFailure {
        return new TagCreationFailure(sprintf(self::MESSAGE_FORMAT, $message));
    }
}