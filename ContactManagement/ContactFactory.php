<?php

namespace ContactManagement;

use ContactManagement\Failure\ContactCreationFailure;
use DateTime;
use Exception;

require "ContactBuilder.php";
require "Failure/ContactCreationFailure.php";

final class ContactFactory {
    private const DATE_FORMAT = "Y-m-d";
    private const ID_PARAMETER = "id";
    private const NAME_PARAMETER = "name";
    private const PHONE_PARAMETER = "phone";
    private const MAIL_PARAMETER = "mail";
    private const BIRTHDAY_PARAMETER = "birthday";

    /**
     * @param array $parameters
     * @return Contact
     *
     * @throws ContactCreationFailure If values are missing or invalid
     */
    public static function fromParameters(array $parameters): Contact {
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
        return $contactBuilder->build();
    }
}