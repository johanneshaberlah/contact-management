<?php

namespace ContactManagement\Failure;

class TagNotFoundFailure extends \Exception {
    private const MESSAGE_FORMAT = "Der Tag konnte nicht gefunden werden: %s";

    private function __construct(string $message) {
        parent::__construct($message);
    }

    public static function create(string $message): TagNotFoundFailure {
        return new TagNotFoundFailure(sprintf(self::MESSAGE_FORMAT, $message));
    }
}