CREATE TABLE users (user_id int(10) AUTO_INCREMENT NOT NULL,
                    user_name VARCHAR(20) NOT NULL,
                    email VARCHAR(30) NOT NULL UNIQUE,
                    password VARCHAR(80) NOT NULL, 
                    mobile INT(10) NOT NULL UNIQUE, 
                    gender TINYINT,
                    PRIMARY KEY (user_id));

CREATE Table admin (admin_id INT(10) AUTO_INCREMENT,
                    admin_name VARCHAR(20) NOT NULL UNIQUE,
                    email VARCHAR(20) NOT NULL UNIQUE,
                    password VARCHAR(80) NOT NULL,
                    PRIMARY KEY (admin_id));

INSERT INTO admin (admin_name, email, password) VALUES ('thush','thushanmadhusanka3@gmail.com', 'thushan2001');


CREATE Table supliers(suplier_id INT(10) AUTO_INCREMENT,
                      suplier_username VARCHAR(20) NOT NULL,
                      email VARCHAR(20) NOT NULL UNIQUE,
                      password VARCHAR(80) NOT NULL,
                      mobile INT(10) NOT NULL UNIQUE,
                      verify TINYINT,
                      PRIMARY KEY (suplier_id),
                      INDEX idx_suplier_id(suplier_id),
                      INDEX idx_email(email));