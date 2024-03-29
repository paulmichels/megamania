<!DOCTYPE html>
<html lang="en">
	<?php include('head.php'); ?>
	<body>
		<!-- HEADER -->
		<?php include('header.php'); ?>

		<?php if(!empty($top_reservation)){ ?>
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">

						<!-- section title -->
						<div class="col-md-12">
							<div class="section-title">
								<h3 class="title">Top des réservations</h3>
							</div>
						</div>
						<!-- /section title -->

						<!-- Products tab & slick -->
						<div class="col-md-12">
							<div class="row">
								<div class="products-tabs">
									<!-- tab -->
									<div id="tab1" class="tab-pane active">
										<div class="products-slick" data-nav="#slick-nav-1">
										<?php 
											if(is_array($top_reservation)){
												foreach ($top_reservation as $key => $value) { ?>
													<div class="col-md-4 col-xs-6">
														<div class="product">
															<div class="product-img">
																<a href="<?php echo base_url() ?>index.php/produit/?id=<?php echo $value->id_jeu ?>">
																<img src="<?php echo base_url().'assets/img/jeux/'.strtolower(str_replace(" ", "_", $value->nom)).'/1.jpg'?>" alt=""
																width="262" height="327" onerror="this.src='<?php echo base_url().'assets/img/logo.png'?>'"></a>
																<div class="product-label">
																</div>
															</div>
															<div class="product-body">
																<h3 class="product-name"><a href="<?php echo base_url() ?>index.php/produit/?id=<?php echo $value->id_jeu ?>"><?php echo strlen($value->nom) > 22 ? substr($value->nom,0,22)."..." : $value->nom; ?></a></h3>
																<h4 class="product-price"><?php echo $value->prix ?>€</h4>
															</div>
														</div>
													</div>
												<?php }
											} ?>
										</div>
										<div id="slick-nav-1" class="products-slick-nav"></div>
									</div>
									<!-- /tab -->
								</div>
							</div>
						</div>
						<!-- Products tab & slick -->
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /SECTION -->
		<?php } ?>

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
							<button class="btn btn-danger" style="background: #D10024"  id="filter-button">Rechercher</button>
						</div>
						<!-- /aside Widget -->

						

					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-9">

						<!-- store products -->
						<div class="row" id="game-list">
							<?php 
							if(is_array($jeu)){
								foreach ($jeu as $key => $value) { ?>
									<div class="col-md-4 col-xs-6">
										<div class="product">
											<div class="product-img">
												<a href="<?php echo base_url() ?>index.php/produit/?id=<?php echo $value->id_jeu ?>">
												<img src="<?php echo base_url().'assets/img/jeux/'.strtolower(str_replace(" ", "_", $value->nom)).'/1.jpg'?>" alt=""
												width="262" height="327"></a>
												<div class="product-label">
												</div>
											</div>
											<div class="product-body">
												<h3 class="product-name"><a href="<?php echo base_url() ?>index.php/produit/?id=<?php echo $value->id_jeu ?>"><?php echo strlen($value->nom) > 22 ? substr($value->nom,0,22)."..." : $value->nom; ?></a></h3>
												<h4 class="product-price"><?php echo $value->prix ?>€</h4>
											</div>
										</div>
									</div>
								<?php }
							} else { ?>
								<p>Aucun résultat pour la recherche "<?php echo $this->input->get('query') ?>"<?php echo $this->input->get('plateforme') != 0 ? " sur ".$plateforme[$this->input->get('plateforme') - 1]->nom:"" ?></p>
							<?php }
							?>
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
                        try {
                            data = $.parseJSON(data);
                            var html = '';
                            for (var i = 0; i < data.response.length; i++) {
                            	html += jeuDetailsJSONToHTML(data.response[i]);
                            }
                            $('#game-list').html(html);
                        } catch (e) {
                        	console.log(e);
                        }
                    },
                    error: function(data){
                    	console.log(data);
                    }
                }); 
			});

			function jeuDetailsJSONToHTML(jeuDetailsJSON){
				var html = '';
				html += '<div class="col-md-4 col-xs-6">';
				html += '<div class="product">';
				html += '<div class="product-img">';
				html += '<a href="<?php echo base_url() ?>index.php/produit/?id=' + jeuDetailsJSON.id_jeu + '">';
				html += '<img src="<?php echo base_url() ?>assets/img/jeux/' + jeuDetailsJSON.nom.replace(/ |%20/g, '_').toLowerCase() + '/1.jpg" alt="" width="262" height="327">';
				html += '</a>';
				html += '<div class="product-label">';
				html += '</div>';
				html += '</div>';
				html += '<div class="product-body">';
				html += '<h3 class="product-name"><a href="<?php echo base_url() ?>index.php/produit/?id=' + jeuDetailsJSON.id_jeu + '">' + (jeuDetailsJSON.nom.length > 22 ? (jeuDetailsJSON.nom.slice(0, 22) + '...') : jeuDetailsJSON.nom) + '</a></h3>';
				html += '<h4 class="product-price">' + jeuDetailsJSON.prix + '€</h4>';
				html += '</div>';
				html += '<div class="add-to-cart">';
				html += '<a href="<?php echo base_url() ?>index.php/product/?id=' + jeuDetailsJSON.id_jeu + '"><button class="add-to-cart-btn" href="<?php echo base_url() ?>index.php/produit/?id=?>' + jeuDetailsJSON.id_jeu + '"><i class="fa fa-shopping-cart"></i> Réserver</button></a>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				return html;
			}

		</script>

	</body>
</html>
