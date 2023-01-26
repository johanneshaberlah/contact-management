<?php

use ContactManagement\ContactService;

require "ContactManagement/Contact/ContactService.php";
$contactService = ContactService::create();

$id = $_GET['id'];
$contactService->deleteById($id);

header("Location: /contact-management/listContacts.php");
exit();
