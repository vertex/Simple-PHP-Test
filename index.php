<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

require_once 'lib/limonade/limonade.php';

function before()
{
	set('errors', array()); // define errors 
	layout('layouts/default.html.php');
}
dispatch('/', 'form');
function form(){
	// set default form values
	set('post', array('name'=>'', 'date'=>'', 'newsletter'=>'1'));
	return html('index.html.php');
}
dispatch_post('/', 'form_post');
function form_post(){
	//validation
	$errors = array();
	$date = strtotime($_POST['date']);
	// check for checkbox hack
	if( ! in_array($_POST['newsletter'], array('1','0')) ) 
		halt('Error submitting form: Invalid value for checkbox'); 	
	// check for valid date
	// date criteria:  date is less then now, but greater then 150 years ago
	if( $date == false || $date > strtotime('now') || $date < strtotime('-150 years')) array_push($errors, 'date'); 
	// check for valid name
	// name criteria: not empty, name is less then 50 characters
	if(empty($_POST['name']) == true || strlen($_POST['name']) > 50) array_push($errors, 'name'); // check name empty or > 50 characters
	set('errors', $errors); # passing the errors to the view
	
	// use prepared statement for sql
	if(count($errors) <= 0) {
		$sql = sprintf ('INSERT INTO `entries` (`name`, `date`,`newsletter`) VALUES(\'%s\',\'%s\', \'%b\');', 
			$_POST['name'], 
			$_POST['date'], 
			$_POST['newsletter']
		);
		$link = mysql_connect('localhost', 'user', 'password');
		if($link == false)
			halt('SQL Error: ' . mysql_error()); // throw error on connection failure
		mysql_select_db('database');
		if( ! mysql_query($sql) )
			halt('SQL Error: ' . mysql_error()); // throw error on insertion failure
	}
	set('post', $_POST); # passing the post variables to the view
	return html('index.html.php');
}
run();