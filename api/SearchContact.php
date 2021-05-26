<?php
	require_once 'DBH.php';
	require_once 'functions.php';

	$ID = $inData["ID"];
	$ContactID = $inData["ContactID"];
	$FirstName = $inData["FirstName"];
	$LastName = $inData["LastName"];
	$StreetAddress = $inData["StreetAddress"];
	$City = $inData["City"];
	$State = $inData["State"];
	$ZipCode = $inData["ZipCode"];
	$PhoneNumber = $inData["PhoneNumber"];
	$Email = $inData["Email"];

	$conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT FirstName,LastName,StreetAddress,City,State,ZipCode,PhoneNumber,Email FROM Contacts WHERE ID=? AND ContactID=?");
		$stmt->bind_param("ii", $ID, $ContactID);
		$stmt->execute();
		$result = $stmt->get_result();

		$query = "SELECT FirstName,LastName,StreetAddress,City,State,ZipCode,PhoneNumber,Email FROM Contacts WHERE ID=? AND ContactID=?";

		if(isset($FirstName)){
			$query .= " AND FirstName LIKE '%$FirstName%'";
		}

		if(isset($LastName)){
			$query .= " AND LastName LIKE '%$LastName%'";
		}

		if(isset($StreetAddress)){
			$query .= " AND StreetAddress LIKE '%$StreetAddress%'";
		}

		if(isset($City)){
			$query .= " AND City LIKE '%$City%'";
		}

		if(isset($State)){
			$query .= " AND State LIKE '%$State%'";
		}

		if(isset($ZipCode)){
			$query .= " AND ZipCode LIKE '%$ZipCode%'";
		}

		if(isset($PhoneNumber)){
			$query .= " AND PhoneNumber LIKE '%$PhoneNumber%'";
		}

		if(isset($Email)){
			$query .= " AND Email LIKE '%$Email%'";
		}

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo($row['FirstName'],$row['LastName'],$row['StreetAddress'],$row['City'],$row['State'],$row['ZipCode'],$row['PhoneNumber'],$row['Email'],);
		}

		else
		{
			returnWithError("No Records Found");
		}

		$stmt->close();
		$conn->close();
	}

	function returnWithInfo($FirstName,$LastName,$StreetAddress,$City,$State,$ZipCode,$PhoneNumber,$Email)
	{
		$retValue = '{"FirstName":"'.$FirstName.'","LastName":"'.$LastName.'","StreetAddress":"'.$StreetAddress.'","City":"'.$City.'","State":"'.$State.'","ZipCode":"'.$ZipCode.'","PhoneNumber":"'.$PhoneNumber.'","Email":"'.$Email.'","error":""}';
		sendResultInfoAsJson( $retValue );
	}