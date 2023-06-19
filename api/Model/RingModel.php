<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";
    class RingModel extends Database
    {
        public function getRings()
        {
            return $this->select("SELECT * FROM ring WHERE ring_active = 1 ORDER BY ring_id ASC");
        }
    }