drop database if exists room;
create database if not exists room;
use room;

create table if not exists users(
	id int not null primary key auto_increment,
	username varchar(50) unique not null,
	email varchar(70) unique not null,
	password varchar(100) not null,
	email_verified integer(1) default 1
);

create table if not exists rooms(
	id int not null primary key auto_increment,
	name varchar(50) not null,
	using_harman_speakers integer(1) default 0,
	enter_code varchar(10),

	user_id integer,
	foreign key(user_id) references users(id) on delete cascade
);

create table if not exists users_in_room(
	id int not null primary key auto_increment,
	user_id integer not null,
	room_id integer not null,

	foreign key(user_id) references users(id) on delete cascade,
	foreign key(room_id) references rooms(id) on delete cascade
);
create table if not exists songs(
	id int not null primary key auto_increment,
	name varchar(80) not null,
	author varchar(80) default "unavailable",
	url varchar(150) not null,
	thumbnail_url varchar(150),

	room_id integer not null,
	user_id integer not null,

	foreign key(user_id) references users(id) on delete cascade,
	foreign key(room_id) references rooms(id) on delete cascade
);

create table if not exists votes(
	id int not null primary key auto_increment,
	room_id integer not null,
	user_id integer not null,
	foreign key(user_id) references users(id) on delete cascade,
	foreign key(room_id) references rooms(id) on delete cascade
);
