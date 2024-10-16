USE kln_php;

CREATE TABLE users (user_id int(10) AUTO_INCREMENT NOT NULL,
                    user_name VARCHAR(20) NOT NULL,
                    email VARCHAR(30) NOT NULL UNIQUE,
                    password VARCHAR(80) NOT NULL, 
                    mobile INT(10) NOT NULL UNIQUE, 
                    gender TINYINT,
                    PRIMARY KEY (user_id),
                    INDEX idx_user_id(user_id),
                    Index idx_email(email),
                    Index idx_user_name(user_name));

CREATE TABLE admin (admin_id INT(10) AUTO_INCREMENT,
                    admin_name VARCHAR(20) NOT NULL UNIQUE,
                    email VARCHAR(30) NOT NULL UNIQUE,
                    password VARCHAR(80) NOT NULL,
                    PRIMARY KEY (admin_id),
                    INDEX idx_admin_id(admin_id),
                    INDEX idx_email(email));

# email : thushanmadhusanka3@gmail.com   password: thushan2001
INSERT INTO admin (admin_name, email, password) VALUES ('thush','thushanmadhusanka3@gmail.com', '67215bebe2fe2737d90bb951347c6a0852a1f537');



CREATE TABLE supliers(suplier_id INT(10) AUTO_INCREMENT,
                      suplier_username VARCHAR(20) NOT NULL,
                      email VARCHAR(30) NOT NULL UNIQUE,
                      password VARCHAR(80) NOT NULL,
                      mobile INT(10) NOT NULL UNIQUE,
                      verify TINYINT DEFAULT false,
                      PRIMARY KEY (suplier_id),
                      INDEX idx_suplier_id(suplier_id),
                      INDEX idx_email(email));

CREATE TABLE categories(category_id INT(5) AUTO_INCREMENT,
                              category_name VARCHAR(20) NOT NULL,
                              PRIMARY KEY (category_id));

CREATE TABLE flowers(flower_id VARCHAR(100),
                     flower_name VARCHAR(20),
                     quantity INT(5),
                     sale_price INT(5),
                     description VARCHAR(255),
                     other_info JSON,
                     PRIMARY KEY (flower_id),
                     INDEX idx_flower_name(flower_name));

CREATE TABLE flower_categories (flower_id VARCHAR(100),
                                category_id INT(5),
                                PRIMARY KEY (flower_id, category_id),
                                FOREIGN KEY (flower_id) REFERENCES flowers(flower_id) ON DELETE CASCADE,
                                FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE);


CREATE TABLE flower_images(flower_id VARCHAR(100),
                            dir_path TEXT,
                            FOREIGN KEY (flower_id) REFERENCES flowers(flower_id) ON DELETE CASCADE
                            INDEX idx_flower_id(flower_id));


CREATE TABLE flower_discounts(flower_id VARCHAR(100) UNIQUE,
                            today_dicount INT(3),
                            today_dicount_applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            loyalty_discount INT(3),
                            layalty_discount_applied_at DEFAULT CURRENT_TIMESTAMP,
                            price_off INT(5),
                            price_off_applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            Foreign Key (flower_id) REFERENCES flowers(flower_id) ON DELETE CASCADE,
                            INDEX idx_flower_id(flower_id));

SET GLOBAL event_scheduler = ON;

CREATE EVENT IF NOT EXISTS reset_today_discount
ON SCHEDULE EVERY 1 DAY
DO
   UPDATE flowers_prices 
   SET today_discount = NULL
   WHERE today_discount IS NOT NULL;


CREATE EVENT IF NOT EXISTS reset_today_discount
ON SCHEDULE AT '2024-11-10 00:00:00'
DO
   UPDATE flowers_prices 
   SET today_discount = NULL
   WHERE today_discount IS NOT NULL;


CREATE EVENT IF NOT EXISTS reset_today_discount
ON SCHEDULE EVERY 1 HOUR
STARTS '2024-11-10 00:00:00'
DO
   UPDATE flowers_prices 
   SET today_discount = NULL
   WHERE today_discount IS NOT NULL;








