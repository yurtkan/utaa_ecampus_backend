<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";
    class NoticeModel extends Database
    {
        public function getNotice($case, $limit)
        {
            return $this->select("SELECT * FROM notice WHERE notice_active = 1 AND notice_case = ? ORDER BY notice_on_date DESC LIMIT ?", ["si", $case, $limit]);
        }
    }