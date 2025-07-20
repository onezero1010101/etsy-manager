CREATE TABLE etsy_listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id BIGINT UNIQUE,
    title VARCHAR(255),
    description TEXT,
    quantity INT,
    sku TEXT,
    price DECIMAL(10,2),
    tags TEXT,
    state VARCHAR(50),
    image_url TEXT,
    last_updated DATETIME
);