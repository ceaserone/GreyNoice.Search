<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Search | GreyNoise</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>GreyNoise IP Search</h1>
        <form action="search.php" method="GET">
            <input type="text" name="ip" placeholder="Enter an IP address" required>
            <button type="submit">Search</button>
        </form>
        <div id="result">
            <?php
            if (isset($_GET['message'])) {
                echo '<p class="error">'.htmlspecialchars($_GET['message']).'</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
