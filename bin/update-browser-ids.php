<?php
include_once __DIR__ . '/bootstrap.php';
	
echo "Updating browser ids..\n";

$ids = json_decode(file_get_contents("https://raw.githubusercontent.com/SHControlNet/AgentParser/main/dev/browser-ids.json"));

$result  = "";
$result .= "<?php\n";
$result .= "\n";
$result .= "/* This file is automatically generated, do not edit manually! */\n";
$result .= "\n";
$result .= "namespace AgentParser\\Data;\n";
$result .= "\n";
$result .= "BrowserIds::\$ANDROID_BROWSERS = [\n";

foreach($ids as $key => $id) {
	$result .= "    '" . addslashes(trim($id->browserId)) . "'" . str_repeat(" ", max(0, 100 - strlen($id->browserId)));
	$result .= "=> " . deviceString($id->browserName) . ",\n";
}

$result .= "];\n";

file_put_contents(__DIR__ . '/../data/id-android.php', $result);

function deviceString($s) {
	if (is_null($s) || $s == '') {
		return 'null';
	}
		
	return "'" . addslashes(trim($s)) . "'";
}
