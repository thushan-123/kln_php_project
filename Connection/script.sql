CREATE TABLE users (user_id int(10) AUTO_INCREMENT NOT NULL,
                    user_name VARCHAR(20) NOT NULL,
                    email VARCHAR(30) NOT NULL,
                    password VARCHAR(20) NOT NULL, 
                    mobile INT(10) NOT NULL, 
                    gender TINYINT,
                    PRIMARY KEY (user_id));