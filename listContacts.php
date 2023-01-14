<!DOCTYPE html>
<html lang="de">
    <head>
      <title>contacty - Kontakt erstellen</title>
        <script src="assets/scripts/jquery-3.6.3.min.js"></script>
        <script src="assets/scripts/jquery.dataTables.min.js"></script>
        <script src="assets/scripts/dataTables.bootstrap5.min.js"></script>
        <link
            href="assets/stylesheets/bootstrap.min.css"
            rel="stylesheet">
        <link
            href="assets/stylesheets/dataTables.bootstrap5.min.css"
            rel="stylesheet">
        <link
            href="assets/stylesheets/reset.css"
            rel="stylesheet">
        <link
            href="assets/stylesheets/style.css"
            rel="stylesheet">
    </head>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "language": {
                    "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
                    "zeroRecords": "Es wurden keine Kontakte gefunden..",
                    "info": "Seite _PAGE_ von _PAGES_",
                    "infoEmpty": "Zu deinem aktuellen Filter wurden keine Einträge gefunden.",
                    "infoFiltered": "",
                    "search": "Suche:",
                    "paginate": {
                        "first": "Erste",
                        "last": "Letzte",
                        "next": "Nächste",
                        "previous": "Vorherige"
                    }
                }
            });
        });
    </script>
    <body>
        <div class="container">
            <div class="row py-3">
                <h1>contacty - Die Kontaktverwaltung.</h1>
            </div>
            <div class="row">
                <div class="col lg-12">
                    <a href="index.php">
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
                            <p class="card-text">Der Kontakt wurde erfolgreich angelegt. Kehre nun zurück zur Startseite oder sehe dir die Detailseite an.</p>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" class="btn">Zurück zur Startseite</a>
                            <a href="createOrEditContact.php?id=<?php if (isset($contact) && $contact != null) echo $contact->id()  ?>" class="btn">Zur Detailseite</a>
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
                <div class="col-12">
                    <table id="example" class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Telefonnummer</th>
                            <th>Mail</th>
                            <th>Geburtstag</th>
                            <th>Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        require 'ContactManagement/ContactService.php';
                        $contactService = ContactManagement\ContactService::create();
                        $contacts = $contactService->findAll();
                        foreach ($contacts as $contact) {
                            echo "<tr>";
                            echo "<td>" . $contact->name() . "</td>";
                            echo "<td>" . $contact->phone() ?? "-" . "</td>";
                            echo "<td>" . $contact->mail() ?? "-" . "</td>";
                            echo "<td>" . ($contact->birthday() ? $contact->birthday()->format("d.m.Y") : "-") . "</td>";
                            echo "<td><a class='btn btn-primary' href='createOrEditContact.php?id=" . $contact->id() . "'>Anzeigen</a> </td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>

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

