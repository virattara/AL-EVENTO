create table community(
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	email_id VARCHAR(400) NOT NULL,
	type ENUM('leader','senator','public') DEFAULT 'public',
	status ENUM('active','inactive') DEFAULT 'active',
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);