create database snsdb;

grant all on snsdb.* to dbuser@localhost identified by '*******';

use snsdb

create table users (
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

desc users;
