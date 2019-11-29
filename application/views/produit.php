<!DOCTYPE html>
<html lang="en">
	<?php include('head.php'); ?>
	<body>
		<!-- HEADER -->
		<?php include('header.php'); ?>
		<!-- /HEADER -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					<div class="col-md-5 col-md-push-2">
						<div id="product-main-img">
							<?php foreach ($photos as $key => $value) {
								echo '<div class="product-preview">';
								echo '<img src="'.base_url().'assets/img/jeux/'.strtolower(str_replace(" ", "_", $produit->nom)).'/'.$value.'" alt="" >';
								echo '</div>';
							} ?>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					<div class="col-md-2  col-md-pull-5">
						<div id="product-imgs">
							<?php foreach ($photos as $key => $value) {
								echo '<div class="product-preview">';
								echo '<img src="'.base_url().'assets/img/jeux/'.strtolower(str_replace(" ", "_", $produit->nom)).'/'.$value.'" alt="">';
								echo '</div>';
							} ?>
						</div>
					</div>
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $produit->nom ?></h2>
							<div>
								<h3 class="product-price"><?php echo $produit->prix ?> €</h3>
								<span class="product-available"><?php echo $produit->quantite > 0 ? "En stock" : "Rupture de stock" ?></span>
								<p><?php echo $produit->description?></p>
							</div>
							<p><!-- <?php echo $produit->description ?> --></p>
							<div class="add-to-cart">
								<button class="add-to-cart-btn" id="reservation-button"><i class="fa fa-shopping-cart"></i> Réserver</button>
							</div>

							<ul class="product-links">
								<li>Genre:</li>
								<li>
								<?php
									if(is_array($produit->id_genre)){
										foreach ($produit->id_genre as $id => $id_genre) {
											echo $genre[$id_genre - 1]->nom.' ';
										}	
									} else {
										echo $genre[$produit->id_genre]->nom;
									}
								?>
								</li>
							</ul>

						</div>
					</div>
					<!-- /Product details -->

					<!-- Product tab -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab2">Pegi</a></li>
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab1  -->
								<div id="tab1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-md-12">
											<p><?php echo $produit->description ?></p>
										</div>
									</div>
								</div>
								<!-- /tab1  -->

								<!-- tab2  -->
								<div id="tab2" class="tab-pane fade in">
									<div class="row">
										<div class="col-md-12 align-self-center">
											<?php
												if(is_array($produit->id_pegi)){
													foreach ($produit->id_pegi as $id => $id_pegi) {
														echo '<img src="'.base_url().'assets/img/pegi/'.$id_pegi.'.png" alt="" >';
													}	
												} else {
													echo '<img src="'.base_url().'assets/img/pegi/'.$pegi[$produit->id_pegi - 1]->id.'" alt="" >';
												}
											?>
										</div>
									</div>
								</div>
								<!-- /tab1  -->
							</div>
						</div>
					</div>

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
			$('#reservation-button').click(function() {
				$.ajax({
					method: "post",
					url: "<?php echo base_url()."index.php/produit/book/";?>",
					data: {
						reservation: {
							etat: "'En cours'",
							login_utilisateur: "'<?php echo $utilisateur->login ?>'",
							id_produit: <?php echo $produit->id_jeu ?>
						}
					},
					success: function(data){
						console.log(data);
						try {
							data = $.parseJSON(data);
							console.log(data);
						}
						catch(e){
							console.log(e);
						}
					},
					error: function(data) {
						console.log(data);
					}
				})
			})
		</script>

	</body>
</html>
