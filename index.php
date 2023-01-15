<!DOCTYPE html>
<html lang="de">
    <head>
      <title>contacty - Die Kontaktverwaltung</title>
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
    <body>
        <div class="container">
            <div class="row py-3">
                <h1>contacty - Die Kontaktverwaltung.</h1>
            </div>
            <div class="row py-3">
                <div class="col-lg-6 col-12">
                    <div class="card borderlessCard">
                        <div class="card-body">
                            <h5 class="card-title">Herzlich Willkommen!</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Schnellzugriff</h6>
                            <p class="card-text">Bitte wähle eine der unten genannten Funktionen aus. Hier kannst du sowohl Kontakte anlegen als auch die Liste der Kontakte anzeigen.</p>
                            <a href="createOrEditContact.php" class="btn btn-primary">Kontakt anlegen</a>
                            <a href="listContacts.php" class="btn btn-primary">Kontakte anzeigen</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-lg-6 col-12">
                    <div class="card borderlessCard">
                        <div class="card-body">
                            <h5 class="card-title">Kontaktübersicht</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Hier findest du eine Übersicht einiger Kontakte.</h6>
                            <div class="card-text">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Telefon</th>
                                            <th scope="col">Mail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    use ContactManagement\ContactService;
                                    use ContactManagement\Failure\ContactCreationFailure;

                                    require "ContactManagement/ContactService.php";
                                    $contactService = ContactService::create();

                                    try {
                                        $contacts = $contactService->findAll();
                                        foreach ($contacts as $contact){
                                            echo "<tr>
                                                    <td>" . $contact->name() . "</td>
                                                    <td>" . $contact->phone() . "</td>
                                                    <td>" . $contact->mail() . "</td>
                                                  </tr>";
                                        }
                                    } catch (ContactCreationFailure $failure) {
                                        echo "Fehler beim Laden der Kontakte aus der Datenbank. " . $failure->getMessage();
                                    }
                                    ?>
                                    </tbody>
                                </table>
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

