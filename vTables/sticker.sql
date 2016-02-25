create table sticker(
sticker_id INT AUTO_INCREMENT,
stickername VARCHAR(255) NOT NULL,
user_id INT,
rank MEDIUMINT,
picture VARCHAR(400),
description TEXT,
PRIMARY KEY (sticker_id),
FOREIGN KEY (user_id) REFERENCES community(user_id)
);

INSERT INTO sticker(stickername) VALUES ('LitSoc');
INSERT INTO sticker(stickername) VALUES ('Frosh');
INSERT INTO sticker(stickername) VALUES ('Visual Bulletin');
INSERT INTO sticker(stickername) VALUES ('Enactus');
INSERT INTO sticker(stickername) VALUES ('Mudra');
INSERT INTO sticker(stickername) VALUES ('IETE');
INSERT INTO sticker(stickername) VALUES ('SSA');
INSERT INTO sticker(stickername) VALUES ('FAPS');
INSERT INTO sticker(stickername) VALUES ('AIESEC');
INSERT INTO sticker(stickername) VALUES ('Linux');