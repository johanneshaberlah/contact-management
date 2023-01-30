<?php

namespace ContactManagement;

/**
 * @author Lukas Klein
 */
final class Tag {
    private ?int $id;
    private string $name;
    private string $color;

    /**
     * @param int|null $id
     * @param string $name
     * @param string $color
     */
    private function __construct(?int $id, string $name, string $color) {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
    }

    public function id(): ?int {
        return $this->id;
    }

    public function name(): string {
        return $this->name;
    }

    public function nameWithoutPrefix(): string {
        if (!str_starts_with($this->name, TagFactory::TAG_PREFIX)) {
            return $this->name;
        }
        return substr($this->name, strlen(TagFactory::TAG_PREFIX));
    }

    public function color(): string {
        return $this->color;
    }

    public function copyWithId(?int $id): Tag {
        return Tag::create(
            $id,
            $this->name,
            $this->color
        );
    }

    public function copyWithName(string $name): Tag {
        return Tag::create(
            $this->id,
            $name,
            $this->color
        );
    }

    public function copyWithColor(string $color): Tag {
        return Tag::create(
            $this->id,
            $this->name,
            $color
        );
    }

    public static function create(?int $id, string $name, string $color): Tag {
        return new self($id, $name, $color);
    }
}