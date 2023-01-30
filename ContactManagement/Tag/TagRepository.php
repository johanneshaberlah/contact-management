<?php

namespace ContactManagement;

require_once "Tag.php";

/**
 * @author Lukas Klein
 */
interface TagRepository {

    public function save(Tag $tag): Tag;

    public function findById(int $id): ?Tag;

    public function findAll(): array;

    public function findByName(string $name): ?Tag;

    public function deleteById(int $id): void;

    public function delete(Tag $tag): void;

}