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
					'item_par6'			=>	$_POST["hidden_gniazdo_procesora"],
					'item_par7'			=>	$_POST["hidden_typ_obslugiwanej_pamieci"],
					'item_par8'			=>	$_POST["hidden_pci"],
					'item_par9'			=>	$_POST["hidden_zlacze_dyskow"],
					'item_par10'		=>	$_POST["hidden_wtyczka_zasilania"],
				'item_par11'			=>	$_POST["hidden_standard"],
				);
				$_SESSION["shopping_cart"][4] = $item_array;
			}
			else
			{
				echo '<script>alert("Item Already Added")</script>';
				echo '<script>window.location="ram.php"</script>';
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
				'item_par6'			=>	$_POST["hidden_gniazdo_procesora"],
				'item_par7'			=>	$_POST["hidden_typ_obslugiwanej_pamieci"],
				'item_par8'			=>	$_POST["hidden_pci"],
				'item_par9'			=>	$_POST["hidden_zlacze_dyskow"],
				'item_par10'		=>	$_POST["hidden_wtyczka_zasilania"],
				'item_par11'			=>	$_POST["hidden_standard"],
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
				echo '<script>window.location="plyta.php"</script>';
			}
		}
	}
}
?>
<!doctype html>
<html lang="en" class="no-js">
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
					<li class="filter"><a class="selected" href="plyta.php" >Płyta główna</a></li>
					<li class="filter"><a href="dysk.php" >Dyski twarde </a></li>
					<li class="filter"><a href="zasilacz.php" >Zasilacz </a></li>
					<li class="filter"><a href="obudowa.php" >Obudowa </a></li>
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
									<td><?php echo $values["item_par6"];?></td>
									<td><?php echo $values["item_par7"];?></td>
									<td><a href="plyta.php?action=delete&id=<?php echo $values["item_id"]; ?>&table=plyta"><span class="text-danger">Remove</span></a></td>
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
					$sql="select * from plyta ORDER BY ID_plyta ASC";
					if ($result=mysqli_query($polacz,$sql))
					{
						$row=mysqli_num_rows($result);
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
						{
				?>
				
						<li class="mix <?php echo $row["nazwa"]; ?> <?php echo $row["producent"]; ?> <?php echo $row["cena"]; ?> <?php echo $row["standard_plyty"]; ?> <?php echo $row["gniazdo_procesora"]; ?> <?php echo $row["chipset"]; ?>">
							<form method="post" action="plyta.php?action=add&id=<?php echo $row["ID_plyta"]; ?>&table=plyta">
								<div class="card-panel hoverable"> 
									<img src="<?php echo $row["zdjecie"]; ?>" width="100%" height="100%"> <br/>
									<h5 class="center"> <u> <?php echo $row["nazwa"]; ?></u> </h5>
									<table style="height: 400px;" >
										<tr>
											<td>
												<p class="light">
													<b>Cena: </b><?php echo $row["cena"]; ?> zł <br>
													<b>Producent: </b><?php echo $row["producent"]; ?><br>
													<b>Standard płyty głównej: </b><?php echo $row["standard_plyty"]; ?><br>
													<b>Gniazdo procesora: </b><?php echo $row["gniazdo_procesora"]; ?><br>
													<b>Chipset: </b><?php echo str_replace('_', ' ', $row["chipset"]); ?><br>
													<b>Obsługa Crossfire: </b><?php echo $row["crossfire"]; ?><br>
													<b>Obsługa SLI: </b><?php echo $row["sli"]; ?><br>
													<b>Typ obsługiwanej pamięci: </b><?php echo $row["typ_obslugiwanej_pamieci"]; ?><br>
													<b>Maksymalna pojemność pamięci: </b><?php echo $row["maks_pojemnosc_pamieci"]; ?><br>
													<b>Obsługa RAID: </b><?php echo $row["obsluga_raid"]; ?><br>
													<b>Karta sieciowa: </b><?php echo $row["karta_sieciowa"]; ?><br>
													<b>Karta dźwiękowa: </b><?php echo $row["karta_dzwiekowa"]; ?><br>
													<b>Złącza tylne: </b><?php echo $row["zlacza_tylne"]; ?><br>
													<b>Wtyczka zasilania: </b><?php echo $row["wtyczka_zasilania"]; ?><br>
													<b>Gniazda PCI: </b><?php echo $row["PCI"]; ?><br>
													<b>Złącza dysków/napedów: </b><?php echo $row["zlacze_dyskow"]; ?><br>
												</p>
											</td>
										</tr>
									</table>
									<input type="hidden" name="hidden_table" value="plyta"/>
									<input type="hidden" name="hidden_id" value="<?php echo $row["ID_plyta"]; ?>"/>
									<input type="hidden" name="hidden_nazwa" value="<?php echo $row["nazwa"]; ?>" />
									<input type="hidden" name="hidden_cena" value="<?php echo $row["cena"]; ?>" />
									<input type="hidden" name="hidden_standard" value="<?php echo $row["standard_plyty"]; ?>" />
									<input type="hidden" name="hidden_gniazdo_procesora" value="<?php echo $row["gniazdo_procesora"]; ?>" />
									<input type="hidden" name="hidden_typ_obslugiwanej_pamieci" value="<?php echo $row["typ_obslugiwanej_pamieci"]; ?>" />
									<input type="hidden" name="hidden_pci" value="<?php echo $row["PCI"]; ?>" />
									<input type="hidden" name="hidden_zlacze_dyskow" value="<?php echo $row["zlacze_dyskow"]; ?>" />
									<input type="hidden" name="hidden_wtyczka_zasilania" value="<?php echo $row["wtyczka_zasilania"]; ?>" />
									<center>
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
							<option value=".MSI">MSI</option>
							<option value=".ASUS">ASUS</option>
							<option value=".Gigabyte">Gigabyte</option>
							<option value=".ASRock">ASRock</option>
						</select>				
					</ul>
				</div>
				
				<div class="cd-filter-block">
					<h4>Standard płyty</h4>
					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".BT" type="checkbox" id="checkbox1">
			    			<label class="checkbox-label" for="checkbox1"><span>BT</span></label>
						</li>
						<li>
							<input class="filter" data-filter=".ATX" type="checkbox" id="checkbox2">
							<label class="checkbox-label" for="checkbox2">ATX</label>
						</li>
						<li>
							<input class="filter" data-filter=".micro-ATX" type="checkbox" id="checkbox3">
			    			<label class="checkbox-label" for="checkbox3"><span>micro-ATX</span></label>
						</li>
					</ul>
				</div>		

				<div class="cd-filter-block input-field col s12">
					<h4>Gniazdo procesora</h4>
					<ul class="cd-filter-content cd-filters list ">
						<select class="filter input-field" name="selectThis" id="selectThis" multiple>
							<option value=".1151">Socket 1151</option>
							<option value=".2066">Socket 2066</option>
							<option value=".AM3+">Socket AM3+</option>
							<option value=".AM4">Socket AM4</option>
							<option value=".FM2">Socket FM2</option>
							<option value=".TR4">Socket TR4</option>
						</select>				
					</ul>
					</div>
				
				
			<div class="cd-filter-block">
					<h4>Typ chipsetu</h4>
					<ul class="cd-filter-content cd-filters list">
						<select class="filter" name="selectThis" id="selectThis">
							<option value="" selected>Typ chipsetu</option>
							<option value=".AMD_A320">AMD A320</option>
							<option value=".Intel_Z370">Intel Z270</option>
							<option value=".AMD_990X">AMD 990X</option>
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