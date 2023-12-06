CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(255) UNIQUE NOT NULL,
  balance INT NOT NULL DEFAULT 100,
  coins INT NOT NULL DEFAULT 0
);
