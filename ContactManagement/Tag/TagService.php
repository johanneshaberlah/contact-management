<?php

namespace ContactManagement;

use ContactManagement\Failure\TagCreationFailure;
use ContactManagement\Failure\TagNotFoundFailure;

require_once "TagRepository.php";
require_once "TagFactory.php";
require_once "PostgresTagRepository.php";

/**
 * @author Lukas Klein
 */
final class TagService {
    private TagRepository $repository;

    /**
     * @param TagRepository $repository
     */
    private function __construct(TagRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @throws TagCreationFailure
     */
    public function saveTag(array $parameters): Tag {
        $tag = TagFactory::fromParameters($parameters);
        return $this->repository->save($tag);
    }

    /**
     * @throws TagNotFoundFailure
     */
    public function findById(array $parameters): ?Tag {
        if (!isset($parameters["id"])) {
            throw TagNotFoundFailure::create("Bitte gebe eine ID als URL-GET-Parameter an.");
        }
        $id = intval($parameters["id"]);
        $tag = $this->repository->findById($id);
        if ($tag == null){
            throw TagNotFoundFailure::create("Kein Tag mit der ID $id gefunden.");
        }
        return $tag;
    }

    public function deleteById(int $id): void {
        $this->repository->deleteById($id);
    }

    /**
     * @returns Tag[]
     *
     * @throws TagCreationFailure
     */
    public function findAll(): array {
        return $this->repository->findAll();
    }

    public static function create(): TagService {
        return new TagService(PostgresTagRepository::create());
    }
}