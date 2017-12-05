<!DOCTYPE html>
	<br>
	<?php
	$raw = $bdd->query('SELECT * FROM ordonance WHERE usetime<>0 AND idUser=' . $_SESSION['idUser']);
	if (empty($raw))
	{
		echo "<center><h5>Aucune ordonnance en cours</h5>";
	}
	else
	{
		echo "<center><h5><u>Ordonnances en cours :</u></h5>";
	}
	while ($data = $raw->fetch())
		{
		$medecinraw = $bdd->query('SELECT * FROM user WHERE idUser=' . $data['idMedecin'] );
		$medecin = $medecinraw->fetch();
		echo "<br><p> Medecin : " . $medecin['firstName'] . " " . $medecin['lastName'];
		echo "  Date : " . $data['dateCrea'] . " - " . $data['endDate'] . "   Nombre d'utilisation restante : " . $data['usetime'] . "</p></center>";
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
		$medocname = $medocrawname->fetch()
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
	<?php
	$raw = $bdd->query('SELECT * FROM ordonance WHERE usetime=0 AND idUser=' . $_SESSION['idUser']);
	if (empty($raw))
	{
		echo "<center><h5>Aucune ordonnance déjà utilisé</h5>";
	}
	else
	{
		echo "<center><h5><u>Ordonnances déjà utilisé :</u></h5>";
	}
	while ($data = $raw->fetch())
		{
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
		$medocname = $medocrawname->fetch()
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
</html>
