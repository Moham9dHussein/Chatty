-- Chatty database schema.
-- The original 2021 schema file was never committed, so this was rebuilt in 2026 from the PHP code.
-- Note: main.php reads the first column of accounts ($row[0]) as the online flag, so status comes first.
-- The demo users and messages are invented (password: demo123), the same ones used in the screenshots.

CREATE DATABASE IF NOT EXISTS whatsapp_users;
USE whatsapp_users;
CREATE TABLE accounts (
  status TINYINT NOT NULL DEFAULT 0,
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(50), last_name VARCHAR(50), phone VARCHAR(20)
);
CREATE TABLE chat (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_username VARCHAR(50) NOT NULL,
  receiver_username VARCHAR(50) NOT NULL,
  message_body TEXT NOT NULL,
  date_of_sending TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO accounts (status, username, password, first_name, last_name, phone) VALUES
 (0,'mohamed','demo123','Mohamed','Hussein','01000000001'),
 (1,'sara','demo123','Sara','Adel','01000000002'),
 (0,'omar','demo123','Omar','Khaled','01000000003'),
 (1,'youssef','demo123','Youssef','Samir','01000000004'),
 (0,'lina','demo123','Lina','Fathy','01000000005');
INSERT INTO chat (sender_username, receiver_username, message_body, date_of_sending) VALUES
 ('sara','mohamed','Hi Mohamed! Did you push the login page yet?','2021-03-10 18:02:11'),
 ('mohamed','sara','Yes, login and sign up are both working now','2021-03-10 18:03:40'),
 ('mohamed','sara','Messages are saved in MySQL and loaded with AJAX','2021-03-10 18:04:05'),
 ('sara','mohamed','Nice. Can we search for users by name?','2021-03-10 18:05:22'),
 ('mohamed','sara','Start typing in the search bar, it suggests usernames as you type','2021-03-10 18:06:10'),
 ('sara','mohamed','Perfect, let us show it to the doctor tomorrow','2021-03-10 18:07:31'),
 ('omar','mohamed','Are you coming to the lab on Thursday?','2021-03-09 11:15:00'),
 ('mohamed','omar','Yes, I will be there at 10','2021-03-09 11:20:00'),
 ('youssef','mohamed','Send me the database script when you can','2021-03-08 21:40:00'),
 ('mohamed','lina','Thanks for testing the sign up form!','2021-03-07 16:00:00');
