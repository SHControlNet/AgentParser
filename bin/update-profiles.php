<?php

	include_once __DIR__ . '/bootstrap.php';
	
	echo "Downloading...";

	$profiles = json_decode(file_get_contents("https://raw.githubusercontent.com/SHControlNet/AgentParser/main/dev/profiles.json"));

	$total = count($profiles);

	$result  = "";
	$result .= "<?php\n";
	$result .= "\n";
	$result .= "/* This file is automatically generated, do not edit manually! */\n";
	$result .= "\n";
	$result .= "namespace AgentParser\\Data;\n";
	$result .= "\n";
	$result .= "use AgentParser\\Constants\\DeviceType;\n";
	$result .= "\n";
	$result .= "DeviceProfiles::\$PROFILES = [\n";

	foreach($profiles as $key => $profile) {
		$result .= "    '" . addslashes(trim($profile->url)) . "'" . str_repeat(" ", max(0, 100 - strlen($profile->url)));
		$result .= "=> [ " . deviceString($profile->deviceManufacturer) . ", " . deviceString($profile->deviceModel);
		$result .= ", " . deviceString($profile->osName) . ", " . deviceType($profile->deviceType) . " ],\n";
	}

	$result .= "];\n";

	echo " and writing {$total} profiles...\n";
	file_put_contents(__DIR__ . '/../data/profiles.php', $result);


	function deviceString($s) {
		if (is_null($s) || $s == '') {
			return 'null';
		}
		
		return "'" . addslashes(trim($s)) . "'";
	}
	
	function deviceType($type) {
		switch ($type) {
			case 'mobile':	return 'DeviceType::MOBILE';
			case 'tablet':	return 'DeviceType::TABLET';
		}
	}
