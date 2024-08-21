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

CREATE Table admin (admin_id INT(10) AUTO_INCREMENT,
                    admin_name VARCHAR(20) NOT NULL UNIQUE,
                    email VARCHAR(30) NOT NULL UNIQUE,
                    password VARCHAR(80) NOT NULL,
                    PRIMARY KEY (admin_id),
                    INDEX idx_admin_id(admin_id),
                    INDEX idx_email(email));

# email : thushanmadhusanka3@gmail.com   password: thushan2001
INSERT INTO admin (admin_name, email, password) VALUES ('thush','thushanmadhusanka3@gmail.com', '67215bebe2fe2737d90bb951347c6a0852a1f537');



CREATE Table supliers(suplier_id INT(10) AUTO_INCREMENT,
                      suplier_username VARCHAR(20) NOT NULL,
                      email VARCHAR(30) NOT NULL UNIQUE,
                      password VARCHAR(80) NOT NULL,
                      mobile INT(10) NOT NULL UNIQUE,
                      verify TINYINT DEFAULT false,
                      PRIMARY KEY (suplier_id),
                      INDEX idx_suplier_id(suplier_id),
                      INDEX idx_email(email));