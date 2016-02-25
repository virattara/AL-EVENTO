create table postrating(
user_id INT NOT NULL,
suburb_id INT NOT NULL,
rating MEDIUMINT,
FOREIGN KEY (user_id) REFERENCES community(user_id),
FOREIGN KEY (suburb_id) REFERENCES suburb(suburb_id)
);