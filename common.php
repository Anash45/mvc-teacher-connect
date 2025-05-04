<?php
session_start();

define('BASE_URL', '/david/p4/');

// Load core classes
require_once './core/Controller.php';
require_once './core/Database.php';
require_once './core/Model.php';

require './app/models/TutorModel.php';
require './app/models/StudentModel.php';
require './app/models/AdminModel.php';
// Load controllers
require_once './app/controllers/HomeController.php';
require_once './app/controllers/AuthController.php';
require_once './app/controllers/StudentController.php';
require_once './app/controllers/AdminController.php';
