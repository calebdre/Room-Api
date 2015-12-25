<?php

if(getenv("APPLICATION_ENV") == "test"){
	return [
		"driver" => "mysql",
		"host" => "localhost",
		"database" => "room",
		"username" => "root",
		"password" => "",
		"charset" => "utf8",
		"collation" => "utf8_unicode_ci",
		"prefix" => ""
	];
}else if(getenv("APPLICATION_ENV") == "production"){
	return [
		"driver"=>"mysql",
		"host" => "localhost",
		"database" => "room",
		"username" => "root",
		"password" => "state2018pass!$",
		"charset" => "utf8",
		"collation" => "utf8_unicode_ci",
		"prefix" => ""
	];
}
