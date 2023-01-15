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
    use ContactManagement\TagService;

    require_once "ContactManagement/Tag/TagService.php";

    $tagService = TagService::create();
    $parameters = $_POST;

    if (isset($_GET["id"])) {
        $tag = $tagService->findById($_GET);
    } else if (isset($parameters["name"])){
        try {
            $tag = $tagService->saveTag($parameters);
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
                            <h5 class="card-title">Der Tag wurde gespeichert!</h5>
                            <p class="card-text">Der Tag wurde erfolgreich gespeichert. Kehre nun zurück zur Startseite.</p>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" class="btn">Zurück zur Startseite</a>
                        </div>
                    </div>
                    <div id="errorCard" class="card errorCard visually-hidden">
                        <div class="card-body">
                            <h5 class="card-title">Der Tag konnte nicht gespeichert werden!</h5>
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
                            <h3 id="formTitle" class="card-title"><?php echo isset($tag) ? "Tag ansehen" : "Tag anlegen";?></h3>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <form id="contactForm" action="createOrEditTag.php" method="POST">
                                    <div class="form-group mb-4">
                                        <input type="hidden" name="id" value="<?php if (isset($_GET["id"])) echo $_GET["id"]; ?>">
                                        <label for="name">Name *</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                value="<?php if (isset($tag) && $tag != null) echo $tag->name() ?>"
´                                               name="name"
                                                id="name" required>
                                    </div>
                                    <div class="form-group  mb-4">
                                        <label for="color">Farbe *</label>
                                        <input
                                                type="color"
                                                class="form-control form-control-color"
                                                value="<?php if (isset($tag) && $tag != null) echo $tag->color() ?>"
                                                name="color"
                                                id="color"
                                                required>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><?php echo isset($tag) ? "Speichern" : "Tag anlegen";?></button>
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

