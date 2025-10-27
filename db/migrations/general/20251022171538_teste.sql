 CREATE TABLE testegeneral (
    email_hash VARCHAR(255) NOT NULL, 
    last_login TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    password_hash VARCHAR(255) NOT NULL
   
);


 