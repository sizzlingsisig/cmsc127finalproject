DROP DATABASE IF EXISTS `gym`;
CREATE DATABASE `gym`;
USE `gym`;

CREATE TABLE staff (
    staff_ID INT AUTO_INCREMENT PRIMARY KEY,
    staff_name VARCHAR(50) NOT NULL,
    role VARCHAR(30),
    contact_info VARCHAR(50),
    hire_date DATE
);

CREATE table members (
    member_ID INT AUto_INCREMENT PRIMARY KEY,
    member_name VARCHAR(50),
    contact_info VARCHAR(50),
    membership_status ENUM('active', 'inactive', 'cancelled') DEFAULT 'active'
);

CREATE TABLE membership (
    membership_ID INT AUTO_INCREMENT PRIMARY KEY,
    membership_type ENUM('weekly', 'monthly', 'yearly') NOT NULL,
    price DECIMAL(10,2) CHECK (price >= 0),
    duration INT CHECK (duration > 0)
);

CREATE TABLE subscribes (
    subscription_ID INT AUTO_INCREMENT PRIMARY KEY,
    member_ID INT NOT NULL,
    membership_ID INT NOT NULL,
    purchase_date DATE,
    start_date DATE,
    end_date DATE,
    FOREIGN KEY (member_ID) REFERENCES members(member_ID),
    FOREIGN KEY (membership_ID) REFERENCES membership(membership_ID)
);

CREATE TABLE payment ( 
    receipt_number INT AUTO_INCREMENT PRIMARY KEY,
    member_ID INT,
    staff_ID INT, 
    membership_ID INT, 
    amount DECIMAL(10,2),
    payment_date DATE,
    payment_type ENUM('cash', 'gcash', 'bdo') DEFAULT 'cash',
    FOREIGN KEY (member_ID) REFERENCES members(member_ID),
    FOREIGN KEY (membership_ID) REFERENCES membership(membership_ID),
    FOREIGN KEY (staff_ID) REFERENCES staff(staff_ID)

);

CREATE TABLE attendance (
    attendance_ID INT AUTO_INCREMENT PRIMARY KEY,
    member_ID INT NOT NULL,
    attendance_date DATE,
    check_in_time TIME,
    check_out_time TIME, 
    FOREIGN KEY (member_ID) REFERENCES members(member_ID)
);

CREATE TABLE report (
    report_ID INT AUTO_INCREMENT PRIMARY KEY,
    report_type VARCHAR(50),
    generated_date DATE,
    staff_ID INT,
    FOREIGN KEY (staff_ID) REFERENCES staff(staff_ID)
);










INSERT INTO staff (staff_name, role, contact_info, hire_date)
VALUES
('John Doe', 'Manager', '09123456789', '2025-01-01');

INSERT INTO members (member_name, contact_info, membership_status)
VALUES
('Eryl Aspera', 'EAspera@up.edu.ph', 'active'),
('Christian Hernia', 'CHernia@up.edu.ph', 'active');

INSERT INTO membership (membership_type, price, duration)
VALUES
('monthly', 500.00, 30),
('weekly', 200.00, 7);

INSERT INTO subscribes (member_ID, membership_ID, purchase_date, start_date, end_date)
VALUES
(1, 1, '2025-05-01', '2025-05-01', '2025-05-07'),
(2, 2, '2025-05-10', '2025-05-10', '2025-06-09');

INSERT INTO payment (member_ID, staff_ID, membership_ID, amount, payment_date)
VALUES (1, 1, 1, 100.00, '2025-05-07');

INSERT INTO payment (member_ID, staff_ID, membership_ID, amount, payment_date, payment_type)
VALUES (2, 1, 2, 100.00, '2025-05-13', 'gcash');

INSERT INTO payment (member_ID, staff_ID, membership_ID, amount, payment_date, payment_type)
VALUES (1, 1, 1, 100.00, '2025-05-08', DEFAULT);

INSERT INTO attendance (member_ID, attendance_date, check_in_time, check_out_time)
VALUES
(1, '2025-05-07', '08:00:00', '10:00:00'),
(2, '2025-05-13', '09:00:00', '11:00:00');

INSERT INTO report (report_type, generated_date, staff_ID)
VALUES
('Monthly Revenue', '2025-05-31', 1),
('Weekly Attendance', '2025-05-07', 1),
('Daily Membership', '2025-05-07', 1),
('Daily Payment', '2025-05-07', 1),
('Daily Attendance', '2025-05-07', 1);
