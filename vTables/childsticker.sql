Create TABLE childsticker(
childsticker_id INT AUTO_INCREMENT,
sticker_id INT NOT NULL,
name VARCHAR(255) NOT NULL,
description TEXT,
rank MEDIUMINT,
time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (childsticker_id),
FOREIGN KEY (sticker_id) REFERENCES sticker(sticker_id)
);