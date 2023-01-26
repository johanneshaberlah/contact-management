<?php

use ContactManagement\TagService;

require "ContactManagement/Tag/TagService.php";
$tagService = TagService::create();

$id = $_GET['id'];
$tagService->deleteById($id);

header("Location: /contact-management/listTags.php");
exit();
