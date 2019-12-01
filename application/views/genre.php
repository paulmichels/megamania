<!DOCTYPE html>
<html lang="en">
    <?php include('head.php'); ?>
    <body>
        <!-- HEADER -->
        <?php include('header.php'); ?>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="form-create" method="post">
                            <div class="form-group">
                                <label for="input-nom">Nom</label>
                                <input type="text" class="form-control" id="input-nom" name="nom">
                            </div>
                            <button id="form-submit" class="btn btn-primary">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <nav id="navigation">
            <!-- container -->
            <div class="container">
                <!-- responsive-nav -->
                <div id="responsive-nav">
                    <!-- NAV -->
                    <ul class="main-nav nav navbar-nav">
                        <li><a href="<?php echo base_url() ?>index.php/admin/jeu">Jeu</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/admin/reservation">Reservation</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/admin/editeur">Editeur</a></li>
                        <li class="active"><a href="<?php echo base_url() ?>index.php/admin/genre">Genre</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/admin/plateforme">Plateforme</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/admin/pegi">Pegi</a></li>
                    </ul>

                    <!-- /NAV -->
                </div>
                <!-- /responsive-nav -->
            </div>
            <!-- /container -->
        </nav>

        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Créer</button>
                    <table class="table">
                        <thead>
                            <tr>
                                <?php foreach ($genre[0]->getObjectVars() as $key => $value) {
                                    echo '<th scope="col">'.$value.'</th>';
                                } ?>
                                <th scope=col></th>
                                <th scope=col></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($genre as $element) {
                                echo '<tr>';
                                $i = 0;
                                foreach ($genre[0]->getObjectVars() as $value) {
                                    if($i == 0){
                                        echo '<th scope="row">'.$element->$value.'</th>';
                                        $i++;
                                    } else {
                                        if(!is_array($element->$value)){
                                            echo '<td>'.(strlen($element->$value) > 50 ? substr($element->$value, 0, 50).'...':$element->$value).'</td>';
                                        } else {
                                            $j = 0;
                                            echo '<td>';
                                            foreach ($element->$value as $array_value) {
                                                if($j == 0){
                                                    echo $array_value;
                                                    $j++;
                                                } else {
                                                    echo ', '.$array_value;
                                                }
                                            }
                                            echo '</td>';
                                        }
                                    }
                                }?>

                                <?php $key = $element->getObjectVars()[0];?>
                                <!-- <td><button id="<?php echo 'btn-edit-'.$element->$key ?>" class="btn btn-primary" onclick="editEntry(this.value)" value="<?php echo $element->$key ?>"> Modifier</button></td> -->
                                <td><button id="<?php echo 'btn-delete-'.$element->$key ?>" class="btn btn-danger" onclick="deleteEntry(this.value)" value="<?php echo $element->$key ?>"> Supprimer</button></td>
                                </td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




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
        <script src="<?php echo base_url()?>assets/js/bootstrap-select.js"></script>
        <script type="text/javascript">

            $('#myInput').trigger('focus')

            $('#form-create').on('submit', function(event) {
               event.preventDefault();
               createEntry();
            });


            function createEntry(){
                var formData = new FormData(document.getElementById("form-create"));
                $.ajax({
                    method: "post",
                    url: "<?php echo base_url()."index.php/admin/genre/create/"?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        try {
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
            }

            
            function editEntry(value){
                $.ajax({
                    method: "post",
                    url: "<?php echo base_url()."index.php/admin/edit/"?>",
                    data: {id : value},
                    success: function(data){
                        try {
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
            }


            function deleteEntry(value){
                $.ajax({
                    method: "post",
                    url: "<?php echo base_url()."index.php/admin/genre/delete/"?>",
                    data: {id : value},
                    success: function(data){
                        try {
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
            }

        </script>
    </body>
</html>
