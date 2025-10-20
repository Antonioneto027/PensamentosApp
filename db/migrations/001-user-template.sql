CREATE TABLE IF NOT EXISTS schema_migrations (
    version VARCHAR(255) PRIMARY KEY,
    applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table if not exists emotions_log (
  cause VARCHAR(255) NOT NULL,
  emotion VARCHAR(255) NOT NULL,
  intensity INT(10) NOT NULL,
  thought1 VARCHAR(255) NOT NULL,
  thought2 VARCHAR(255) NOT NULL,
  thought3 VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL  
);
