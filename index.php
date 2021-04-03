<?php

    include ("Conversion.php");

    if(isset($_POST['submit'])){
        $value = $_POST['amount'];
        $type = $_POST['currency'];

        $data = new Conversion();
        $data->economies();
        $inputs = $data->notations();
        $received = $data->retreive($type);
    }
    else{
        $data = new Conversion();
        $data->economies();
        $inputs = $data->notations();
        $received = $data->retreive();
        $value = 1;
        $type = "USD";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Currencies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Coiny' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>

    <style>

        #bg-color{
            background-image: url("background.jpg");
            background-repeat: revert;
            background-size: 100% 100%;
        }

    </style>

</head>
<body id="bg-color">
    <div class="topnav-centered">
        <h3 class="h3 " style="font-family:Coiny; font-size: 55px; text-align: center; color: black; padding-top: 10px ">
            Currency Calculator
        </h3>
    </div>


<div class="container">
    <form action="" method="POST">
        <div class="form-row align-items-center">
            <div class="col">
                <label for="amt" style="padding: 15px; font-family: Josefin Sans; color: midnightblue">Value : </label>
                <input type="text" style="padding-right: 25px" name="amount" id="amt" placeholder="<?php echo $value; ?>" value="<?php echo $value; ?>">
            </div>
            <div class="col">
                <label for="change" style="padding: 15px; font-family: Josefin Sans; color: midnightblue">Currency : </label>
                <select name="currency" id="change" style="padding-right: 25px">
                    <option value="USD"
                        <?php
                            if($type == "USD")
                                echo "selected=\"selected\"";
                        ?>>United States (US Dollar - USD)</option>
                    <option value="CNY"
                        <?php
                        if($type == "CNY")
                            echo "selected=\"selected\"";
                        ?>>China (Yuan Renminbi - CNY)</option>
                    <option value="JPY"
                        <?php
                        if($type == "JPY")
                            echo "selected=\"selected\"";
                        ?>>Japan (Yen - JPY)</option>
                    <option value="EUR"
                        <?php
                        if($type == "EUR")
                            echo "selected=\"selected\"";
                        ?>>Germany (Euro - EUR)</option>
                    <option value="INR"
                        <?php
                        if($type == "INR")
                            echo "selected=\"selected\"";
                        ?>>India (Indian Rupee - INR)</option>
                    <option value="GBP"
                        <?php
                        if($type == "GBP")
                            echo "selected=\"selected\"";
                        ?>>United Kingdom (Pound Sterling - GBP)</option>
                    <option value="EUR"
                        <?php
                        if($type == "EUR")
                            echo "selected=\"selected\"";
                        ?>>France (Euro - EUR)</option>
                    <option value="EUR"
                        <?php
                        if($type == "EUR")
                            echo "selected=\"selected\"";
                        ?>>Italy (Euro - EUR)</option>
                    <option value="BRL"
                        <?php
                        if($type == "BRL")
                            echo "selected=\"selected\"";
                        ?>>Brazil (Brazilian Real - BRL)</option>
                    <option value="CAD"
                        <?php
                        if($type == "CAD")
                            echo "selected=\"selected\"";
                        ?>>Canada (Canadian Dollar - CAD)</option>
                </select>
            </div>
            <div class="col" style="padding: 12px; font-family: Josefin Sans; color: midnightblue">
                <input type="submit" class ="btn btn-outline-dark" value="Submit" name="submit" style="">
            </div>
        </div>

        <div style="padding: 10px 0px 12px 0px; font-family: Josefin Sans ;">
            <h2>Top 10 Economies In World</h2>
        </div>

        <table id="example" class="table table-bordered table-hover table-striped  table-responsive table-dark " style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Country</th>
                    <th>Currency</th>
                    <th>Conversion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 1;
                    for ($i =0 ; $i<10 ; $i++){
                        echo "<tr><td>".$index."</td><td>".$inputs[0][$i]."</td>
                                <td>".$inputs[2][$i]."</td>";
                        for($j=0 ; $j<8 ; $j++){
                            if($inputs[1][$i] == $received[0][$j]){
                                echo "<td>".round((float)$value * $received[1][$j], 3)." ".$inputs[1][$i]."</td></tr>";
                                break;
                            }
                        }
                        $index++;
                    }
                ?>
            </tbody>
        </table>
    </form>
</div>

</body>
</html>
