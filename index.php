<?php
include_once './Kernel/Kernel.php';
$_startTime = date("Y-m-d H:i:s");
Kernel::work();
$_endTime = date("Y-m-d H:i:s");
