<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Update</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        .btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px; display: inline-block; }
    </style>
</head>
<body>
    <h1>Database Update Script</h1>
    
    <?php
    include 'components/connect.php';
    
    try {
        echo "<h2>Checking Database Structure...</h2>";
        
        // Check if category column exists
        $check_column = $conn->prepare("SHOW COLUMNS FROM `products` LIKE 'category'");
        $check_column->execute();
        
        if($check_column->rowCount() > 0) {
            echo "<p class='success'>✅ Category column already exists!</p>";
        } else {
            echo "<p class='info'>📝 Adding category column...</p>";
            
            // Add category column
            $add_column = $conn->prepare("ALTER TABLE `products` ADD COLUMN `category` VARCHAR(50) DEFAULT 'general' AFTER `name`");
            $add_column->execute();
            echo "<p class='success'>✅ Category column added successfully!</p>";
            
            // Update existing products with categories
            echo "<p class='info'>📝 Categorizing existing products...</p>";
            
            $update_queries = [
                "UPDATE `products` SET `category` = 'laptop' WHERE `name` LIKE '%laptop%' OR `name` LIKE '%Laptop%'",
                "UPDATE `products` SET `category` = 'smartphone' WHERE `name` LIKE '%smartphone%' OR `name` LIKE '%phone%' OR `name` LIKE '%iPhone%'",
                "UPDATE `products` SET `category` = 'tv' WHERE `name` LIKE '%tv%' OR `name` LIKE '%television%' OR `name` LIKE '%TV%'",
                "UPDATE `products` SET `category` = 'camera' WHERE `name` LIKE '%camera%' OR `name` LIKE '%Camera%'",
                "UPDATE `products` SET `category` = 'mouse' WHERE `name` LIKE '%mouse%' OR `name` LIKE '%Mouse%'",
                "UPDATE `products` SET `category` = 'fridge' WHERE `name` LIKE '%fridge%' OR `name` LIKE '%Fridge%'",
                "UPDATE `products` SET `category` = 'washing' WHERE `name` LIKE '%washing%' OR `name` LIKE '%Washing%'",
                "UPDATE `products` SET `category` = 'watch' WHERE `name` LIKE '%watch%' OR `name` LIKE '%Watch%'",
                "UPDATE `products` SET `category` = 'storage' WHERE `name` LIKE '%usb%' OR `name` LIKE '%USB%' OR `name` LIKE '%pendrive%' OR `name` LIKE '%flash%' OR `name` LIKE '%storage%' OR `name` LIKE '%hard%disk%' OR `name` LIKE '%ssd%' OR `name` LIKE '%memory%card%' OR `name` LIKE '%sd%card%' OR `name` LIKE '%external%hard%' OR `name` LIKE '%pen%drive%' OR `name` LIKE '%thumb%drive%'"
            ];
            
            foreach($update_queries as $query) {
                $stmt = $conn->prepare($query);
                $stmt->execute();
            }
            
            echo "<p class='success'>✅ Existing products categorized successfully!</p>";
        }
        
        echo "<h2 class='success'>🎉 Database update completed!</h2>";
        echo "<p class='info'>You can now:</p>";
        echo "<ul>";
        echo "<li>Add new products with categories</li>";
        echo "<li>Use the Storage Devices category</li>";
        echo "<li>Update existing products</li>";
        echo "</ul>";
        
        echo "<div style='margin-top: 20px;'>";
        echo "<a href='admin/products.php' class='btn'>Go to Admin Panel</a>";
        echo "<a href='home.php' class='btn'>Go to Home Page</a>";
        echo "</div>";
        
    } catch(PDOException $e) {
        echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>
