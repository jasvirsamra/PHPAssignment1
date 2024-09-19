<?php
require_once('database.php');

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);

$queryProduct = 'SELECT * FROM products WHERE productID = :product_id';
$statement = $db->prepare($queryProduct);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$product = $statement->fetch();
$statement->closeCursor();

$queryCategories = 'SELECT * FROM categories ORDER BY categoryID';
$statement = $db->prepare($queryCategories);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="update_product.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

        <label>Category:</label>
        <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>" 
                    <?php if ($category['categoryID'] == $product['categoryID']) echo 'selected'; ?>>
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Code:</label>
        <input type="text" name="code" value="<?php echo $product['productCode']; ?>"><br>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $product['productName']; ?>"><br>

        <label>Price:</label>
        <input type="text" name="price" value="<?php echo $product['listPrice']; ?>"><br>

        <input type="submit" value="Update Product">
    </form>
</body>
</html>
