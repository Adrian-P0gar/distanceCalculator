<html>


<body>
<h1> This is the distance calculator</h1>

<?php

$dbhost = 'localhost';
$dbuser = 'pogar';
$dbpass = 'bonfiscal706623';
$db = 'distancecalculator';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if (!$conn) {
    die('Could not connect: '. mysqli_connect_error());
}

$userQuery = "SELECT * FROM distances";
$result = mysqli_query($conn, $userQuery);

if(!$result){
    die("Query do not execute". mysqli_error($conn));
}
else{
    echo "<table> <tr> <th> X </th><th>Bucuresti</th><th>Alba Iulia</th><th>Arad</th><th>Bacau</th><th>Baia Mare</th><th>Brasov</th><th>Braila</th>
         <th>Cluj</th><th>Constanta</th><th>Craiova</th></tr> <br>";

    while( $row = mysqli_fetch_array($result) ){
        echo "<tr><td>".$row['Direction']."</td><td>".$row['Bucuresti']."</td><td>"
            .$row['Alba Iulia']."</td><td>".$row['Arad']."</td><td>".$row['Bacau']."</td><td>".$row['Baia Mare']."</td><td>". $row['Brasov'].
            "</td><td>".$row['Braila']."</td><td>".$row['Cluj']."</td><td>".$row['Constanta']."</td><td>".$row['Craiova']."</td></tr>";
    }
    echo "</table>";
}

    function getAllCities($conn, $query){

        $result = mysqli_query($conn, $query);

        while ($direction = mysqli_fetch_array($result)){

            echo "<option value='".$direction['Direction']."'>".$direction['Direction']."</option>";
        }
    }

?>

<form action="index.php" method="get">
    <select name="firstDirection">
        <?php getAllCities($conn, $userQuery); ?>
    </select>

    <select name="secondDirection">
        <?php
        getAllCities($conn, $userQuery);

        ?>
    </select>
    <select name="transportation">
        <option value="motorway"> Motorway</option>
        <option value="railway"> Railway</option>
    </select>

    <input type="submit" VALUE="Calculate">
</form>

</body>
    <?php

    function getResponse($conn, $query){
        $getData = mysqli_query($conn,$query);
        while (($i = mysqli_fetch_array($getData))){
           return $i[0];
        }
    }


    if(isset($_GET['firstDirection']) and isset($_GET['secondDirection']) and isset($_GET['transportation'])){
        $firstDirection = $_GET['firstDirection'];
        $secondDirection = $_GET['secondDirection'];
        $transportation = $_GET['transportation'];
        $motorwayQuery = '';
        $firstDirectionID = 'SELECT ID FROM distances WHERE Direction="'.$firstDirection.'"';
        $secondDirectionID = 'SELECT ID FROM distances WHERE Direction="'.$secondDirection.'"';
        $getFirstDirectionId = getResponse($conn ,$firstDirectionID);
        $getSecondDirectionID = getResponse($conn, $secondDirectionID);
        if($transportation === "motorway"){
            if($getFirstDirectionId == $getSecondDirectionID){
                echo "The distance between: " . $firstDirection . " and ". $secondDirection. " is: 0";
            }
            if($getFirstDirectionId < $getSecondDirectionID){
                $motorwayQuery = "SELECT ".$secondDirection." FROM distances WHERE Direction='".$firstDirection."'";
                $response = mysqli_query($conn, $motorwayQuery);
                if(!$response){
                    die("Query do not execute". mysqli_error($conn));}
                else{

                    while( $row = mysqli_fetch_array($response) ){
                        echo "The distance between " . $firstDirection . " and ". $secondDirection. " by motorway is: ". $row[$secondDirection];
                    }
                }
            }elseif($getFirstDirectionId > $getSecondDirectionID){
                $motorwayQuery = "SELECT ".$firstDirection." FROM distances WHERE Direction='".$secondDirection."'";
                $response = mysqli_query($conn, $motorwayQuery);
                if(!$response){
                    die("Query do not execute". mysqli_error($conn));}
                else{

                    while( $row = mysqli_fetch_array($response) ){
                        echo "The distance between " . $firstDirection . " and ". $secondDirection. " by motorway is: ". $row[$firstDirection];
                    }
                }
            }

        }
        if($transportation === "railway"){
            if($getFirstDirectionId == $getSecondDirectionID){
                echo "The distance between: " . $firstDirection . " and ". $secondDirection. " is: 0";
            }
            if($getFirstDirectionId < $getSecondDirectionID){
                $motorwayQuery = "SELECT ".$firstDirection." FROM distances WHERE Direction='".$secondDirection."'";
                $response = mysqli_query($conn, $motorwayQuery);
                if(!$response){
                    die("Query do not execute". mysqli_error($conn));}
                else{

                    while( $row = mysqli_fetch_array($response) ){
                        echo "The distance between " . $firstDirection . " and ". $secondDirection. " by railway is: ". $row[$firstDirection];
                    }
                }
            }elseif($getFirstDirectionId > $getSecondDirectionID){
                $motorwayQuery = "SELECT ".$secondDirection." FROM distances WHERE Direction='".$firstDirection."'";
                $response = mysqli_query($conn, $motorwayQuery);
                if(!$response){
                    die("Query do not execute". mysqli_error($conn));}
                else{

                    while( $row = mysqli_fetch_array($response) ){
                        echo "The distance between " . $firstDirection . " and ". $secondDirection. " by railway is: ". $row[$secondDirection];
                    }
                }
            }

        }



        mysqli_close($conn);
    }


    ?>



</html>

