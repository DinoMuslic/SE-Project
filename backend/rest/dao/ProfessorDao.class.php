<?php 

require_once __DIR__ . "/BaseDao.class.php";

class ProfessorDao extends BaseDao {
    public function __construct() {
        parent::__construct('professors');
    }

    public function add_professor($professor) {
        return $this->insert('professors', $professor);
    }

    public function count_professors_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM professors
                  WHERE LOWER(first_name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(last_name) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%') OR
                        LOWER(faculty) LIKE CONCAT('%', :search, '%') OR
                        LOWER(department) LIKE CONCAT('%', :search, '%') OR
                        LOWER(salary) LIKE CONCAT('%', :search, '%');";
        
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_professors_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT * 
                  FROM professors
                  WHERE LOWER(first_name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(last_name) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%') OR
                        LOWER(faculty) LIKE CONCAT('%', :search, '%') OR
                        LOWER(department) LIKE CONCAT('%', :search, '%') OR
                        LOWER(salary) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function get_professor_by_id($id) {
        return $this->query_unique("SELECT * FROM professors WHERE id = :id", ['id' => $id]);
    }

    public function delete_professor_by_id($id) {
        $query = "DELETE FROM professors WHERE id = :id";
        $this->execute($query, ['id' => $id]);
    }

    public function edit_professor($id, $professor) {
        $query = "UPDATE professors SET first_name = :first_name, last_name = :last_name, email = :email, isAdmin = :isAdmin, faculty = :faculty, department = :department, salary = :salary
                  WHERE id = :id";
        $this->execute($query, [
            'first_name' => $professor['first_name'],
            'last_name' => $professor['last_name'],
            'email' => $professor['email'],
            'faculty' => $professor['faculty'],
            'department' => $professor['department'],
            'salary' => $professor['salary'],
            'isAdmin' => $professor['isAdmin'],
            'id' => $id
        ]);
    }
    
    public function get_all_professors() {
        $query = "SELECT * FROM professors";
        return  $this->query($query, []);
    }

    public function get_contact_info($first_name) {
        $query = "SELECT email, faculty, department FROM professors WHERE first_name LIKE :first_name";
        return $this->query($query, ['first_name' => $first_name]);
    }
}