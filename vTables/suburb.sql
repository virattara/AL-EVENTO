create table suburb(
suburb_id INT AUTO_INCREMENT,
user_id INT NOT NULL,
sticker_id INT NOT NULL,
childsticker_id INT,
content LONGTEXT,
picture VARCHAR(400),
rank MEDIUMINT,
PRIMARY KEY (suburb_id),
FOREIGN KEY (user_id) REFERENCES community(user_id),
FOREIGN KEY (sticker_id) REFERENCES sticker(sticker_id),
FOREIGN KEY (childsticker_id) REFERENCES childsticker(childsticker_id),
time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);