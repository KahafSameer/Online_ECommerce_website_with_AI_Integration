<?php
// Database update script for adding category column
include 'components/connect.php';

echo "<h2>Database Update Script</h2>";

try {
    // Check if category column already exists
    $check_column = $conn->prepare("SHOW COLUMNS FROM `products` LIKE 'category'");
    $check_column->execute();
    
    if($check_column->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Category column already exists!</p>";
    } else {
        // Add category column
        $add_column = $conn->prepare("ALTER TABLE `products` ADD COLUMN `category` VARCHAR(50) DEFAULT 'general' AFTER `name`");
        $add_column->execute();
        echo "<p style='color: green;'>✅ Category column added successfully!</p>";
        
        // Update existing products with categories
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
        
        echo "<p style='color: green;'>✅ Existing products categorized successfully!</p>";
    }
    
    echo "<p style='color: blue;'>🎉 Database update completed! You can now use the Storage Devices category.</p>";
    echo "<p><a href='admin/products.php'>Go to Admin Panel</a> | <a href='home.php'>Go to Home Page</a></p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
