<?php
include_once('./database.php');

include_once('./functions.php');

$date = $_POST['date'];
$title = $_POST['title'];
$type = 1;

if ($title == "仕送り" or $title == "給与" or $title == "その他の収入"){
    $type = 0;
}

if (!empty($date)){
    $date = $date . "%";
}
if (!empty($title)){
    $title = $title . "%";
}

if (empty($date) and empty($title)){
    $sql = "SELECT * FROM records order by date;";
    $stmt = $pdo->prepare($sql);
} else if (empty($date)){
    $sql = "SELECT * FROM records WHERE title like :title order by date;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
} elseif (empty($title)){
    $sql = "SELECT * FROM records WHERE date like :date order by date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
} else {
    $sql = "SELECT * FROM records WHERE date like :date and title like :title order by date;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
}

$stmt->execute();

$records = $stmt->fetchAll();

if (empty($date) and empty($title)){
    $sql2 = "select type, SUM(amount) from records GROUP BY type;";
    $stmt = $pdo->prepare($sql2);
} elseif (empty($date)){
    $sql2 = "select type, SUM(amount) from records where title like :title GROUP BY type;";
    $stmt = $pdo->prepare($sql2);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
} elseif (empty($title)){
    $sql2 = "select type, SUM(amount) from records where date like :date GROUP BY type;";
    $stmt = $pdo->prepare($sql2);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
} else {
    $sql2 = "select type, SUM(amount) from records where date like :date and title like :title GROUP BY type;";
    $stmt = $pdo->prepare($sql2);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
}

$stmt->execute();

$details = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Household Accounts</title>
</head>
<body>
  <div class="container">
    <header class="mb-5">
      <p class="alert alert-primary" role="alert">Search Results</p>
    </header>

    <p class="search-Contents">--Search Contents--</p>
    <table class=""search-item>
    <thead>
        <tr>
            <td>Date: "<?php echo substr($date, 0, -1); ?>"</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Category: "<?php echo substr($title, 0, -1); ?>"</td>
        </tr>
    </tbody>
</table>

    <tr class="search-item">
       
    </tr>

    <div class="row">
      <div class="col-12">

        <div class="table-responsive">
          <table class="table table-fixed">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="col-2">Date</th>
                <th scope="col" class="col-2">Category</th>
                <th scope="col" class="col-2">Details</th>
                <th scope="col" class="col-2">Income</th>
                <th scope="col" class="col-2">Spending</th>
                <th scope="col" class="col-3">Option</th>
              </tr>
            </thead>

            <tbody>

              <?php foreach($records as $record): ?>

                <tr>
                    <td class="col-2"><?php echo h($record['date']); ?></td>
                    <td class="col-2"><?php echo h($record['title']); ?></td>
                    <td class="col-2"><?php echo h($record['details']); ?></td>
                    <td class="col-2"><?php echo h($record['type']) == 0 ? h($record['amount']) : '' ?></td>
                    <td class="col-2"><?php echo h($record['type']) == 1 ? h($record['amount']) : '' ?></td>
                    <td class="col-3">
                        <a href="./editForm.php?id=<?php echo h($record['id']); ?>" class="btn btn-success text-light">Editing</a>
                        <a href="./delete.php?id=<?php echo h($record['id']); ?>" class="btn btn-danger text-light" onclick="return confirm('Really delete Data?   ※Click ”OK” to back home.');">Deletion</a>
                    </td>
                </tr>

              <?php endforeach; ?>
                <?php foreach($details as $sum): ?>
                <tr  bgcolor="#bcffff">
                  <td class="sum"><?php if(h($sum['type']) == 0){echo h("Income SUM:");} else {echo h("Spending SUM:");} ?></td>
                  <td class="col-3"><?php echo h(""); ?></td>
                  <td class="col-3"><?php echo h(""); ?></td>
                  <td class="col-2"><?php echo h($sum['type']) == 0 ? h($sum['SUM(amount)']) : '' ?></td>
                  <td class="col-2"><?php echo h($sum['type']) == 1 ? h($sum['SUM(amount)']) : '' ?></td>
                  <td class="col-3"><?php echo h(""); ?></td>
                </tr>
              
              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <div class="home">
    <a href="./index.php">Back to Home</a>
  </div>
</body>
</html>