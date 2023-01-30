<?php

namespace ContactManagement\Repository;

use ContactManagement\Contact;

/**
 * @author Johannes Haberlah
 */
interface ContactRepository {

    // Create / Update
    public function save(Contact $contact): Contact;

    // Read
    public function findById(int $id): ?Contact;

    /**
     * @return Contact[]
     */
    public function findAll(?int $limit = null): array;

    public function deleteById(int $id): void;

    public function delete(Contact $contact): void;
}