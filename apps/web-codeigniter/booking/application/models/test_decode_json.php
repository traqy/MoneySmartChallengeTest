<?php
$json_str = '{"register":{"status": "failed", "message": "btraquena@gmail.com is already registered."}}';

$jo = json_decode(trim($json_str),TRUE);
#var_dump(json_decode($json_str));
#var_dump(json_decode(trim($json_str),TRUE));
$status = $jo['register']['status'];
echo "status: $status ";
?>