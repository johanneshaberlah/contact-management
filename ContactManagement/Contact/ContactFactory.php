<?php

namespace ContactManagement;

use ContactManagement\Failure\ContactCreationFailure;
use DateTime;

require_once "ContactBuilder.php";
require_once  __DIR__ . "/../Tag/PostgresTagRepository.php";
require_once "ContactCreationFailure.php";

final class ContactFactory {
    private const DATE_FORMAT = "Y-m-d";
    private const ID_PARAMETER = "id";
    private const NAME_PARAMETER = "name";
    private const PHONE_PARAMETER = "phone";
    private const MAIL_PARAMETER = "mail";
    private const BIRTHDAY_PARAMETER = "birthday";
    private const TAG_PARAMETER = "tag";

    private TagRepository $tagRepository;

    /**
     * @param TagRepository $tagRepository
     */
    private function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }


    /**
     * @param array $parameters
     * @return Contact
     *
     * @throws ContactCreationFailure If values are missing or invalid
     */
    public function fromParameters(array $parameters): Contact {
        $name = $parameters[self::NAME_PARAMETER];
        if ($name == null){
            throw ContactCreationFailure::create("Bitte einen Namen angeben.");
        }
        $contactBuilder = ContactBuilder::fromName($name);
        if (isset($parameters[self::ID_PARAMETER])){
            $id = intval($parameters[self::ID_PARAMETER]);
            $contactBuilder = $contactBuilder->withId($id);
        }
        if (isset($parameters[self::PHONE_PARAMETER])){
            $contactBuilder->withPhone($parameters[self::PHONE_PARAMETER]);
        }
        if (isset($parameters[self::MAIL_PARAMETER])){
            $contactBuilder->withMail($parameters[self::MAIL_PARAMETER]);
        }
        if (isset($parameters[self::BIRTHDAY_PARAMETER]) & !empty($parameters[self::BIRTHDAY_PARAMETER])){
            $date = DateTime::createFromFormat(self::DATE_FORMAT, $parameters[self::BIRTHDAY_PARAMETER]);
            if (!$date) {
                throw ContactCreationFailure::create("Bitte ein gültiges Datum angeben.");
            }
            $contactBuilder->withBirthday($date);
        }
        if (isset($parameters[self::TAG_PARAMETER]) && intval($parameters[self::TAG_PARAMETER]) != 0){
             $contactBuilder->withTag($this->tagRepository->findById($parameters[self::TAG_PARAMETER]));
        }
        return $contactBuilder->build();
    }

    public static function create(TagRepository $tagRepository): ContactFactory {
        return new ContactFactory($tagRepository);
    }
}