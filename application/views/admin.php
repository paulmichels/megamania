<!DOCTYPE html>
<html lang="en">
    <?php include('head.php'); ?>
    <body>
        <!-- HEADER -->
        <?php include('header.php'); ?>

        <nav id="navigation">
            <!-- container -->
            <div class="container">
                <!-- responsive-nav -->
                <div id="responsive-nav">
                    <!-- NAV -->
                    <ul class="main-nav nav navbar-nav">
                        <li <?php echo $segment == 'jeu'?'class="active"':'' ?>><a href="<?php echo base_url() ?>index.php/admin/jeu">Jeu</a></li>
                        <li <?php echo $segment == 'reservation'?'class="active"':'' ?>><a href="<?php echo base_url() ?>index.php/admin/reservation">Reservation</a></li>
                        <li <?php echo $segment == 'editeur'?'class="active"':'' ?>><a href="<?php echo base_url() ?>index.php/admin/editeur">Editeur</a></li>
                        <li <?php echo $segment == 'genre'?'class="active"':'' ?>><a href="<?php echo base_url() ?>index.php/admin/genre">Genre</a></li>
                        <li <?php echo $segment == 'plateforme'?'class="active"':'' ?>><a href="<?php echo base_url() ?>index.php/admin/plateforme">Plateforme</a></li>
                        <li <?php echo $segment == 'pegi'?'class="active"':'' ?>><a href="<?php echo base_url() ?>index.php/admin/pegi">Pegi</a></li>
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

                    <table class="table">
                        <thead>
                            <tr>
                                <?php foreach ($table[0]->getObjectVars() as $key => $value) {
                                    echo '<th scope="col">'.$value.'</th>';
                                } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table as $element) {
                                echo '<tr>';
                                $i = 0;
                                foreach ($table[0]->getObjectVars() as $value) {
                                    if($i == 0){
                                        echo '<th scope="row">'.$element->$value.'</th>';
                                        $i++;
                                    } else {
                                        if(!is_array($element->$value)){
                                            echo '<td>'.$element->$value.'</td>';
                                        } else {
                                            $j = 0;
                                            echo '<td>';
                                            foreach ($element->$value as $array_value) {
                                                if($j == 0){
                                                    echo $array_value;
                                                } else {
                                                    echo ', '.$array_value;
                                                }
                                            }
                                            echo '</td>';
                                        }
                                    }
                                }
                                echo '</tr>';
                            } ?>
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
    </body>
</html>
