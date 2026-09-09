CREATE TABLE offers (
    offer_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    discount_percentage DECIMAL(5,2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB;

-- =====================================================================
-- END OF FILE
-- =====================================================================