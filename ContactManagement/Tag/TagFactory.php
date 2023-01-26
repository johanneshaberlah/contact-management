<?php

namespace ContactManagement;

use ContactManagement\Failure\TagCreationFailure;

require_once "TagBuilder.php";
require_once "TagCreationFailure.php";

final class TagFactory {
    public const TAG_PREFIX = "#";

    private const ID_PARAMETER = "id";
    private const NAME_PARAMETER = "name";
    private const COLOR_PARAMETER = "color";

    /**
     * @throws TagCreationFailure
     */
    public static function fromParameters(array $parameters): Tag {
        if (!isset($parameters[self::NAME_PARAMETER]) || !isset($parameters[self::COLOR_PARAMETER])) {
            throw TagCreationFailure::create("Bitte Namen und Farbe angeben.");
        }
        $name = $parameters[self::NAME_PARAMETER];
        if (!str_starts_with($name, self::TAG_PREFIX)) {
            $name = self::TAG_PREFIX . $name;
        }
        $tagBuilder = TagBuilder::fromName($name);
        if (isset($parameters[self::ID_PARAMETER])){
            $id = intval($parameters[self::ID_PARAMETER]);
            $tagBuilder = $tagBuilder->withId($id);
        }
        $tagBuilder->withColor($parameters[self::COLOR_PARAMETER]);
        return $tagBuilder->build();
    }
}