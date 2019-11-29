<header>
	<!-- TOP HEADER -->
	<div id="top-header">
		<div class="container">
			<ul class="header-links pull-left">
				<li><a href="#"><i class="fa fa-envelope-o"></i>megamania.cnam@hotmail.fr</a></li>
			</ul>
			<ul class="header-links pull-right">
				<li><a href="<?php echo base_url() ?>index.php/admin/jeu"><i class="fa fa-user-o"></i> <?php echo $utilisateur->login ?></a></li>
			</ul>
		</div>
	</div>
	<!-- /TOP HEADER -->

	<!-- MAIN HEADER -->
	<div id="header">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- LOGO -->
				<div class="col-md-3">
					<div class="header-logo">
						<a href="<?php echo base_url().'index.php'?>" class="logo">
							<img src="<?php echo base_url() ?>/assets/img/logo.png" alt="" width="80" height="80">
						</a>
					</div>
				</div>
				<!-- /LOGO -->

				<!-- SEARCH BAR -->
				<div class="col-md-6">
					<div class="header-search">
						<form action="<?php echo base_url().'index.php/boutique/' ?>" method="get">
							<select class="input-select" id="plateforme-search" name="plateforme">
								<option value="0">Plateforme</option>
								<?php
								foreach ($plateforme as $key => $value){
									echo '<option value="'.$value->id.'">'.$value->nom.'</option>';
								}
								?>
							</select>
							<input class="input" id="query-search" name="query" placeholder="Rechercher un produit">
							<button class="search-btn" id="search-btn">Rechercher</button>
						</form>
					</div>
				</div>
				<!-- /SEARCH BAR -->

				<!-- ACCOUNT -->
				<div class="col-md-3 clearfix">
					<div class="header-ctn">
						<div class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-shopping-cart"></i>
								<span>Réservations</span>
								<!-- TODO -->
								<div class="qty" id="cart-quantity"><?php echo array_sum(array_column($reservation_count,'quantite')); ?></div>
							</a>
							<!-- TODO -->
							<div class="cart-dropdown">
								<div class="cart-list" id="cart-list">
									<?php
									foreach ($reservation as $key => $value) { ?>
										<div class="product-widget" id="reservation-<?php echo $value->id_jeu?>">
											<div class="product-img">
												<img src="<?php echo base_url() ?>assets/img/jeux/<?php echo strtolower(str_replace(" ", "_", "$value->nom")) ?>/1.jpg" alt="">
											</div>
											<div class="product-body">
												<h3 class="product-name"><a href="<?php echo base_url()."/index.php/product/".$value->id_jeu ?>">
													<?php echo $value->nom ?>
												</a></h3>
												<h4 class="product-price"><?php echo $value->prix ?> €</h4>
												<b>Quantité : <b id="product-quantity-<?php echo $value->id_jeu ?>"><?php echo $reservation_count[array_search($value->id_jeu, array_column($reservation_count, 'id_jeu'))]['quantite'] ?></b></b>
											</div>
										</div>
									<?php }?>
								</div>
								<div class="cart-summary">
									<br><b>Total: <?php 
										$count = 0; 
										foreach ($reservation as $key => $value) {
											$count += ($value->prix * $reservation_count[array_search($value->id_jeu, array_column($reservation_count, 'id_jeu'))]['quantite']);
										} 
										echo '<b id="cart-summary-price">'.$count.'</b> €';
									?></b>
								</div>
							</div>
						</div>
						<!-- /Cart -->
					</div>
				</div>
				<!-- /ACCOUNT -->
			</div>
			<!-- row -->
		</div>
		<!-- container -->
	</div>
	<!-- /MAIN HEADER -->
</header>