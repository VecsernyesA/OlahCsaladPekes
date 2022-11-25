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
        <form action="" method="post">
            <button type="submit" name = "regisztracio">Regisztráció</button>
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
            if(isset($_SESSION["id"]) && !isset($_POST["regisztracio"])){
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
                        <td><input type="number" name="MfelhaszId" autocomplete="off" required></td>
                    </tr>
                    <tr>
                        <td><label for="MfelhaszNev">Felhasználónév:</label></td>
                        <td><input type="text" name="MfelhaszNev" autocomplete="off" required></td>
                    </tr>
                </table>
                <button type="submit" name = "modosit">Módosít</button>
                <button type="submit" name = "torol">Töröl</button>
                <button type="submit">Feltölt</button>
            </form>
    <?php
        }else{
            print "Ehhez a tartalomhoz csak a regisztrált felhasználók férhetnek hozzá!";
        }
    }
    ?>
</body>
</html>