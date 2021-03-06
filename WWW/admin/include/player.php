<?php
require('db.php');
?>

<?php
if(isset($_POST['delete'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM bs_siatkarze WHERE ID_siatkarza = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?go=players&delete=successfully");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>

<?php
    $id = $_GET['id'];

    $sel_query = "Select * from bs_siatkarze, bs_zespoly, bs_kraje, bs_pozycje WHERE ID_zespolu = ID_zespol AND Narodowosc = ID_kraj AND Pozycja = poz_skrot AND ID_siatkarza = '$id';";
    $result = mysqli_query($conn,$sel_query);

    while($row = mysqli_fetch_assoc($result)) {
        $id = $row["ID_siatkarza"];
        $imie = $row["Imie"];
        $nazwisko = $row["Nazwisko"];
        $file_name = $id . " " . $imie . " ". $nazwisko . "";


        $wzrost = $row["Wzrost"];
        $atak = $row["Zasieg_ataku"];
        $blok = $row["Zasieg_bloku"];

        $narodowosc = $row["kr_nazwa"];
        $data = $row["Data_urodzenia"];
        $pozycja = $row["poz_nazwa"];

        $zespol = $row["zes_nazwa"];
        $nr = $row["Nr_koszulki"];
        $kontrakt = $row["Dlugosc_kontraktu"];

        $file_name2 = $zespol;


        if($kontrakt == "0") $lata = "lat";
        if($kontrakt == "1") $lata = "rok";
        if($kontrakt == "2" || $kontrakt == "3" || $kontrakt == "4") $lata = "lata";
        if($kontrakt == "5") $lata = "lat";
    }

?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.php">Panel Administracyjny</a>
    </li>
    <li class="breadcrumb-item">
        <a href="index.php?go=players">Zawodnicy</a>
    </li>
    <li class="breadcrumb-item active"><?php echo $imie; ?> <?php echo $nazwisko; ?></li>
</ol>

<a class="btn btn-primary" href="index.php?go=player-edit&id=<?=$id; ?>">Edytuj</a>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">
    Usuń
</button></p>


<!-- Modal Usuń -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Potwierdź usunięcie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Czy chcesz usunąć z siatkarza <?php echo $imie; ?> <?php echo $nazwisko; ?>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                <form action="" method="POST" ENCTYPE="multipart/form-data" >
                    <button type="submit" class="btn btn-primary" name="delete">Usuń</button>
                </form>

            </div>
        </div>
    </div>
</div>




<!-- Example DataTables Card-->
<div class="card mb-3">

    <div class="card-body card-background">
        <div class="row">
            <div class="col-md-2 player">

                <?php
                $plik = '../img/players/'.$file_name.'.png';
                $test = file_exists($plik);

                if(!$test) {
                    echo '<img class="playerPic mr-3" src="../img/default_player.png">';
                } else {
                    echo '<img class="playerPic mr-3" src="../img/players/'.$file_name.'.png" >';
                }
                ?>
            </div>

            <div class="col-md-10 player-info">
                <p class="h1"><a href="#"><?php echo $imie; ?> <?php echo $nazwisko; ?></a></p>
                <p> <a href="#"><?php echo $zespol; ?>
                    <?php
                    $plik2 = '../img/teams/'.$file_name2.'.png';
                    $test2 = file_exists($plik2);

                    if(!$test2) {
                        echo '';
                    } else {
                        echo '<img class="teamPic mr-3" src="../img/teams/'.$file_name2.'.png" >';
                    }
                    ?></a> </p>
            </div>
        </div>

        </br>

        <div class="row">

            <div class="col-sm-3">
                <div class="datainfo text-center">Narodowość:<span><?php echo $narodowosc; ?></span></div>
            </div>

            <div class="col-sm-3">
                <div class="datainfo text-center">Data urodzenia:<span><?php echo $data; ?></span></div>
            </div>

            <div class="col-sm-3">
                <div class="datainfo text-center">Pozycja:<span><?php echo $pozycja; ?></span></div>
            </div>

        </div>

        </br>

        <div class="row">

            <div class="col-sm-3">
                <div class="datainfo text-center">Zespół:<span><?php echo $zespol; ?></span></div>
            </div>

            <div class="col-sm-3">
                <div class="datainfo text-center">Numer koszulki:<span><?php echo $nr; ?></span></div>
            </div>

            <div class="col-sm-3">
                <div class="datainfo text-center">Długość kontraktu:<span><?php echo $kontrakt; ?> <?php echo $lata; ?></span></div>
            </div>

        </div>

        </br>

        <div class="row">

            <div class="col-sm-3">
                <div class="datainfo text-center">Wzrost:<span><?php echo $wzrost; ?> cm</span></div>
            </div>

            <div class="col-sm-3">
                <div class="datainfo text-center">Zasięg ataku:<span><?php echo $atak; ?> cm</span></div>
            </div>

            <div class="col-sm-3">
                <div class="datainfo text-center">Zasięg bloku:<span><?php echo $blok; ?> cm</span></div>
            </div>

        </div>


    </div>
</div>
