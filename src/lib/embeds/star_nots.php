<?php
namespace Space;

if ($notifications_count > 0) {

    if ($nots_start_index > $notifications_count - 1)
        $nots_start_index = 0; //Verify whether the star_index has surpassed the boundary, if so reset it
    if ($nots_range > $notifications_count)
        $nots_range = $notifications_count; //Verify whether the range of notifications to present is greater than the available ones

    $nots_row = 0; //Current row of the notifications
    for ($nots_row = $nots_start_index; $nots_row < ($nots_start_index + $nots_range); $nots_row++) {

        if ($nots_row < 0 || $nots_row >= $notifications_count)
            break; //Out of the valid indexes
        $notification = new Notification($notifications[$nots_row]["id"]);
       
        include("notification_div.php");
 
  }
}
