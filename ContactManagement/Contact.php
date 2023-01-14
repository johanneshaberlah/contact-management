<?php

namespace ContactManagement;

use DateTime;

final class Contact {
    private ?int $id;
    private string $name;
    private ?string $phone;
    private ?string $mail;
    private ?DateTime $birthday;

    /**
     * @param ?int $id
     * @param string $name The name of the contact containing the firstname and/or lastname
     * @param ?string $phone The phone number of the contact without spaces
     * @param ?string $mail The validated mail address of the contact
     * @param ?DateTime $birthday The birthday of the contact
     */
    private function __construct(?int $id, string $name, ?string $phone, ?string $mail, ?DateTime $birthday) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->mail = $mail;
        $this->birthday = $birthday;
    }

    public function id(): ?int {
        return $this->id;
    }

    public function copyWithId(?int $id): Contact {
        return self::create($id, $this->name, $this->phone, $this->mail, $this->birthday);
    }

    public function name(): string {
        return $this->name;
    }

    public function copyWithName(string $name): Contact {
        return self::create($this->id, $name, $this->phone, $this->mail, $this->birthday);
    }

    public function phone(): ?string {
        return $this->phone;
    }

    public function copyWithPhone(?string $phone): Contact {
        return self::create($this->id, $this->name, $phone, $this->mail, $this->birthday);
    }

    public function mail(): ?string {
        return $this->mail;
    }

    public function copyWithMail(?string $mail): Contact {
        return self::create($this->id, $this->name, $this->phone, $mail, $this->birthday);
    }

    public function birthday(): ?DateTime {
        return $this->birthday;
    }

    public function __toString(): string
    {
        // Generate extensive toString method.
        return $this->name;
    }

    public function copyWithBirthday(?DateTime $birthday): Contact {
        return self::create($this->id, $this->name, $this->phone, $this->mail, $birthday);
    }

    public static function create(?int $id, string $name, ?string $phone, ?string $mail, ?DateTime $birthday): Contact {
        return new Contact($id, $name, $phone, $mail, $birthday);
    }
}