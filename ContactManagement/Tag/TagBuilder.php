<?php

namespace ContactManagement;

require_once "Tag.php";

final class TagBuilder {
    private const DEFAULT_COLOR = "#808080";

    private Tag $prototype;

    /**
     * @param Tag $prototype
        */
    private function __construct(Tag $prototype) {
        $this->prototype = $prototype;
    }

    public function withId(?int $id): TagBuilder {
        return new TagBuilder($this->prototype->copyWithId($id));
    }

    public function withName(string $name): TagBuilder {
        $this->prototype = $this->prototype->copyWithName($name);
        return $this;
    }

    public function withColor(string $color): TagBuilder {
        $this->prototype = $this->prototype->copyWithColor($color);
        return $this;
    }

    public function build(): Tag {
        return $this->prototype;
    }

    public static function fromTag(Tag $prototype): TagBuilder {
        return new TagBuilder($prototype);
    }

    public static function fromName(string $name): TagBuilder {
        return self::fromTag(
            Tag::create(
                null,
                $name,
                self::DEFAULT_COLOR
            )
        );
    }
}