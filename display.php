<?php
    $db = fopen("who_covid_southeast.csv", "r");
    $result = array();
    flock($db, LOCK_SH);
    $headings = fgetcsv($db, 0, "\t");
    while ($line = fgetcsv($db, 0, "\t")) {
        list($date, $nationCode, $nation, $who_region, $nCases, $cCases, $nDeath, $cDeath) = explode(",", $line[0]);
        if ($nationCode == "SG"){
            array_push($result, array($date, $cCases));
        }
    }
    flock($db, LOCK_UN);
    fclose($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Display Data</title>
</head>
<body>
    <h1>COVID Report</h1>
    <table>
        <tr>
            <th>Reported Date</th>
            <th>Cumulative Cases</th>
        </tr>
        <?php if ($_GET["time"] == "1") : ?>
            <?php for($i = 1; $i <= 10; $i++) : ?>
                <tr>
                    <td><?php echo $result[$i][0]?></td>
                    <td><?php echo $result[$i][1]?></td>
                </tr>
            <?php endfor ?>
        <?php endif?>        
        <?php if ($_GET["time"] == "2") : ?>
            <?php $i = 1;?>
                <?php for($j = 0; $j<count($result); $j++) : ?>
                    <?php 
                        // If wrote enough 10 months
                        if ($i>10) {
                            break;
                        }

                        // Take the reported date to check if it is the first date of each month
                        $reportedDate = explode("/", $result[$j][0]);
                        if ($reportedDate[1] == "1") :
                    ?>
                        <tr>
                            <td><?php echo $result[$j][0]?></td>
                            <td><?php echo $result[$j][1]?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endif ?>
                <?php endfor ?>
        <?php endif?>  
    </table>
</body>
</html>