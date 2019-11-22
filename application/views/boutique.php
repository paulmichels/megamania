<!DOCTYPE html>
<html lang="en">
	<?php include('head.php'); ?>
	<body>
		<!-- HEADER -->
		<?php include('header.php'); ?>

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Plateforme</h3>
							<div class="checkbox-filter">
								<?php foreach ($plateforme as $key => $value) { ?>
									<div class="input-checkbox">
										<input type="checkbox" id="plateforme-<?php echo $value->id ?>">
										<label for="plateforme-<?php echo $value->id ?>">
											<span></span>
											<?php echo $value->nom ?>
											<!--<small>(120)</small>-->
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
						<!-- /aside Widget -->


						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Genre</h3>
							<div class="checkbox-filter">

								<?php foreach ($genre as $key => $value) { ?>
									<div class="input-checkbox">
										<input type="checkbox" id="genre-<?php echo $value->id ?>">
										<label for="genre-<?php echo $value->id ?>">
											<span></span>
											<?php echo $value->nom ?>
											<!--<small>(120)</small>-->
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Editeur</h3>
							<div class="checkbox-filter">
								<?php foreach ($editeur as $key => $value) { ?>
									<div class="input-checkbox">
										<input type="checkbox" id="editeur-<?php echo $value->id ?>">
										<label for="editeur-<?php echo $value->id ?>">
											<span></span>
											<?php echo $value->nom ?>
											<!--<small>(578)</small>-->
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Prix</h3>
							<div class="price-filter">
								<div id="price-slider"></div>
								<div class="input-number price-min">
									<input id="price-min" type="number">
								</div>
								<span>-</span>
								<div class="input-number price-max">
									<input id="price-max" type="number">
								</div>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Prix</h3>
							<button class="search-btn" id="filter-button">Rechercher</button>
						</div>
						<!-- /aside Widget -->

						

					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-9">

						<!-- store products -->
						<div class="row">
							<!-- product -->
							<?php foreach ($jeu as $key => $value) { ?>
								<div class="col-md-4 col-xs-6">
									<div class="product">
										<div class="product-img">
											<img src="<?php echo base_url() ?>assets/img/jeux/<?php echo str_replace(" ", "_", $value->nom) ?>/<?php echo $photos[str_replace(" ", "_", strtolower($value->nom))][0] ?>" alt=""
											width="262" height="327">
											<div class="product-label">
											</div>
										</div>
										<div class="product-body">
											<p class="product-category">
											<?php 
											if(is_array($value->id_genre)){
												foreach ($value->id_genre as $id => $id_genre) {
													echo $genre[$id_genre - 1]->nom.' ';
												}	
											} else {
												echo $genre[$id_genre - 1]->nom;
											}
											?>
											</p>
											<h3 class="product-name"><a href="<?php echo base_url() ?>index.php/produit/?id=<?php echo $value->id_jeu ?>"><?php echo $value->nom ?></a></h3>
											<h4 class="product-price"><?php echo $value->prix ?>€</h4>
										</div>
										<div class="add-to-cart">
											<a href="<?php echo base_url().'index.php/produit/?id='.$value->id_jeu?>"><button class="add-to-cart-btn" href="<?php echo base_url() ?>index.php/product/?id=<?php echo $value->id_jeu ?>"><i class="fa fa-shopping-cart"></i> Réserver</button></a>
										</div>
									</div>
								</div>
							<?php } ?>
							<!-- /product -->

						</div>
						<!-- /store products -->
					</div>
					<!-- /STORE -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- FOOTER -->
		<?php include('footer.php'); ?>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/slick.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/nouislider.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.zoom.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/main.js"></script>
		<script type="text/javascript">

			$('#filter-button').click(function(){
				$.ajax({
                    method: "post",
                    url:  "<?php echo base_url()."index.php/boutique/search/"; ?>",
                    data: { 
                        plateforme : {
                        	<?php 
                        		$i = 0;
                            	foreach ($plateforme as $key => $value){
                            		if($i == 0){
                            			echo $value->id.":$('#plateforme-".$value->id."').prop('checked')";
                            		} else { 
                            			echo ",".$value->id.":$('#plateforme-".$value->id."').prop('checked')";
                            		}
                            		$i++;
                            	} 
                        	?>
                        },
                        genre : {
                        	<?php 
                        		$i = 0;
                            	foreach ($genre as $key => $value){
                            		if($i == 0){
                            			echo $value->id.":$('#genre-".$value->id."').prop('checked')";
                            		} else { 
                            			echo ",".$value->id.":$('#genre-".$value->id."').prop('checked')";
                            		}
                            		$i++;
                            	}
                        	?>
                        },
                        editeur : {
                        	<?php 
                        		$i = 0;
                            	foreach ($editeur as $key => $value){
                            		if($i == 0){
                            			echo $value->id.":$('#editeur-".$value->id."').prop('checked')";
                            		} else { 
                            			echo ",".$value->id.":$('#editeur-".$value->id."').prop('checked')";
                            		}
                            		$i++;
                            	}
                        	?>
                        },
                        prix : {
                        	prixMin : $('#price-min').val(),
                        	prixMax : $('#price-max').val()
                        }
                    },
                    success: function(data){
                    	console.log(data);
                        try {
                            data = $.parseJSON(data);
                            console.log(data);
                        } catch (e) {

                        }
                    },
                    error: function(data){
                    	console.log(data);
                    }
                }); 
			});
			

		</script>

	</body>
</html>
