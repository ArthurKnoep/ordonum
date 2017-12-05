<?php
include 'protection.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Ordo'Num</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="images/favicon.png">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->
    <link rel="stylesheet" href="css/roboto.css">
    <link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
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
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Traitement(s) en cours</span>
          <div class="mdl-layout-spacer"></div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
            <label class="mdl-button mdl-js-button mdl-button--icon" for="search">  <!-- barre de recherche -->
	      <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search">
              <label class="mdl-textfield__label" for="search">Enter your query...</label>
            </div>
          </div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
	    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn"> <!-- menu de droite -->
		    <li class="mdl-menu__item"><a class="mdl-navigation__link" href="login/logout">Deconnexion</a></li>
          </ul>
        </div>
      </header>
      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
          <span>
            <img src="<?php
				if (isset($_SESSION["sexeUser"]))
				{
				$sexe = $_SESSION["sexeUser"];
				if ($sexe == 1)
				{
					echo "images/man.png";
				}
				else
				{
					echo "images/woman.png";
				}
				}
				else
				{
					echo "images/man.png";
				}
			?>" class="demo-avatar">
              <?php if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) { echo $_SESSION['firstName'] . " " . $_SESSION['lastName']; } ?>
          </span>
          <div class="demo-avatar-dropdown">
            <span>
              <?php
              if (isset($_SESSION['mail']))
              {
                echo $_SESSION['mail'];
              }
                ?>
              </span>
            <div class="mdl-layout-spacer"></div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
            <a class="mdl-navigation__link" href="/"><i class="fa fa-home fa-2x" aria-hidden="true" style="padding-right: 0.3em;"></i>Accueil</a>
            <a class="mdl-navigation__link" href=""><i class="fa fa-medkit fa-2x" aria-hidden="true" style="padding-right: 0.3em;"></i>Traitement(s) en cours</a>
            <a class="mdl-navigation__link" href="ordonnance"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" style="padding-right: 0.3em;"></i>Ordonnance</a>
	        <a class="mdl-navigation__link" href="dossier"><i class="fa fa-folder-open fa-2x" aria-hidden="true" style="padding-right: 0.3em;"></i>Dossier Médical</a>
            <a class="mdl-navigation__link" href="messagerie"><i class="fa fa-envelope fa-2x" aria-hidden="true" style="padding-right: 0.3em;"></i>Messagerie</a>
			<?php
			if ($_SESSION['typeUser'] == 2 OR $_SESSION['typeUser'] == 3 )
			{
				echo "<a class=\"mdl-navigation__link\" href=\"medicament\"><i class=\"fa fa-plus-square fa-2x\" aria-hidden=\"true\" style=\"padding-right: 0.3em;\"></i>Médicaments</a>";
			}
			?>
          <div class="mdl-layout-spacer"></div>
        </nav>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100">
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<br>
	<center>
	<?php
	$raw = $bdd->query('SELECT * FROM ordonance WHERE idUser=' . $_SESSION['idUser']);
	echo "<center><h5><u>Traitements en cours :</u></h5>";
	while ($data = $raw->fetch())
		{
		$actual = new DateTime();
		$end  = new DateTime($data['endDate']);
		if ($end < $actual)
			continue;
		$medecinraw = $bdd->query('SELECT * FROM user WHERE idUser=' . $data['idMedecin'] );
		$medecin = $medecinraw->fetch();
		echo "<br><p> Medecin : " . $medecin['firstName'] . " " . $medecin['lastName'];
		echo "  Date : " . $data['dateCrea'] . " - " . $data['endDate'] . "</p></center>";
		?>
		<table class="table-fill">
			<thead>
				<tr>
					<th class="text-center">Nom</th>
          <th class="text-center">Fréquence</th>
					<th class="text-center">Dose</th>
				</tr>
			</thead>
		<?php
		$medocraw = $bdd->query('SELECT * FROM itemOrdonance WHERE idOrdonance=' . $data['idOrdonance']);
		while ($medocinfo = $medocraw->fetch())
		{
		$medocrawname = $bdd->query('SELECT * FROM medicament WHERE idMedicament=' . $medocinfo['idMedicament']);
		$medocname = $medocrawname->fetch();
		?>
		<tr>
			<td class="text-center"><?php echo $medocname['name']; ?></td>
      <?php
      if ($medocinfo['period'] == 1) {
        $data = " fois par jour";
      }
      if ($medocinfo['period'] == 2) {
        $data = " fois par semaine";
      }
      if ($medocinfo['period'] == 3) {
        $data = " fois par mois";
      }
      ?>
      <td class="text-center"><?php echo $medocinfo['frequency'] . $data; ?></td>
			<td class="text-center"><?php echo $medocinfo['dose']; ?></td>
		<tr>
		<?php
			}
		?>
		</tbody>
		</table>
	<br>
	<?php
	}
	?>
	<br>
	</center>
	</main>
  </body>
</html>
