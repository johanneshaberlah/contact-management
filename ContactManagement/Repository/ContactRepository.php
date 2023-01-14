<?php

namespace ContactManagement\Repository;

use ContactManagement\Contact;

interface ContactRepository {

    public function save(Contact $contact): Contact;

    public function findById(int $id): ?Contact;

    /**
     * @return Contact[]
     */
    public function findAll(?int $limit = null): array;
}