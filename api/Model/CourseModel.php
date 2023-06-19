<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";
    class CourseModel extends Database
    {
        public function getInfo($id_)
        {
            
            $res_ = array();
            foreach ($id_ as $id){
                
                $res_[] = $this->select("SELECT * FROM courses WHERE course_active = 1 AND course_id = ?", ["i",$id]);
                
            } 
            return $res_;
        }
    }