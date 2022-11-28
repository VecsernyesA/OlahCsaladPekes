<?php
    session_start();
    $oldal = array(array("id" => "1", "cim" => "Főoldal"),array("id" => "2", "cim" => "Rólunk"),array("id" => "3", "cim" => "Adatbázis"));
    $csatlakozas = new mysqli("localhost", "root", "", "telefonkeszulekek");

    $felhasznaloLekeres = $csatlakozas -> query("SELECT * FROM felhasznalo");
    $hibakod = "";
    while($sor = $felhasznaloLekeres -> fetch_assoc()){
        if(isset($_POST["felhasznaloNev"]) && isset($_POST["jelszo"])){
            if($_POST["felhasznaloNev"] === $sor["nev"] && $_POST["jelszo"] === $sor["jelszo"]){
                $_SESSION["id"] = $sor["id"];
            }else{
                 $hibakod = "Hibás adatokkal próbálsz belépni!";
            }
        }
    }
    if(isset($_POST["regNev"]) && isset($_POST["regJelszo"])){
        $csatlakozas -> query("INSERT INTO felhasznalo(`nev`, `jelszo`) VALUES('".$_POST["regNev"]."', ".$_POST["regJelszo"].")");
    }

    $c = $oldal[0]["cim"];
    if(isset($_GET["c"])){
        $c = $_GET["c"];
        for($i = 0; $i < count($oldal); $i++){
            if($oldal[$i]["cim"] == $_GET["c"]){
                $c = $oldal[$i]["cim"];
            }
        }
    }

    if(isset($_POST["kijelentkezes"])){
        session_destroy();
        header("location: /?c=Főoldal");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $c ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(!isset($_SESSION["id"])){
    ?>
        <form action="" method="post">
                <button type="submit" name = "regisztracio">Regisztráció</button>
        </form>
    <?php
        }
        if(!isset($_SESSION["id"]) && !isset($_POST["regisztracio"])){
    ?>
    <div class = "header">
        <div class="menu">
            <h1>Diákok</h1>
            <form action="" method="post">
                <table>
                    <tr>
                        <td><label for="felhasznaloNev">Név:</label></td>
                        <td><input type="text" name="felhasznaloNev" autocomplete="off" required></td>
                    </tr>
                    <tr>
                        <td><label for="jelszo">Jelszó:</label></td> 
                        <td><input type="password" name="jelszo" autocomplete="off" required></td>
                    </tr>
                    <tr>
                        <td><button type="submit" name = "bejelentkezes">Bejelentkezés</button></td>
                    </tr>
                </table>
        </form>
            </div>
        </div>
        <div class="footer"></div>
    <?php
    print $hibakod;
            print "<form action = '' method = 'get'>
            <table class = 'link'>
            <tr>
                <td><a href = '?c=".$oldal[0]["cim"]."' class = 'link-format'>".$oldal[0]["cim"]."</a></td>
                <td><a href = '?c=".$oldal[1]["cim"]."' class = 'link-format'>".$oldal[1]["cim"]."</a></td>
                <td><a href = '?c=".$oldal[2]["cim"]."' class = 'link-format'>".$oldal[2]["cim"]."</a></td>
            </tr>
            </table>
            </form>";
        }
        if(isset($_SESSION["id"]) && !isset($_POST["regisztracio"])){
    ?>
    <div class = "header">
        <div class="menu">
            <h1>Diákok</h1>
            <form action="" method="post">
                <?php
                    print "<form action = '' method = 'get'>
                    <table class = 'link'>
                    <tr>
                        <td><a href = '?c=".$oldal[0]["cim"]."' class = 'format'>".$oldal[0]["cim"]."</a></td>
                        <td><a href = '?c=".$oldal[1]["cim"]."' class = 'format'>".$oldal[1]["cim"]."</a></td>
                        <td><a href = '?c=".$oldal[2]["cim"]."' class = 'format'>".$oldal[2]["cim"]."</a></td>
                    </tr>
                    </table>
                    </form>";
                ?>
            </form>
            </div>
        </div>
    <form action="" method="post">
        <button type="submit" name = "kijelentkezes">Kijelentkezés</button> 
    </form>
    <table>
        <tr>

    <?php
        }
    if(isset($_GET["c"])){
        if($_GET["c"] == "Főoldal"){
            if(isset($_SESSION["id"])){
                print "Üdvözöllek az oldalon!";
        ?>
        </tr>
    </table>
    <?php
            }else{
                print "A tartalom megjelenitéséhez be kell jelentkeznie";
            }
        }else if($_GET["c"] == "Rólunk"){
            print "Mi vagyunk a legjobbak!44!";
        }else if($_GET["c"] == "Adatbázis" && isset($_SESSION["id"])){
    ?>
    <form action="" method="post">
                <table>
                    <tr>
                        <td><label for = "MfelhaszId">Id:</label></td>
                        <td><input type="number" name="MfelhaszId" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <td><label for="MfelhaszNev">Felhasználónév:</label></td>
                        <td><input type="text" name="MfelhaszNev" autocomplete="off"></td>
                    </tr>
                </table>
                <button type="submit" name="listaz">Listáz</button>
                <button type="submit" name = "modosit">Módosít</button>
                <button type="submit" name = "torol">Töröl</button>
                <button type="submit">Feltölt</button>
            </form>
    <?php
        }else{
            print "Ehhez a tartalomhoz csak a regisztrált felhasználók férhetnek hozzá!";
        }
        print "<br><br>";
        if(isset($_POST['listaz'])){
            $listazas = $csatlakozas -> query("SELECT * FROM felhasznalo");
            while($sor = $listazas -> fetch_assoc()){
                print "<br><form action='' method='get'>
                <table class='listazas'>
                    <tr>    
                        <td id='id'> " . $sor['id'] . " </td>
                        <td>    </td>
                        <td id='nev'> " . $sor['nev'] . " </td>
                    </tr>
                </table>
                </form>
                ";
            }
        }

        if(isset($_POST['modosit'])){
            $listazas = $csatlakozas -> query("SELECT * FROM felhasznalo");
            while($sor = $listazas -> fetch_assoc()){
                print "<br><form action='' method='POST'>
                <table class='listazas'>
                    <tr>    
                        <td id='id'><button type='submit' name='link'>" . $sor['id'] . "</button></td>
                        <td>    </td>
                        <td id='nev'> " . $sor['nev'] . " </td>
                    </tr>
                </table>
                </form>
                ";
            }
        }
        if(isset($_POST['link'])){
            print "<br><form action='' method='POST'>
            <label>Id megváltoztatás: </label><br>
            <input type='number' name='mod_id' required><br>
            <label>Felhasználónév megváltoztatás: </label><br>
            <input type='text' name='mod_nev' required><br>
            <label>Jelszó megváltoztatás: </label><br>
            <input type='number' name='mod_jelszo' required><br>
            <button type='submit'>Megváltoztat</button>
            </form>
            ";
        }

        if(isset($_POST['mod_id']) || isset($_POST['mod_nev']) || isset($_POST['mod_jelszo'])){
            print "letezik";
            $csatlakozas -> query("UPDATE felhasznalo SET id = " . $_POST['mod_id'] . ", nev = '" . $_POST['mod_nev'] . "', jelszo = " . $_POST['mod_jelszo'] . ";");
        }

    }
    if(isset($_POST["regisztracio"])){

    ?>
    <input type="text">

    <form action="" method="post">
        <label for="regNev">Add meg a neved:</label>
        <input type="text" name="regNev" required>
        <label for="regJelszo">Add meg a jelszót:</label>
        <input type="password" name="regJelszo" required>
        <button type="submit" name = "">Regisztráció</button>
    </form>
    <?php
    }
    ?>
</body>
</html>