<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";
    class MealModel extends Database
    {
        public function getMeals($date)
        {
            return $this->select("SELECT * FROM meal WHERE meal_active = 1 AND meal_date >= ? ORDER BY meal_id ASC", ["s", $date]);
        }
    }