<?php

include_once('./database.php');

include_once('./functions.php');

$sql = "SELECT * FROM categories;";

$stmt = $pdo->prepare($sql);

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
  <title>Household Accounts</title>
</head>
<body>

  <div class="container">
    <form class="m-5" action="./create.php" method="POST">
      <p class="alert alert-primary" role="alert">Create Form</p>
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" name="date" required>
      </div>
      <div class="form-group">
        <label for="title">Category</label><br>
        <p>
        <select class="form-control" name="title", id="title">
        <?php foreach($categories as $category): ?>
          <option value="<?php echo h($category['category']); ?>"><?php echo h($category['category']); ?></option>
        <?php endforeach; ?>
        </select>
        </p>
      </div>
      <div class="form-group">
        <label for="details">Category Details</label>
        <input type="text" class="form-control" id="details" name="details" placeholder="Italian, ZOZO, game, etc." required>
      </div>
      <div class="form-group">
        <label for="amount">Amount</label>
        <input type="number" class="form-control" id="amount" name="amount" placeholder="Natural numbers only." required>
      </div>
      <div class="form-group">
        <input type="reset" class="btn btn-danger reset" value="Reset of Enter" onclick="return confirm('Really reset Enter?');"></button>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>

  <div class="home">
    <a href="./index.php">Back to Home</a>
  </div>
</body>
</html>