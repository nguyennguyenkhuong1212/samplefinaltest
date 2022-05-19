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
        <tr class="oddRows">
            <td>Reported Date</td>
            <td>Cumulative Cases</td>
        </tr>
        <?php if ($_GET["time"] == "1") : ?>
            <?php for($i = 1; $i <= 10; $i++) : ?>
                <?php if ($i % 2 == 0) : ?>
                    <tr class="oddRows">
                        <td><?php echo $result[$i][0]?></td>
                        <td><?php echo $result[$i][1]?></td>
                    </tr>
                <?php endif?>
                <?php if ($i % 2 == 1) : ?>
                    <tr class="evenRows">
                        <td><?php echo $result[$i][0]?></td>
                        <td><?php echo $result[$i][1]?></td>
                    </tr>
                <?php endif?>
            <?php endfor ?>
        <?php endif?>        
        <?php if ($_GET["time"] == "2") : ?>
            <?php $i = 1; $j = 0;?>
                <?php for(; $j<count($result); $j++) : ?>
                    <?php if ($i>10) {break;}?>
                    <?php $reportedDate = explode("/", $result[$j][0]);?>
                    <?php if ($reportedDate[1] == "1") : ?>
                        <?php if ($i % 2 == 0) : ?>
                            <tr class="oddRows">
                                <td><?php echo $result[$j][0]?></td>
                                <td><?php echo $result[$j][1]?></td>
                            </tr>
                        <?php endif ?>
                        <?php if ($i % 2 == 1) : ?>
                            <tr class="evenRows">
                                <td><?php echo $result[$j][0]?></td>
                                <td><?php echo $result[$j][1]?></td>
                            </tr>
                        <?php endif ?>
                        <?php $i++; ?>
                    <?php endif ?>
                <?php endfor ?>
        <?php endif?>  
    </table>
</body>
</html>