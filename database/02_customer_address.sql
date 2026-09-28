--Creates customer address storage
ALTER TABLE customer ADD COLUMN customer_address VARCHAR(255) DEFAULT NULL;

ALTER TABLE customer CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
