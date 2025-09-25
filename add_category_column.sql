-- Add category column to products table
ALTER TABLE `products` ADD COLUMN `category` VARCHAR(50) DEFAULT 'general' AFTER `name`;

-- Update existing products with categories based on their names
UPDATE `products` SET `category` = 'laptop' WHERE `name` LIKE '%laptop%' OR `name` LIKE '%Laptop%';
UPDATE `products` SET `category` = 'smartphone' WHERE `name` LIKE '%smartphone%' OR `name` LIKE '%phone%' OR `name` LIKE '%iPhone%';
UPDATE `products` SET `category` = 'tv' WHERE `name` LIKE '%tv%' OR `name` LIKE '%television%' OR `name` LIKE '%TV%';
UPDATE `products` SET `category` = 'camera' WHERE `name` LIKE '%camera%' OR `name` LIKE '%Camera%';
UPDATE `products` SET `category` = 'mouse' WHERE `name` LIKE '%mouse%' OR `name` LIKE '%Mouse%';
UPDATE `products` SET `category` = 'fridge' WHERE `name` LIKE '%fridge%' OR `name` LIKE '%Fridge%';
UPDATE `products` SET `category` = 'washing' WHERE `name` LIKE '%washing%' OR `name` LIKE '%Washing%';
UPDATE `products` SET `category` = 'watch' WHERE `name` LIKE '%watch%' OR `name` LIKE '%Watch%';
UPDATE `products` SET `category` = 'storage' WHERE `name` LIKE '%usb%' OR `name` LIKE '%USB%' OR `name` LIKE '%pendrive%' OR `name` LIKE '%flash%' OR `name` LIKE '%storage%' OR `name` LIKE '%hard%disk%' OR `name` LIKE '%ssd%' OR `name` LIKE '%memory%card%' OR `name` LIKE '%sd%card%' OR `name` LIKE '%external%hard%' OR `name` LIKE '%pen%drive%' OR `name` LIKE '%thumb%drive%';
