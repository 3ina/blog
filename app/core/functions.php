<?php

const DBUSER = "root";
const DBPASS= "Sin@2011";
const DBNAME = "blog_php";
const DBHOST = "localhost";

function run_query(string $query,array $data=[])
{
    $stringconnection = "mysql:hostname=localhost;dbname=".DBNAME;
    $con = new PDO($stringconnection, DBUSER, DBPASS);

    $stm = $con->prepare($query);
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if (is_array($result) && !empty($result)){
        return $result;
    }

    return false;
}

function create_tables(): void
{
    $stringconnection = "mysql:hostname=localhost;";
    $con = new PDO($stringconnection,DBUSER,DBPASS);

    $query = "use ".DBNAME;
    $stm = $con->prepare($query);
    $stm->execute();


    $query = "create table if not exists users(
        id INT primary key auto_increment,
        username VARCHAR(50) not null,
        email VARCHAR(100) not null,
        image VARCHAR(1024),
        date DATETIME default current_timestamp,
        role VARCHAR(10) not null,
        
        key email (email),
        key username (username)
)";
    $stm = $con->prepare($query);
    $stm->execute();


    $query = "create table if not exists categories(
        id INT primary key auto_increment,
        category VARCHAR(50) not null,
        slug VARCHAR(100) not null,
        disabled TINYINT default 0,
        
        key slug (slug),
        key category (category)
)";
    $stm = $con->prepare($query);
    $stm->execute();



    $query = "create table if not exists posts(

		id int primary key auto_increment,
		user_id int,
		category_id int,
		title varchar(100) not null,
		content text null,
		image varchar(1024) null,
		date datetime default current_timestamp,
		slug varchar(100) not null,

		key user_id (user_id),
		key category_id (category_id),
		key title (title),
		key slug (slug),
		key date (date)

)";
    $stm = $con->prepare($query);
    $stm->execute();
}


//create_tables();