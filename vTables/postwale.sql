CREATE TABLE senator(
user_id INT NOT NULL,
sticker_id INT NOT NULL,
block ENUM('true','false') DEFAULT 'true',	
FOREIGN KEY (user_id) REFERENCES community(user_id),
FOREIGN KEY (sticker_id) REFERENCES sticker(sticker_id)
);