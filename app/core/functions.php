<?php

use JetBrains\PhpStorm\NoReturn;

const DBUSER = "root";
const DBPASS= "";
const DBNAME = "blog_php";
const DBHOST = "localhost";

function run_query(string $query,array $data=[]): bool|array
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

function old_select($key, $value, $default = ''): string
{
    if(!empty($_POST[$key]) && $_POST[$key] == $value)
        return " selected ";

    if($default == $value)
        return " selected ";

    return "";
}



function run_query_row(string $query,array $data=[])
{
    $stringconnection = "mysql:hostname=localhost;dbname=".DBNAME;
    $con = new PDO($stringconnection, DBUSER, DBPASS);

    $stm = $con->prepare($query);
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if (is_array($result) && !empty($result)){
        return $result[0];
    }

    return false;
}


#[NoReturn] function redirect($page, $statusCode = 303): void
{
    header('Location: ' . $page);
    die();
}

function old_value($key, $default = '') {
    if(!empty($_POST[$key]))
        return $_POST[$key];

    return $default;
}

function esc($str): string
{
    return htmlspecialchars($str?? '');
}

function authenticate($row): void
{
    $_SESSION["user"] = $row;
}

function logged_in(): bool
{
    if(!empty($_SESSION['user'])){
        return true;
    }
    return false;
}


function get_pagination_vars()
{

    /** set pagination vars **/
    $page_number = $_GET['page'] ?? 1;
    $page_number = empty($page_number) ? 1 : (int)$page_number;
    $page_number = $page_number < 1 ? 1 : $page_number;

    $current_link = $_GET['url'] ?? 'home';
    $current_link = ROOT . "/" . $current_link;
    $query_string = "";

    foreach ($_GET as $key => $value)
    {
        if($key != 'url')
            $query_string .= "&".$key."=".$value;
    }

    if(!str_contains($query_string, "page="))
    {
        $query_string .= "&page=".$page_number;
    }

    $query_string = trim($query_string,"&");
    $current_link .= "?".$query_string;

    $current_link = preg_replace("/page=.*/", "page=".$page_number, $current_link);
    $next_link = preg_replace("/page=.*/", "page=".($page_number+1), $current_link);
    $first_link = preg_replace("/page=.*/", "page=1", $current_link);
    $prev_page_number = $page_number < 2 ? 1 : $page_number - 1;
    $prev_link = preg_replace("/page=.*/", "page=".$prev_page_number, $current_link);

    $result = [
        'current_link'	=>$current_link,
        'next_link'		=>$next_link,
        'prev_link'		=>$prev_link,
        'first_link'	=>$first_link,
        'page_number'	=>$page_number,
    ];

    return $result;
}



function get_image($file): string
{
$file = $file ?? '';
	if(file_exists($file))
    {
        return ROOT.'/'.$file;
    }

	return ROOT.'/assets/images/no_image.jpg';
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
        password VARCHAR(1024) not null,
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
         FOREIGN KEY (category_id) REFERENCES categories (id),
         FOREIGN KEY (user_id) REFERENCES users (id)
		

)";
    $stm = $con->prepare($query);
    $stm->execute();
}

function str_to_url($url): array|string|null
{

    $url = str_replace("'", "", $url);
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);

    return $url;
}



function user($key = '')
{
    if(empty($key))
        return $_SESSION['user'];

    if(!empty($_SESSION['user'][$key]))
        return $_SESSION['user'][$key];

    return '';
}



create_tables();