create table if not exists users (
  email_hash varchar(50),
  last_login timestamp,
  created_at timestamp,
  current_pincode varchar(10)
);

create table if not exists parameters (
  name varchar(100),
  value varchar(255)
);
 