<?php
require_once('db.php');

$test = new Database();
print_R($test->getStudent());
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./styles.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="container">
        <aside>
            <ul>
                <li>mdr</li>
                <li>mdr</li>
                <li>mdr</li>
                <li>mdr</li>
            </ul>
        </aside>
        <main>
            <table>
                <!-- <?php
                        foreach ($results as $result) {
                            foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value; ?></td>
                        </tr>
                <?php    }
                        }
                ?> -->
            </table>
        </main>
    </div>
</body>

</html>