<?php 
include_once('./database.php');

include_once('./functions.php');

$sql = "SELECT * FROM records ORDER BY date";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$records = $stmt->fetchAll();

$sql2 = "select type, SUM(amount) from records GROUP BY type;";

$stmt = $pdo->prepare($sql2);

$stmt->execute();

$sumtable = $stmt->fetchAll();

$sql3 = "SELECT * FROM categories;";

$stmt = $pdo->prepare($sql3);

$stmt->execute();

$categories = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title class="title">Household Accounts</title>
</head>
<body>
  <a name="top"></a>

  <div class="container">
    <header class="title">
      <a class="title">Household Accounts</a>
    </header>
    <!-- <a class="viewtotal" href="./viewForm.php">View Total</a> -->

    <div class="container">
    <form class="m-5" action="./searchForm.php" method="POST">
      <p class="alert alert-primary" role="alert">Search Form</p>
      <div class="form-group">
        <label for="date">Date</label>
        <input type="search" class="form-control" id="date" name="date" placeholder="2022-01-01, 2022-01, 2022-01-0, etc.">
      </div>
      <div class="form-group">
        <label for="title">Category</label><br>
        <p>
        <select class="form-control" name="title", id="title">
          <option value="">カテゴリーを絞らない</option>
          <?php foreach($categories as $category): ?>
          <option value="<?php echo h($category['category']); ?>"><?php echo h($category['category']); ?></option>
          <?php endforeach; ?>
        </select>
        </p>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success search">Submit</button>
      </div>
    </form>
    </div>

    <a class="create create-a" href="./createForm.php">Create New</a>
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
                    <a href="./delete.php?id=<?php echo h($record['id']); ?>" class="btn btn-danger text-light" onclick="return confirm('Really delete Data?');">Deletion</a>
                  </td>
                </tr>

              <?php endforeach; ?>
              <?php foreach($sumtable as $sum): ?>
                <tr  bgcolor="#bcffff">
                  <td class="sum"><?php if(h($sum['type']) == 0){echo h("Income SUM:");} else {echo h("Spending SUM:");} ?></td>
                  <td class="col-2"><?php echo h(""); ?></td>
                  <td class="col-2"><?php echo h(""); ?></td>
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
  
  <div class="top">
    <a href="#top">Back to Top</a>
  </div>
</body>
</html>