<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";
    class CalendarModel extends Database
    {

        public function getItems($str_date, $end_date, $course_)
        {

            return $this->select("SELECT * FROM calendar WHERE FIND_IN_SET(calendar_course_id, ?) > 0 AND calendar_date BETWEEN ? AND ?", ["sss", $course_, $str_date, $end_date]);

        }
    }