CREATE TABLE app (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    authorization TEXT NOT NULL,
    date_add DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_expiration DATETIME NOT NULL
);

INSERT INTO app (name, authorization, date_add, date_expiration) VALUES ('Conecta Lá', SHA2('conecta_la', 256), '2025-02-08 09:00:00', DATE_ADD('2025-02-08 09:00:00', INTERVAL 1 YEAR));

-- authorization => c9b9b5cde36aa3b2f72b0dfe19412f1bdd37b18f06b2539bc875d08525e0b82b


CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_app INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    user VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    pass TEXT NOT NULL,
    date_add DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_edit DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_app) REFERENCES app(id) ON DELETE CASCADE
);