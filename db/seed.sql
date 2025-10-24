-- db/seed.sql
-- SQL setup and sample data for Library Management System

-- Create database (if not exists)
CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

-- =============================
-- TABLES
-- =============================

-- Books table
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    total_copies INT NOT NULL,
    available_copies INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Borrowers table
CREATE TABLE IF NOT EXISTS borrowers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(50),
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Transactions table
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    borrower_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE DEFAULT NULL,
    status ENUM('borrowed','returned','overdue') DEFAULT 'borrowed',
    FOREIGN KEY (borrower_id) REFERENCES borrowers(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- =============================
-- SAMPLE DATA
-- =============================

-- Books
INSERT INTO books (title, author, total_copies, available_copies) VALUES
('Things Fall Apart', 'Chinua Achebe', 5, 5),
('Half of a Yellow Sun', 'Chimamanda Ngozi Adichie', 3, 3),
('The Great Gatsby', 'F. Scott Fitzgerald', 4, 4),
('To Kill a Mockingbird', 'Harper Lee', 2, 2);

-- Borrowers
INSERT INTO borrowers (name, email, phone) VALUES
('Ikenna Ilono', 'ikenna@example.com', '08123456789'),
('Mary Okafor', 'mary.okafor@example.com', '08098765432'),
('James Eze', 'james.eze@example.com', '08122223333');

-- Transactions
INSERT INTO transactions (borrower_id, book_id, borrow_date, due_date, status) VALUES
(1, 1, '2025-10-10', '2025-10-17', 'borrowed'),
(2, 2, '2025-10-05', '2025-10-12', 'returned');

-- =============================
-- VIEWS (for easy reports)
-- =============================
CREATE OR REPLACE VIEW view_overdue_books AS
SELECT 
    t.id AS transaction_id,
    b.title AS book_title,
    br.name AS borrower_name,
    t.due_date,
    DATEDIFF(CURDATE(), t.due_date) AS days_overdue
FROM transactions t
JOIN books b ON t.book_id = b.id
JOIN borrowers br ON t.borrower_id = br.id
WHERE t.status = 'borrowed' AND t.due_date < CURDATE();

-- =============================
-- CSV/REPORT EXPORT HELPERS (optional)
-- =============================
-- Use SELECT * FROM view_overdue_books; for quick overdue list
-- Use SELECT * FROM books; to export inventory
-- Use SELECT * FROM borrowers; for borrower list

-- End of seed.sql



-- 🧭 Instructions for setup

-- In phpMyAdmin or your MySQL CLI, run:

-- mysql -u root -p < db/seed.sql


-- Update your db/connect.php file to connect to library_db.

-- That’s it — your database will now have all tables and initial data for demo/testing.