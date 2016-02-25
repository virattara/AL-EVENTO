create table notify(
notify_id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
sender_id INT,
suburb_id INT,
content TEXT,
FOREIGN KEY (user_id) REFERENCES community(user_id),
FOREIGN KEY (sender_id) REFERENCES community(user_id),
FOREIGN KEY (suburb_id) REFERENCES suburb(suburb_id),
time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

