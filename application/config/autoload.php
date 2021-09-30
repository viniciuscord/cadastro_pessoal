<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('user_agent','database');

$autoload['drivers'] = array("session");

$autoload['helper'] = array('url','login_helper','permissao_helper');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('Login_model');
