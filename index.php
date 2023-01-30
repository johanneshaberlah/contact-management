<!DOCTYPE html>
<html lang="de">
    <head>
      <title> Kontaktverwaltung</title>
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
                <div class="jumbotron">
                    <h1 class="display-4">Kontaktverwaltung</h1>
                    <p class="lead">Bring jetzt Ordnung in deine Bekanntschaften!</p>
                    <hr class="my-4">
                    <p class="lead">
                        <a class="btn btn-primary shadow" href="listContacts.php" role="button">Deine Kontakte</a>
                        <a class="btn btn-primary shadow" href="createOrEditContact.php" role="button">Kontakt erstellen</a>
                    </p>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-lg-6 col-12">
                    <div class="card shadow borderlessCard">
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

                                    require_once "ContactManagement/Contact/ContactService.php";
                                    $contactService = ContactService::create();

                                    try {
                                        $contacts = $contactService->randomContacts();
                                        foreach ($contacts as $contact){
                                            echo "<tr>
                                                    <td>" . substr($contact->name(), 0, 16) . "</td>
                                                    <td>" . ($contact->phone() ? $contact->phone() : "-") . "</td>
                                                    <td>" . ($contact->mail() ? substr($contact->mail(), 0, 16) : "-")  . "</td>
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
            <div class="row py-3">
                <div class="col-lg-6 col-12">
                    <div class="card borderlessCard shadow">
                        <div class="card-body">
                            <h5 class="card-title">Probier doch mal Tags!</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Schnellzugriff</h6>
                            <p class="card-text">Hier kannst du Tags erstellen oder deine aktuellen Tags ansehen und bearbeiten. So kannst du deine Kontakte sortieren.</p>
                            <a href="listTags.php" class="btn btn-primary">Tags</a>
                            <a href="createOrEditTag.php" class="btn btn-primary">Tag erstellen</a>
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

