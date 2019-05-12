<?php
	session_start();
	$polacz=mysqli_connect('localhost','root','','poczatkowy');

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
					'item_par5'			=>	$_POST["hidden_wielkosc_ram"],
					'item_par6'			=>	$_POST["hidden_typ_zlacza"],
					'item_par7'			=>	$_POST["hidden_producent_chipsetu"]
				);
				$_SESSION["shopping_cart"][3] = $item_array;
			}
			else
			{
				echo '<script>alert("Item Already Added")</script>';
				echo '<script>window.location="grafika.php"</script>';
			}
		}
		else
		{
			$item_array = array(
				'item_par1'			=>	$_POST["hidden_table"],
				'item_id'			=>	$_POST["hidden_id"],
				'item_par3'			=>	$_POST["hidden_nazwa"],
				'item_par4'			=>	$_POST["hidden_cena"],
				'item_par5'			=>	$_POST["hidden_wielkosc_ram"],
				'item_par6'			=>	$_POST["hidden_typ_zlacza"],
				'item_par7'			=>	$_POST["hidden_producent_chipsetu"]
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
				echo '<script>window.location="grafika.php"</script>';
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
					<li class="filter"><a class="selected" href="poczatkowy.php" >Wszystkie</a></li>
					<li class="filter"><a href="laptopy.php" >Laptopy</a></li>
					<li class="filter"><a href="pc.php" >Komputery stacjonarne</a></li>
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
										<td><a href="grafika.php?action=delete&id=<?php echo $values["item_id"]; ?>&table=grafika"><span class="text-danger">Remove</span></a></td>
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
										g.*
									FROM 
										plyta as pg
										JOIN plyta_grafika as pgg ON pgg.ID_plyta = pg.ID_plyta
										JOIN grafika AS g ON g.ID_grafiki = pgg.ID_grafiki
									WHERE
										LOCATE( g.typ_zlacza, "'.$values["item_par8"].'") > 0
									ORDER BY 
										g.ID_grafiki ASC';
									
								}
								else
								{
									$sql="select * from grafika  ORDER BY ID_grafiki ASC";
								}
							}
						}
						else
						{
							$sql="select * from grafika ORDER BY ID_grafiki ASC";
						}
					
					if ($result=mysqli_query($polacz,$sql))
					{
						$row=mysqli_num_rows($result);
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
						{
				?>
							<li class="mix <?php echo $row["nazwa"]; ?> <?php echo $row["producent"]; ?> <?php echo $row["cena"]; ?> <?php echo $row["producent_chipsetu"]; ?> <?php echo $row["typ_zastosowanej_pamieci"]; ?> <?php echo $row["typ_zlacza"]; ?> <?php echo $row["wsparcie_HDCP"]; ?> <?php echo $row["wsparcie_CUDA"]; ?> <?php echo $row["technologia_VR"]; ?> <?php echo $row["wielkosc_ram"]; ?>">
								<form method="post" action="grafika.php?action=add&id=<?php echo $row["ID_grafiki"]; ?>&table=grafika">
								<div class="card-panel hoverable"> 
									<img src="<?php echo $row["zdjecie"]; ?>" width="100%" height="100%"> <br/>
									<h5 class="center"> <u> <?php echo $row["nazwa"]; ?></u> </h5>
									<table style="height: 100px;" >
										<tr>
											<td>
												<p class="light">
													<b>Producent: </b><?php echo $row["producent"]; ?> <br>
													<b>Cena: </b><?php echo $row["cena"]; ?> zł <br>
													<b>Producent chipsetu: </b><?php echo $row["producent_chipsetu"]; ?><br>
													<b>Typ zastosowanej pamięci: </b><?php echo $row["typ_zastosowanej_pamieci"]; ?><br>
													<b>Typ złącza: </b><?php echo $row["typ_zlacza"]; ?><br>
													<b>Wielkość pamięci RAM: </b><?php echo $row["wielkosc_ram"]; ?><br>
												</p>
											</td>
										</tr>
									</table>
									<input type="hidden" name="hidden_table" value="grafika"/>
									<input type="hidden" name="hidden_id" value="<?php echo $row["ID_grafiki"]; ?>"/>
									<input type="hidden" name="hidden_nazwa" value="<?php echo $row["nazwa"]; ?>" />
									<input type="hidden" name="hidden_cena" value="<?php echo $row["cena"]; ?>" />
									<input type="hidden" name="hidden_wielkosc_ram" value="<?php echo $row["wielkosc_ram"]; ?>" />
									<input type="hidden" name="hidden_typ_zlacza" value="<?php echo $row["typ_zlacza"]; ?>" />
									<input type="hidden" name="hidden_producent_chipsetu" value="<?php echo $row["producent_chipsetu"]; ?>" />
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
							<option value=".Asus">Asus</option>
							<option value=".Gigabyte">Gigabyte</option>
							<option value=".MSI">MSI</option>
							<option value=".Sapphire">Sapphire</option>
							<option value=".Palit">Palit</option>
						</select>				
					</ul>
				</div>
				
				<div class="cd-filter-block input-field col s12">
					<h4>Producent chipsetu</h4>
					<ul class="cd-filter-content cd-filters list ">
						<select class="filter input-field" name="selectThis" id="selectThis">
								<option value="" selected>Producent chipsetu</option>
								<option value=".AMD">AMD</option>
								<option value=".NVIDIA">NVIDIA</option>
						</select>				
					</ul>
				</div>
				
				<div class="cd-filter-block input-field col s12">
					<h4>Typ zastosowanej pamięci</h4>
					<ul class="cd-filter-content cd-filters list ">
						<select class="filter input-field" name="selectThis" id="selectThis" multiple>
							<option value=".GDDR3">GDDR3</option>
							<option value=".GDDR4">GDDR4</option>
							<option value=".GDDR5X">GDDR5X</option>
							<option value=".GDDR5">GDDR5</option>
						</select>				
					</ul>
					</div>

				<div class="cd-filter-block switch">
				<h4>Wsparcie CUDA</h4>
				<ul class="cd-filter-content cd-filters list">
				<label>
				<input class="filter" data-filter=".1" type="checkbox" id="checkboxlab1">
				<span class="lever" for="checkboxlab1"> </span> Tak
				</label>
				</ul>
				</div>
				
				<div class="cd-filter-block switch">
				<h4>Wsparcie HDCP</h4>
				<ul class="cd-filter-content cd-filters list">
				<label>
				<input class="filter" data-filter=".1" type="checkbox" id="checkboxlab2">
				<span class="lever" for="checkboxlab2"> </span> Tak
				</label>
				</ul>
				</div>
				
				<div class="cd-filter-block switch">
				<h4>Wsparcie dla VR</h4>
				<ul class="cd-filter-content cd-filters list">
				<label>
				<input class="filter" data-filter=".1" type="checkbox" id="checkboxlab3">
				<span class="lever" for="checkboxlab3"> </span> Tak
				</label>
				</ul>
				</div>
				
					
				<div class="cd-filter-block switch">
				<h4>Pozostałe</h4>
				<ul class="cd-filter-content cd-filters list">
					
					
					<p class="range-field">
		 Ilość rdzeni
		<input type="range" id="test5" value="cena" min="0" max="10" />
		</p>
		<p class="range-field">
		 Częstotliwość taktowania procesora w MHz
		<input type="range" id="test5" value="cena" min="0" max="4000" />
		</p>	
		<p class="range-field">
		 Pojemność pamięci cache w kb
		<input type="range" id="test5" value="cena" min="0" max="10000" />
		</p>
		<p class="range-field">
		 Maksymalny pobór mocy w W
		<input type="range" id="test5" value="cena" min="0" max="150" />
		</p>

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