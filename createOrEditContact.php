<!DOCTYPE html>
<html lang="de">
    <head>
      <title>contacty - Kontakt erstellen</title>
        <script src="assets/scripts/jquery-3.6.3.min.js"></script>
        <link
            href="assets/stylesheets/bootstrap.min.css"
            rel="stylesheet">
        <link
            href="assets/stylesheets/reset.css"
            rel="stylesheet">
        <link
            href="assets/stylesheets/style.css"
            rel="stylesheet">
    </head>
    <?php
    use ContactManagement\ContactService;
    require "ContactManagement/ContactService.php";

    $contactService = ContactService::create();

    $parameters = $_POST;
    if (isset($_GET["id"])) {
        $contact = $contactService->findById($_GET);
    } else if (isset($parameters["name"])){
        try {
            $contact = $contactService->saveContact($parameters);
            echo "<script>
                      $(document).ready(function(){
                        $('#successCard').removeClass('visually-hidden');
                      });
                  </script>";
        } catch (PDOException $failure) {
            echo "<script>
                      $(document).ready(function(){
                        $('#errorCard').removeClass('visually-hidden');
                        $('#errorMessage').text('".$failure->getCode()."');
                      });          
                  </script>";
        }
    }
    ?>

    <body>
        <div class="container">
            <div class="row py-3">
                <h1>contacty - Die Kontaktverwaltung.</h1>
            </div>
            <div class="row">
                <div class="col">
                    <a href="<?php echo isset($_GET['id']) ? 'listContacts.php' : 'index.php' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#0d6efd" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-lg-6 col-12">
                    <div id="successCard" class="card successCard visually-hidden">
                        <div class="card-body">
                            <h5 class="card-title">Der Kontakt wurde angelegt!</h5>
                            <p class="card-text">Der Kontakt wurde erfolgreich angelegt. Kehre nun zurück zur Startseite, bearbeite den Kontakt oder erstelle noch einen.</p>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" class="btn">Zurück zur Startseite</a>
                            <a href="createOrEditContact.php" class="btn">Neuen Kontakt erstellen</a>
                        </div>
                    </div>
                    <div id="errorCard" class="card errorCard visually-hidden">
                        <div class="card-body">
                            <h5 class="card-title">Der Kontakt konnte nicht angelegt werden!</h5>
                            <p class="card-text">Fehlerbeschreibung:
                                <span id="errorMessage"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-lg-6 col-12">
                    <div class="card borderlessCard">
                        <div class="card-header">
                            <h3 id="formTitle" class="card-title"><?php echo isset($contact) ? "Kontakt ansehen" : "Kontakt anlegen";?></h3>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <form id="contactForm" action="createOrEditContact.php" method="POST">
                                    <div class="form-group formRow">
                                        <input type="hidden" name="id" value="<?php if (isset($_GET["id"])) echo $_GET["id"]; ?>">
                                        <label for="name">Name *</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                value="<?php if (isset($contact) && $contact != null) echo $contact->name() ?>"
´                                               name="name"
                                                id="name" required>
                                    </div>
                                    <div class="form-group formRow">
                                        <label for="phone">Telefonnummer</label>
                                        <input
                                                type="tel"
                                                class="form-control"
                                                value="<?php if (isset($contact) && $contact != null) echo $contact->phone() ?>"
                                                name="phone"
                                                id="phone">
                                    </div>
                                    <div class="form-group formRow">
                                        <label for="mail">Email</label>
                                        <input
                                                type="email"
                                                class="form-control"
                                                value="<?php if (isset($contact) && $contact != null) echo $contact->mail() ?>"
´                                               name="mail"
                                                id="mail">
                                    </div>
                                    <div class="form-group formRow">
                                        <label for="birthday">Geburtstag</label>
                                        <input
                                                type="date"
                                                class="form-control"
                                                value="<?php if (isset($contact) && $contact != null) echo $contact->birthday()->format("Y-m-d")?>"
´                                               name="birthday"
                                                id="birthday"
                                                pattern="\d{2}\.\d{2}\.\d{4}">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><?php echo isset($contact) ? "Speichern" : "Kontakt anlegen";?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-5 pt-5">
                <div class="col-12">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Quellenangabe</li>
                        <li class="list-group-item">Impressum</li>
                        <li class="list-group-item">Datenschutzerklärung</li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>

