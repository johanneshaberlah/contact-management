<?php

namespace ContactManagement;

use DateTime;

require "Contact.php";

final class ContactBuilder {
    private Contact $prototype;

    /**
     * @param Contact $prototype
     */
    public function __construct(Contact $prototype) {
        $this->prototype = $prototype;
    }

    public function withId(?int $id): ContactBuilder {
        return new ContactBuilder($this->prototype->copyWithId($id));
    }

    public function withName(string $name): ContactBuilder {
        $this->prototype = $this->prototype->copyWithName($name);
        return $this;
    }

    public function withPhone(?string $phone): ContactBuilder {
        $this->prototype = $this->prototype->copyWithPhone($phone);
        return $this;
    }

    public function withMail(?string $mail): ContactBuilder {
        $this->prototype = $this->prototype->copyWithMail($mail);
        return $this;
    }

    public function withBirthday(?DateTime $birthday): ContactBuilder {
        $this->prototype = $this->prototype->copyWithBirthday($birthday);
        return $this;
    }

    public function build(): Contact {
        return $this->prototype;
    }

    public static function fromContact(Contact $prototype): ContactBuilder {
        return new ContactBuilder($prototype);
    }

    public static function fromName(string $name): ContactBuilder {
        return self::fromContact(
            Contact::create(
                null,
                $name,
                null,
                null,
                null
            )
        );
    }
}