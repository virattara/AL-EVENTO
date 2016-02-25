create table notified(
user_id INT NOT NULL,
notify_id INT NOT NULL,
FOREIGN KEY (user_id) REFERENCES community(user_id),
FOREIGN KEY (notify_id) REFERENCES notify(notify_id)
);