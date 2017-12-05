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
          <h1>Créer une ordonance</h1>
          <form id="listMedicForm" action="/medecin/ordoCreate.php" method="post">
            <input type="text" id="uuid" name="uuid" required placeholder="Identifiant du patient" />
            <input type="number" id="reuse" name="reuse" min="1" required placeholder="Nombre de réutilisation" />
            <input type="hidden" required name="count" id="count" value="0"/>
          </form>
          <table class="list-medic" id="listMedic">
            <thead>
              <tr>
                <td class="text-center">Nom du médicament</td>
                <td class="text-center">Fréquence</td>
                <td class="text-center">Période</td>
                <td class="text-center">Dose</td>
              </tr>
            </thead>
          </table>
          <button class="addMed">Ajouter un medicament</button>
          <button id="valid">Valider l'ordonance</button>
        </div>
      </main>
      <div id="searchMed" style="display:none;">
        <div class="contentMed">
          <input id="medic" required placeholder="Entrer le nom du médicament" />
          <input id="number" required type="number" min="1" max="5" placeholder="Fréquence de prise"/>
          <select id="period">
            <option class="value" value="1" >Par jour</option>
            <option class="value" value="2" >Par semaine</option>
            <option class="value" value="3" >Par mois</option>
          </select>
          <input id="dose" type="text" placeholder="Dose" />
          <button class="addMed" id="validMedoc">Valider</button>
          <button class="cancel" id="cancelMedoc">Annuler</button>
        </div>
      </div>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/medecin/js/addMed.js"></script>
  </body>
</html>
