create table subscribe(
user_id INT NOT NULL,
sticker_id INT NOT NULL,
FOREIGN KEY (user_id) REFERENCES community(user_id),
FOREIGN KEY (sticker_id) REFERENCES sticker(sticker_id)
);