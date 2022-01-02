<?php

namespace Space;

$consts = Star::MyStar()->GetConstellations();
$consts_count = Star::MyStar()->ConstellationsCount();

$default_start_index = 0;
$range = 5; //The number of contellations to present on each page
$start_index = (isset($_GET["start_index"])) ? $_GET["start_index"] : $default_start_index; //The index to start from

if ($start_index >= $consts_count)
    $start_index = 0; //Verify whether the star_index has surpassed the boundary
if ($range > $consts_count)
    $range = $consts_count; //Verify whether the range of constellations to present is greater than the available ones

$row = 0;
for ($row = $start_index; $row < ($start_index + $range); $row++) {
    if ($row < 0 || $row >= $consts_count)
        break; //Index out of range
    $constellation = new Constellation($consts[$row][0]);
    include("const_div.php");
 } ?>