create database ajaxregister;
use ajaxregister;
create table userlist (username varchar(32) not null primary key,
					   password varchar(32) not null,
					   email varchar(60) not null) engine = InnoDB default charset=utf8;

grant select, insert, update, delete on ajaxregister.* to 'liuliwei';