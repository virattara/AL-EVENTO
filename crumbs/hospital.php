<?php
//use define() to declair
//use try catch here
//use utf-8
class commands{
public $_command;

function query_ajax($_string)
{
	try 
	{
		$_thread = new PDO("mysql:host=localhost;dbname=republicOfAlevento","stackleaksdba","thandichai2014");									
	} 
	catch (Exception $e) 
	{
		header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json; charset=UTF-8');
        echo "Server Error";
		exit();		
	}
		$_command = $_thread->prepare($_string);
		$_command->execute();							
		$_result = $_command->fetchColumn();
		return $_result;
}

function query_fetch_ajax($_string)
{
	try 
	{
		$_thread = new PDO("mysql:host=localhost;dbname=republicOfAlevento","stackleaksdba","thandichai2014");									
	} 
	catch (Exception $e) 
	{
		header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json; charset=UTF-8');
        echo "Server Error";
		exit();		
	}
		$_command = $_thread->prepare($_string);
		$_command->execute();							
		$_result = $_command->fetchAll(PDO::FETCH_ASSOC);
		return $_result;
}

function query($_string)
{
	try {
		$_thread = new PDO("mysql:host=localhost;dbname=republicOfAlevento","stackleaksdba","thandichai2014");								
	} catch (Exception $e) {
		echo "Server Error";
	}


	$_command = $_thread->prepare($_string);
	$_command->execute();							
	$_result = $_command->fetchColumn();
	return $_result;
}

function query_fetch($_string)
{
	try {
		$_thread = new PDO("mysql:host=localhost;dbname=republicOfAlevento","stackleaksdba","thandichai2014");								
	} catch (Exception $e) {
		echo "Server Error";
	}
	$_command = $_thread->prepare($_string);
	$_command->execute();							
	$_result = $_command->fetchAll(PDO::FETCH_ASSOC);
	return $_result;
}

function query_id($_string)
{
	try {
		$_thread = new PDO("mysql:host=localhost;dbname=republicOfAlevento","stackleaksdba","thandichai2014");								
	} catch (Exception $e) {
		header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json; charset=UTF-8');
        echo "Server Error";
		exit();
	}
	$_command = $_thread->prepare($_string);
	$_command->execute();							
	$_result = $_thread->lastInsertId();
	return $_result;
}
}
?>