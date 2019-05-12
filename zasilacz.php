<?php
	session_start();
	$polacz=mysqli_connect('localhost','root','','online_shop');

	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(isset($_POST["add_to"]))
	{
		if(isset($_SESSION["shopping_cart"]))
		{
			$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
			$item_array_table = array_column($_SESSION["shopping_cart"], "item_par1");
			if(!(in_array($_GET["id"], $item_array_id) AND in_array($_GET["table"], $item_array_table)))
			{
				$count = count($_SESSION["shopping_cart"]);
				$item_array = array(
					'item_par1'			=>	$_POST["hidden_table"],
					'item_id'			=>	$_POST["hidden_id"],
					'item_par3'			=>	$_POST["hidden_nazwa"],
					'item_par4'			=>	$_POST["hidden_cena"],
					'item_par5'			=>	$_POST["hidden_standard"],
					'item_par6'			=>	$_POST["hidden_moc"],
					'item_par7'			=>	$_POST["hidden_ilosc_wentylatorow"]
				);
				$_SESSION["shopping_cart"][6] = $item_array;
			}
			else
			{
				echo '<script>alert("Item Already Added")</script>';
				echo '<script>window.location="zasilacz.php"</script>';
			}
		}
		else
		{
			$item_array = array(
				'item_par1'			=>	$_POST["hidden_table"],
				'item_id'			=>	$_POST["hidden_id"],
				'item_par3'			=>	$_POST["hidden_nazwa"],
				'item_par4'			=>	$_POST["hidden_cena"],
				'item_par5'			=>	$_POST["hidden_standard"],
				'item_par6'			=>	$_POST["hidden_moc"],
				'item_par7'			=>	$_POST["hidden_ilosc_wentylatorow"]
			);
			$_SESSION["shopping_cart"][0] = $item_array;
		}
	}
	if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if(($values["item_id"] == $_GET["id"]) AND ($values["item_par1"] == $_GET["table"]))
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>window.location="zasilacz.php"</script>';
			}
		}
	}
}
?>
<!doctype html>
<html lang="pl" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="css/search.css"> <!-- Resource style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  	
  	
	<title>Nasz sklep</title>
</head>
<body>
	<header class="cd-header">
		<h1><img src="img/logokonfigurator.png"></h1>
	</header>

	<main class="cd-main-content">
		<div class="cd-tab-filter-wrapper">
			<div class="cd-tab-filter">
				<ul class="cd-filters">
					<li class="placeholder"> 
						<a data-type="all" href="#0">Komponenty</a> <!-- selected option on mobile -->
					</li> 
					<li class="filter"> <a href="procesor.php" >Procesor</a></li>
					<li class="filter"><a href="ram.php" >Pamięć RAM</a></li>
					<li class="filter"><a href="grafika.php" >Karta graficzna</a></li>
					<li class="filter"><a href="plyta.php" >Płyta główna</a></li>
					<li class="filter"><a href="dysk.php" >Dyski twarde </a></li>
					<li class="filter"><a class="selected" href="zasilacz.php" >Zasilacz </a></li>
					<li class="filter" ><a href="obudowa.php" >Obudowa </a></li>
				</ul> <!-- cd-filters -->
			</div> <!-- cd-tab-filter -->
		</div> <!-- cd-tab-filter-wrapper -->
		
			
				
		<section class="cd-gallery">	
				<div class="cd-filter-block">
				<h4> Obecnie wybrane komponenty</h4>
					<ul class="cd-filter-content cd-filters list">
						<div class="table-responsive">
							<table class="table table-bordered">
								<tr>
									<th width="5%">Typ urzadzenia</th>
									<th width="15%">Nazwa</th>
									<th width="10%">Cena</th>
									<th width="20%">Par 5</th>
									<th width="15%">Par 6</th>
									<th width="15%">Par 7</th>
									<th width="10%">Usun</th>
								</tr>
								<?php
								if(!empty($_SESSION["shopping_cart"]))
								{
									foreach($_SESSION["shopping_cart"] as $keys => $values)
									{
										
								?>
								<tr>
									<td><?php echo ucfirst($values["item_par1"]); ?></td>
									<td><?php echo $values["item_par3"]; ?></td>
									<td><?php echo $values["item_par4"]; ?></td>
									<td><?php echo $values["item_par5"]; ?></td>
									<td><?php echo $values["item_par6"]; ?></td>
									<td><?php echo $values["item_par7"]; ?></td>
									<td><a href="zasilacz.php?action=delete&id=<?php echo $values["item_id"]; ?>&table=zasilacz"><span class="text-danger">Remove</span></a></td>
								</tr>
								<?php
									}
								}
								?>
							</table>
						</div>
					</ul> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->
			</section>

		<section class="cd-gallery">
			<ul>
				<?php
						if(!empty($_SESSION["shopping_cart"]))
						{
							foreach($_SESSION["shopping_cart"] as $keys => $values)
							{
								if ($values["item_par1"] == "plyta")
								{
									$sql='
									SELECT DISTINCT
										z.*
									FROM 
										plyta as pg
										JOIN plyta_zasilacz AS pgz ON pgz.ID_plyta = pg.ID_plyta
										JOIN zasilacz AS z ON z.ID_zasilacz = pgz.ID_zasilacz
									WHERE
										LOCATE( "'.$values["item_par10"].'", z.wtyczki) > 0;';
									
								}
								else
								{
									$sql="select * from zasilacz  ORDER BY ID_zasilacz ASC";
								}
							}
						}
						else
						{
							$sql="select * from zasilacz ORDER BY ID_zasilacz ASC";
						}
					
					if ($result=mysqli_query($polacz,$sql))
					{
						$row=mysqli_num_rows($result);
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
						{
				?>
							<li class="mix <?php echo $row["nazwa"]; ?> <?php echo $row["producent"]; ?> <?php echo $row["cena"]; ?> <?php echo $row["standard"]; ?>">
								<form method="post" action="zasilacz.php?action=add&id=<?php echo $row["ID_zasilacz"]; ?>&table=zasilacz">
								<div class="card-panel hoverable"> 
									<img src="<?php echo $row["zdjecie"]; ?>" width="100%" height="100%"> <br/>
									<h5 class="center"> <u> <?php echo $row["nazwa"]; ?></u> </h5>
									<table style="height: 300px;" >
										<tr>
											<td>
												<p class="light">
													<b>Cena: </b><?php echo $row["cena"]; ?> zł <br>
													<b>Producent: </b> <?php echo str_replace('_', ' ', $row["producent"]); ?><br>
													<b>Standard: </b><?php echo str_replace('_', '.', $row["standard"]); ?><br>
													<b>Moc:</b><?php echo $row["moc"]; ?><br>
													<b>Filtry: </b><?php echo $row["filtry"]; ?><br>
													<b>Ilość wentylatorów:</b><?php echo $row["ilosc_wentylatorow"]; ?><br>
													<b>Średnica wentylatorów: </b><?php echo $row["srednica_wentylatorow"]; ?><br>
													<b>Szerokość:</b><?php echo $row["szerokosc"]; ?><br>
													<b>Wysokość: </b><?php echo $row["wysokosc"]; ?><br>
													<b>Głębokość:</b><?php echo $row["glebokosc"]; ?><br>
													<b>Dodatkowe informacje: </b><?php echo $row["dodatkowe_informacje"]; ?><br>
												</p>
											</td>
										</tr>
									</table>
									<input type="hidden" name="hidden_table" value="zasilacz"/>
									<input type="hidden" name="hidden_id" value="<?php echo $row["ID_zasilacz"]; ?>"/>
									<input type="hidden" name="hidden_nazwa" value="<?php echo $row["nazwa"]; ?>" />
									<input type="hidden" name="hidden_cena" value="<?php echo $row["cena"]; ?>" />
									<input type="hidden" name="hidden_standard" value="<?php echo $row["standard"]; ?>" />
									<input type="hidden" name="hidden_moc" value="<?php echo $row["moc"]; ?>" />
									<input type="hidden" name="hidden_ilosc_wentylatorow" value="<?php echo $row["ilosc_wentylatorow"]; ?>" />
									<center>
										<br />
										<input type="submit" name="add_to" style="margin-top:5px;" class="btn btn-success" value="Dodaj do zestawu" />
									</center>
								</div>
								</form>
							</li>
				<?php
						}
					}
				?>
				<li class="gap"></li>
				<li class="gap"></li>
				<li class="gap"></li>
			</ul>
		</section>

		<div class="cd-filter">
			<form>
				<div class="cd-filter-block">
					<h4>Wyszukaj po nazwie</h4>					
					<div class="cd-filter-content">
						<input type="search" placeholder="Wpisz nazwę komponentu">
					</div> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->
				
				<div class="cd-filter-block input-field col s12">
					<h4>Producent</h4>
					<ul class="cd-filter-content cd-filters list ">
						<select class="filter input-field" name="selectThis" id="selectThis">
							<option value="" selected>Producent</option>
							<?php
							$sql="
								SELECT DISTINCT producent FROM `zasilacz` ";
							if ($result=mysqli_query($polacz,$sql))
								{
									$row=mysqli_num_rows($result);
									while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
									{
										echo('<option value=".'. $row["producent"].'">'.str_replace('_', ' ', $row["producent"]).'</option>');
									}
							}
							?>

						</select>				
					</ul>
				</div>
				
								
				<div class="cd-filter-block input-field col s12">
					<h4>Standard</h4>
					<ul class="cd-filter-content cd-filters list ">
						<select class="filter input-field" name="selectThis" id="selectThis">
							<option value="" selected>Standard</option>
							<?php
							$sql="
								SELECT DISTINCT standard FROM `zasilacz` ";
							if ($result=mysqli_query($polacz,$sql))
								{
									$row=mysqli_num_rows($result);
									while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
									{
										echo('<option value=".'. $row["standard"].'">'.str_replace('_', ' ', $row["standard"]).'</option>');
									}
							}
							?>

						</select>				
					</ul>
				</div>
				
				
	
			<div class="cd-filter-block">
					<h4>Cena</h4>
					<ul class="cd-filter-content cd-filters list">
					</ul>
				</div>	
	
			</form>

			<a href="#0" class="cd-close" style="background-color: #ff0000;">X</a>
		</div> <!-- cd-filter -->

		<a href="#0" class="cd-filter-trigger"> Wyszukiwanie</a>
	</main> <!-- cd-main-content -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mixitup.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
<script src="js/materialize.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

</body>
</html>