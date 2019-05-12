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
					'item_par6'			=>	$_POST["hidden_rodzaj"],
					'item_par7'			=>	$_POST["hidden_przepustowosc"]
				);
				$_SESSION["shopping_cart"][2] = $item_array;
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
				'item_par5'			=>	$_POST["hidden_czestotliwosc"],
				'item_par6'			=>	$_POST["hidden_rodzaj"],
				'item_par7'			=>	$_POST["hidden_przepustowosc"]
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
				echo '<script>window.location="ram.php"</script>';
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
					<li class="filter"><a class="selected" href="ram.php" >Pamięć RAM</a></li>
					<li class="filter"><a href="grafika.php" >Karta graficzna</a></li>
					<li class="filter"><a href="plyta.php" >Płyta główna</a></li>
					<li class="filter"><a href="dysk.php" >Dyski twarde </a></li>
					<li class="filter"><a href="zasilacz.php" >Zasilacz </a></li>
					<li class="filter"><a href="obudowa.php" >Obudowa </a></li>
				</ul> <!-- cd-filters -->
			</div> <!-- cd-tab-filter -->
		</div> <!-- cd-tab-filter-wrapper -->

				
				<?php
					/*if(!empty($_SESSION["shopping_cart"]))
					{
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
							if ($values["item_par1"] == "plyta")
							{
								
							}
						}
					}*/
				?>
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
								<td><a href="ram.php?action=delete&id=<?php echo $values["item_id"]; ?>&table=ram"><span class="text-danger">Remove</span></a></td>
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
									r.*
								FROM 
									plyta as pg
									JOIN plyta_ram AS pgr ON pgr.ID_plyta = pg.ID_plyta
									JOIN ram AS r ON r.ID_ram = pgr.ID_ram
								WHERE
									r.rodzaj LIKE "'.str_replace(" ", "_",$values["item_par7"]).'"
								ORDER BY 
									r.ID_ram ASC';
							}
							else
							{
								$sql="select * from ram ORDER BY ID_ram ASC";
							}
						}
					}
					else
					{
						$sql="select * from ram ORDER BY ID_ram ASC";
					}
				
				if ($result=mysqli_query($polacz,$sql))
				{
					$row=mysqli_num_rows($result);
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
					{
			?>
						<li class="mix <?php echo $row["nazwa"]; ?> <?php echo $row["producent"]; ?> <?php echo $row["cena"]; ?> <?php echo $row["rodzaj"]; ?> <?php echo $row["pojemnosc"]; ?> <?php echo $row["czestotliwosc"]; ?> <?php echo $row["przepustowosc"]; ?>">
							<form method="post" action="ram.php?action=add&id=<?php echo $row["ID_ram"]; ?>&table=ram">
								<div class="card-panel hoverable"> 
									<img src="<?php echo $row["zdjecie"]; ?>" width="100%" height="100%"> <br/>
									<h5 class="center"> <u> <?php echo $row["nazwa"]; ?></u> </h5>
									<table style="height: 100px;" >
										<tr>
											<td>
												<p class="light">
													<b>Cena: </b><?php echo $row["cena"]; ?> zł <br>
													<b>Producent: </b><?php echo str_replace('_', '.', $row["producent"]); ?><br>
													<b>Pojemność: </b><?php echo $row["pojemnosc"]; ?><br>
													<b>Rodzaj: </b><?php echo str_replace('.', ' ', $row["rodzaj"]); ?><br>
													<b>Częstotliwość: </b><?php echo $row["czestotliwosc"]; ?><br>
													<b>Przepustowość: </b><?php echo $row["przepustowosc"]; ?><br>
													<br /> <br />
												</p>
											</td>
										</tr>
									</table>
									<input type="hidden" name="hidden_table" value="ram"/>
									<input type="hidden" name="hidden_id" value="<?php echo $row["ID_ram"]; ?>"/>
									<input type="hidden" name="hidden_nazwa" value="<?php echo $row["nazwa"]; ?>" />
									<input type="hidden" name="hidden_cena" value="<?php echo $row["cena"]; ?>" />
									<input type="hidden" name="hidden_rodzaj" value="<?php echo str_replace('_', ' ', $row["rodzaj"]); ?>" />
									<input type="hidden" name="hidden_czestotliwosc" value="<?php echo $row["czestotliwosc"]; ?>" />
									<input type="hidden" name="hidden_przepustowosc" value="<?php echo $row["przepustowosc"]; ?>" />
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
							<option value=".Kingston">Kingston</option>
							<option value=".G_SKILL">G.SKILL</option>
							<option value=".Ballistix">Ballistix </option>
							<option value=".GoodRam">GoodRam </option>
						</select>				
					</ul>
				</div>
				
				<div class="cd-filter-block">
					<h4>Rodzaj pamięci</h4>
					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".DDR2_DIMM" type="checkbox" id="checkbox1">
			    			<label class="checkbox-label" for="checkbox1"><span>DDR2 DIMM</span></label>
						</li>
						<li>
							<input class="filter" data-filter=".DDR3_DIMM" type="checkbox" id="checkbox2">
							<label class="checkbox-label" for="checkbox2">DDR3 DIMM</label>
						</li>
						<li>
							<input class="filter" data-filter=".DDR4_DIMM" type="checkbox" id="checkbox3">
			    			<label class="checkbox-label" for="checkbox3"><span>DDR4 DIMM</span></label>
						</li>
					</ul>
				</div>		
				
			<div class="cd-filter-block">
					<h4>Pojemność modułu</h4>
					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".2" type="checkbox" id="checkbox4">
			    			<label class="checkbox-label" for="checkbox4"><span>2 GB</span></label>
						</li>
						<li>
							<input class="filter" data-filter=".4" type="checkbox" id="checkbox5">
							<label class="checkbox-label" for="checkbox5">4 GB</label>
						</li>
						<li>
							<input class="filter" data-filter=".8" type="checkbox" id="checkbox6">
			    			<label class="checkbox-label" for="checkbox6"><span>8 GB</span></label>
						</li>
						<li>
							<input class="filter" data-filter=".16" type="checkbox" id="checkbox7">
			    			<label class="checkbox-label" for="checkbox7"><span>16 GB</span></label>
						</li>
						<li>
							<input class="filter" data-filter=".32" type="checkbox" id="checkbox8">
			    			<label class="checkbox-label" for="checkbox8"><span>32 GB</span></label>
						</li>
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