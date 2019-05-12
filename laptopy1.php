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
  	
  	
	<title>Content Filters | CodyHouse</title>
</head>
<body>
	<header class="cd-header">
		<h1>Content Filters</h1>
	</header>


	<main class="cd-main-content">
		<div class="cd-tab-filter-wrapper">
			<div class="cd-tab-filter">
				<ul class="cd-filters">
					<li class="placeholder"> 
						<a data-type="all" href="#0">Szukane zestawy</a> <!-- selected option on mobile -->
					</li> 
					<li class="filter"><a class="selected" href="laptopy1.php" >Grafika komputerowa</a></li>
					<li class="filter"><a href="laptopy2.php" >Laptopy dla graczy</a></li>
					<li class="filter"><a href="laptopy3.php" >Laptopy biurowe</a></li>
				</ul> <!-- cd-filters -->
			</div> <!-- cd-tab-filter -->
		</div> <!-- cd-tab-filter-wrapper -->

		<section class="cd-gallery">
			<ul>
			
							<?php
				mysql_query("SET NAMES 'utf8'");
				$polacz=mysqli_connect('localhost','root','','poczatkowy');

				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				mysql_query("SET NAMES 'utf8'");
				$sql="
					SELECT DISTINCT modal, opis, zdjecie, laptop.nazwa, producent, procesor, grafika, ram, dysk, rozdzielczosc, przekatna, group_concat(grafika.nazwa SEPARATOR ' ') as programy FROM `laptop` INNER join zestawgrafika on laptop.ID_laptopa = zestawgrafika.ID_zestawu join grafika on zestawgrafika.ID_programu=grafika.ID_programu group by laptop.ID_laptopa
				";
				$z=0;
				if ($result=mysqli_query($polacz,$sql))
					{
						$row=mysqli_num_rows($result);

						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
			 			{
						$programy = explode(" ", $row["programy"]);
						$liczba = (count($programy))-1;
						$z++;
							echo('
							<li class="mix ' );
							for ($i = 0; $i <= $liczba; $i++) {
								echo $programy[$i];
								echo ' ';
							}
							
							
							echo('">
								<div class="card-panel hoverable"> <br>
								 <img src="'.$row["zdjecie"].'" width="100%" height="100%"> <br>
								<h5 class="center"> <u> '.$row["nazwa"].'</u> </h5>
							<center> 
							 <a class="waves-effect waves-light btn modal-trigger" href="#'.$row["modal"].'">Opis produktu</a>
					
					
					<!-- Modal Structure -->
							<div id="'.$row["modal"].'" class="modal">
							<div class="modal-content">
							<h1>'.$row["nazwa"].'<br><br></h1>
							<div class="container">
							<div class="section">

							<!--   Icon Section   -->
							<div class="row">
							<div class="col s12 m6">
							<div class="icon-block">
							<p class="light">
							<img src="'.$row["zdjecie"].'" width="70%" height="70%"> 
							</p>
							</div>
							</div>

							<div class="col s12 m6">
							<div class="icon-block">
							<h5 class="center">Pełna specyfikacja</h5>
							
							<table>
							<tbody>
								<tr>
									<td><b>Producent</b></td>
									<td>'.$row["producent"].'</td>
								</tr>
								<tr>
									<td><b>Procesor</b></td>
									<td>'.$row["procesor"].'</td>
								</tr>
								<tr>
									<td><b>Grafika</b></td>
									<td>'.$row["grafika"].'</td>
								</tr>
								<tr>
									<td><b>Pamięć RAM</b></td>
									<td>'.$row["ram"].'</td>
								</tr>
								<tr>
									<td><b>Dysk</b></td>
									<td>'.$row["dysk"].'</td>
								</tr>
								<tr>
									<td><b>Rozdzielczość ekranu</b></td>
									<td>'.$row["rozdzielczosc"].'</td>
								</tr>
								<tr>
									<td><b>Przekątna</b></td>
									<td>'.$row["przekatna"].'"</td>
								</tr>
							</tbody>
							</table>
							</div>
							</div>
							<br>
							<br>
							<div class="col s12 m17">
							<div class="icon-block">
							<h5 class="center"><br><br> Opis produktu </h5>
							<p class="light">
							</p>
							<p class="light">
							
							'.$row["opis"].'
							
							</p>
							</div>
							</div>
				
					</div>

					</div>
					<br><br>
					</div>

							</div>
							<div class="modal-footer">
							<a href="#!" class="modal-close waves-effect waves-green btn-flat">Zamknij</a>
							</div>
							</div>

						</center>
						</div>
							</li>

							');	
							
							
						}
					}
					?>	
			
			
			
			
		
				<li class="gap"></li>
				<li class="gap"></li>
				<li class="gap"></li>
			</ul>
			<div class="cd-fail-message">No results found</div>
		</section> <!-- cd-gallery -->

		<div class="cd-filter">
			<form>
				<div class="cd-filter-block">
					<h4>Wyszukaj po nazwie programu</h4>					
					<div class="cd-filter-content">
						<input type="search" placeholder="Wpisz nazwę komponentu">
					</div> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->
				
				<div class="cd-filter-block">
					<h4>Grafika rastrowa</h4>
					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".Adobe_Photoshop" type="checkbox" id="checkbox1">
			    			<label class="checkbox-label" for="checkbox1">Adobe Photoshop</label>
						</li>
						<li>
							<input class="filter" data-filter=".Blender" type="checkbox" id="checkbox2">
							<label class="checkbox-label" for="checkbox2">Blender</label>
						</li>
						<li>
							<input class="filter" data-filter=".Photoline" type="checkbox" id="checkbox3">
							<label class="checkbox-label" for="checkbox3">Photoline</label>
						</li>
						<li>
							<input class="filter" data-filter=".IrfanView" type="checkbox" id="checkbox4">
							<label class="checkbox-label" for="checkbox4">IrfanView</label>
						</li>
						<li>
							<input class="filter" data-filter=".GIMP" type="checkbox" id="checkbox5">
							<label class="checkbox-label" for="checkbox5">GIMP</label>
						</li>
						<li>
							<input class="filter" data-filter=".PaintShopPro" type="checkbox" id="checkbox6">
							<label class="checkbox-label" for="checkbox6">PaintShopPro</label>
						</li>
					</ul>
				</div>			
				
				<div class="cd-filter-block">
					<h4>Grafika wektorowa 2D</h4>
					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".CorelDraw" type="checkbox" id="checkbox7">
			    			<label class="checkbox-label" for="checkbox7">CorelDraw</label>
						</li>
						<li>
							<input class="filter" data-filter=".Inkscape" type="checkbox" id="checkbox8">
							<label class="checkbox-label" for="checkbox8">Inkscape</label>
						</li>
						<li>
							<input class="filter" data-filter=".Adobe_Illustrator" type="checkbox" id="checkbox9">
							<label class="checkbox-label" for="checkbox9">Adobe Illustrator</label>
						</li>
						<li>
							<input class="filter" data-filter=".Adobe_FreeHand" type="checkbox" id="checkbox10">
							<label class="checkbox-label" for="checkbox10">Adobe FreeHand</label>
						</li>
					</ul>
				</div>	
				
				<div class="cd-filter-block">
					<h4>Grafika wektorowa 3D</h4>
					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".3ds_Max" type="checkbox" id="checkbox11">
			    			<label class="checkbox-label" for="checkbox11">3ds Max</label>
						</li>
						<li>
							<input class="filter" data-filter=".Blender" type="checkbox" id="checkbox12">
							<label class="checkbox-label" for="checkbox12">Blender</label>
						</li>
												<li>
							<input class="filter" data-filter=".Cinema_4D" type="checkbox" id="checkbox13">
			    			<label class="checkbox-label" for="checkbox13">Cinema 4D</label>
						</li>
						<li>
							<input class="filter" data-filter=".Maya" type="checkbox" id="checkbox14">
							<label class="checkbox-label" for="checkbox14">Maya</label>
						</li>
												<li>
							<input class="filter" data-filter=".Solid_Edge" type="checkbox" id="checkbox15">
			    			<label class="checkbox-label" for="checkbox15">Solid Edge</label>
						</li>
					</ul>
				</div>	
				
				<div class="cd-filter-block">
					<h4>Programy do projektowania CAD </h4>
					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".AutoCAD" type="checkbox" id="checkbox16">
			    			<label class="checkbox-label" for="checkbox16">AutoCAD 2019</label>
						</li>
						<li>
							<input class="filter" data-filter=".Autodesk_Inventor_LT" type="checkbox" id="checkbox17">
							<label class="checkbox-label" for="checkbox17">Autodesk Inventor LT</label>
						</li>
						<li>
							<input class="filter" data-filter=".CorelDRAW_Technical_Suite" type="checkbox" id="checkbox18">
			    			<label class="checkbox-label" for="checkbox18">CorelDRAW Technical Suite</label>
						</li>
						<li>
							<input class="filter" data-filter=".NaroCAD" type="checkbox" id="checkbox19">
							<label class="checkbox-label" for="checkbox19">NaroCAD </label>
						</li>
					</ul>
				</div>							
				
	
			</form>

			<a href="#0" class="cd-close" style="background-color: #ff0000;">X</a>
		</div> <!-- cd-filter -->

		<a href="#0" class="cd-filter-trigger">Wyszukiwanie</a>
	</main> <!-- cd-main-content -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mixitup.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
<script src="js/materialize.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

</body>
</html>