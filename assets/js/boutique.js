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