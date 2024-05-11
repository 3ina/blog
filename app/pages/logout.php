<?php
if(!empty($_SESSION['user'])){
    unset($_SESSION['user']);
}
redirect('home');