<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";
    class UserModel extends Database
    {
        public function getUsers($limit)
        {
            return $this->select("SELECT * FROM user ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
        }

        public function getinfo($mail)
        {
            return $this->select("SELECT * FROM user WHERE user_mail = ?", ["s",$mail]);
        }

        public function insertUser($get_)
        {
            return $this->insert("INSERT INTO user (user_case, user_mail, user_name, user_pass, user_id_no, user_stu_no, user_fac_tr, user_fac_en, user_dep_tr, user_dep_en, user_course, user_hash, user_photo, user_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", ["ssssiisssssssi", $get_['case'], $get_['mail'], $get_['name'], $get_['pass'], $get_['id_no'], $get_['stu_no'], $get_['fac_tr'], $get_['fac_en'], $get_['dep_tr'], $get_['dep_en'], $get_['course'], $get_['hash'], $get_['photo'], $get_['active'],]);
        }
        
        public function isAuth($hash)
        {
            return $this->select("SELECT * FROM user WHERE user_hash = ?", ["s",$hash]);
        }

        public function getUser($id)
        {
            return $this->select("SELECT * FROM user WHERE user_id = ?", ["i",$id]);
        }

        public function changePass($id, $pass)
        {   
            return $this->update("UPDATE `user` SET `user_pass` = ? WHERE `user_id` = ?;",["si", $pass, $id]);
        }
    }