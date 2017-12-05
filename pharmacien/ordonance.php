<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Ordo'Num</title>
    <link rel="stylesheet" href="/css/roboto.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>
  </head>
  <body>
      <main class="mdl-layout__content mdl-color--grey-100 medecin">
        <div class="content">
          <h1>Chercher une ordonnance</h1>
          <span class="state-one">
            <input type="text" id="uuidInp" placeholder="Entrer l'identifiant de l'utilisateur" />
            <button id="validUUID">Valider</button>
          </span>
        </div>
      </main>
      <div id="searchMed" style="display:none;">
        <div class="contentMed" id="ordoListDisp"></div><button id="cancel">Annuler</button>
      </div>
      <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="/pharmacien/js/ordonance.js"></script>
  </body>
</html>
