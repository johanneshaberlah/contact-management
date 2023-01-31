<!DOCTYPE html>
<html lang="de">
    <head>
      <title> Kontakt erstellen</title>
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
            $('#tagTable').DataTable({
                "language": {
                    "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
                    "zeroRecords": "Es wurden keine Kontakte gefunden.",
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
                <h1> Kontaktverwaltung</h1>
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
                <div class="col-12">
                    <table id="tagTable" class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Farbe</th>
                            <th>Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        use ContactManagement\TagService;

                        require_once 'ContactManagement/Tag/TagService.php';
                        $tagService = TagService::create();
                        $tags = $tagService->findAll();
                        foreach ($tags as $tag) {
                            echo "<tr>";
                            echo "<td>" . ($tag->name() ? $tag->name() : "-") . "</td>";
                            if ($tag->color() != null){
                                echo "<td><span class='evaluateColor badge' style='background-color: " . $tag->color() . ";'>" . $tag->color() . "</span></td>";
                            } else {
                                echo "<td>-</td>";
                            }
                            echo "<td>
                                    <a class='btn btn-primary' href='createOrEditTag.php?id=" . $tag->id() . "'>Anzeigen</a>
                                    <a class='btn btn-danger' href='deleteTag.php?id=" . $tag->id() . "' style='margin-left: 0.5rem' class='btn btn-danger'>Löschen</a>
                                </td>";
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
                        <li class="list-group-item">Impressum</li>
                        <li class="list-group-item">Datenschutzerklärung</li>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            function evaluateTextColor(hex) {
                let r = parseInt(hex.substring(0,2), 16);
                let g = parseInt(hex.substring(2,4), 16);
                let b = parseInt(hex.substring(4,6), 16);

                let luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

                if (luminance > 0.5) {
                    return 'black';
                } else {
                    return 'white';
                }
            }

            $(document).ready(function () {
                // find all elements with class evaluateColor
                $('.evaluateColor').each(function () {
                    let color = $(this).text();
                    let textColor = evaluateTextColor(color.substring(1));
                    $(this).attr('style', $(this).attr('style') + '; color: ' + textColor + ';');
                });
            });
        </script>
    </body>
</html>

