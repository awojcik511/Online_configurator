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
					'item_par5'			=>	$_POST["hidden_czestotliwosc"],
					'item_par6'			=>	$_POST["hidden_seria"],
					'item_par7'			=>	$_POST["hidden_model"]
				);
				$_SESSION["shopping_cart"][1] = $item_array;
			}
			else
			{
				echo '<script>alert("Item Already Added")</script>';
				echo '<script>window.location="procesor.php"</script>';
			}
		}
		else
		{
			$item_array = array(
				'item_par1'			=>	$_POST["hidden_table"],
				'item_id'			=>	$_POST["hidden_id"],
				'item_par3'			=>	$_POST["hidden_nazwa"],
				'item_par4'			=>	$_POST["hidden_cena"],
				'item_par5'			=>	$_POST["hidden_czestotliwosc"],
				'item_par6'			=>	$_POST["hidden_seria"],
				'item_par7'			=>	$_POST["hidden_model"]
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
				echo '<script>window.location="procesor.php"</script>';
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
					<li class="filter"> <a class="selected" href="procesor.php" >Procesor</a></li>
					<li class="filter"><a href="ram.php" >Pamięć RAM</a></li>
					<li class="filter"><a href="grafika.php" >Karta graficzna</a></li>
					<li class="filter"><a href="plyta.php" >Płyta główna</a></li>
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
								<td><a href="procesor.php?action=delete&id=<?php echo $values["item_id"]; ?>&table=procesor"><span class="text-danger">Remove</span></a></td>
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
										p.*
									FROM 
										plyta as pg
										JOIN plyta_procesor as pp ON pp.ID_plyta = pg.ID_plyta
										JOIN procesor AS p on p.ID_procesora = pp.ID_procesora
										JOIN plyta_typy_procesorow AS ptp ON pg.ID_plyta = ptp.ID_plyta
										JOIN typy_procesorow AS tp ON tp.ID_typy_procesorow = ptp.ID_typy_procesorow
									WHERE
										p.typ_gniazda LIKE "'.$values["item_par6"].'"
									ORDER BY
										p.ID_procesora ASC';
							}
							else
							{
								$sql="select * from procesor ORDER BY ID_procesora ASC";
							}
						}
					}
					else
					{
						$sql="select * from procesor ORDER BY ID_procesora ASC";
					}
				
				if ($result=mysqli_query($polacz,$sql))
				{
					$row=mysqli_num_rows($result);
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
					{
			?>
						
							
						<li class="mix <?php echo $row["nazwa"]; ?> <?php echo $row["producent"]; ?> <?php echo $row["cena"]; ?> <?php echo $row["typ_procesora"]; ?> <?php echo $row["typ_gniazda"]; ?> <?php echo $row["dolaczony_wentylator"]; ?> <?php echo $row["zintegrowana_karta_graficzna"]; ?>">
							<form method="post" action="procesor.php?action=add&id=<?php echo $row["ID_procesora"]; ?>&table=procesor">
							<div class="card-panel hoverable">
								<img src="<?php echo $row["zdjecie"]; ?>" width="100%" height="100%"> <br/>
								<h5 class="center"> <u> <?php echo $row["nazwa"]; ?></u> </h5>
								<p class="light">
									<table style="height: 300px;" >
										<tr>
											<td>
												<b>Cena: </b> <?php echo $row["cena"]; ?> zł <br>
												<b>Typ procesora: </b> <?php echo str_replace('_', ' ', $row["typ_procesora"]); ?><br>
												<b>Częstotliwość: </b><?php echo $row["czestotliwosc"]; ?><br>
												<b>Seria: </b><?php echo $row["seria"]; ?><br>
												<b>Model procesora: </b><?php echo $row["model_procesora"]; ?><br>
												<b>Typ gniazda: </b><?php echo str_replace('_', ' ', $row["typ_gniazda"]); ?><br>
												<b>Ilość rdzeni: </b><?php echo $row["ilosc_rdzeni"]; ?><br>
												<b>Ilość wątków: </b><?php echo $row["ilosc_watkow"]; ?><br>
												<b>Proces technologiczny: </b><?php echo $row["proces_technologiczny"]; ?><br>
												<b>Pojemnosc cache: </b><?php echo $row["pojemnosc_cache"]; ?><br>
												<b>Zintegrowana karta graficzna: </b><?php if($row["zintegrowana_karta_graficzna"]==true){echo("Tak");}else{echo("Nie");}?> <br>
												<b>Uklad graficzny procesora: </b><?php echo $row["uklad_graficzny_procesora"]; ?><br>
												<b>Taktowanie zintegrowanej grafiki: </b><?php echo $row["taktowanie_grafiki"]; ?><br>
												<b>Dołączony wentylator: </b><?php if($row["dolaczony_wentylator"]==true){echo("Tak");}else{echo("Nie");}?> <br>
											</td>
										</tr>
									</table>
								</p>
								<input type="hidden" name="hidden_table" value="procesor"/>
								<input type="hidden" name="hidden_id" value="<?php echo $row["ID_procesora"]; ?>"/>
								<input type="hidden" name="hidden_nazwa" value="<?php echo $row["nazwa"]; ?>" />
								<input type="hidden" name="hidden_cena" value="<?php echo $row["cena"]; ?>" />
								<input type="hidden" name="hidden_czestotliwosc" value="<?php echo $row["czestotliwosc"]; ?>" />
								<input type="hidden" name="hidden_seria" value="<?php echo $row["seria"]; ?>" />
								<input type="hidden" name="hidden_model" value="<?php echo $row["model_procesora"]; ?>" />
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
		</section> <!-- cd-gallery -->

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
							<option value=".AMD">AMD</option>
							<option value=".Intel">Intel</option>
						</select>				
					</ul>
				</div>
				
				<div class="cd-filter-block input-field col s12">
					<h4>Typ procesora</h4>
					<ul class="cd-filter-content cd-filters list ">
						<select class="filter input-field" name="selectThis" id="selectThis">
							<option value="" selected>Typ procesora</option>
							<option value=".AMD_Athlon">AMD Athlon</option>
							<option value=".AMD_Ryzen">AMD Ryzen</option>
							<option value=".Intel_Core_i3">Intel Core i3</option>
							<option value=".Intel_Core_i5">Intel Core i5</option>
							<option value=".Intel_Core_i7">Intel Core i7</option>
							<option value=".Pentium">Intel Pentium</option>
						</select>				
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

				<div class="cd-filter-block switch">
					<h4>Dołączony wentylator</h4>
					<ul class="cd-filter-content cd-filters list">
				<label>
				<input class="filter" data-filter=".1" type="checkbox" id="checkboxlab1">
				<span class="lever" for="checkboxlab1"></span>
				Wentylator
				</label>
				</ul>
				</div>
				
				<div class="cd-filter-block switch">
				<h4>Zintegrowana karta graficzna</h4>
				<ul class="cd-filter-content cd-filters list">
				<label>
				<input class="filter" data-filter=".1" type="checkbox" id="checkboxlab">
				<span class="lever" for="checkboxlab"></span>
				Tak
				</label>
				</ul>
				</div>
					
				<div class="cd-filter-block switch">
				<h4>Pozostałe</h4>
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