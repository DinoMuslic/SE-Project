<?php 

require_once __DIR__ . "/BaseDao.class.php";

class CourseDao extends BaseDao {
    public function __construct() {
        parent::__construct('courses');
    }

    public function add_course($course) {
        return $this->insert('courses', $course);
    }

    public function count_courses_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM courses
                  WHERE LOWER(title) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(department) LIKE CONCAT('%', :search, '%') OR
                        LOWER(professor) LIKE CONCAT('%', :search, '%') OR
                        LOWER(faculty) LIKE CONCAT('%', :search, '%');";
        
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_courses_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT * 
                  FROM courses
                  WHERE LOWER(title) LIKE CONCAT('%', :search, '%') OR
                        LOWER(department) LIKE CONCAT('%', :search, '%') OR
                        LOWER(image) LIKE CONCAT('%', :search, '%') OR
                        LOWER(professor) LIKE CONCAT('%', :search, '%') OR
                        LOWER(faculty) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function get_course_by_id($id) {
        return $this->query_unique("SELECT * FROM courses WHERE id = :id", ['id' => $id]);
    }

    public function delete_course_by_id($id) {
        $query = "DELETE FROM courses WHERE id = :id";
        $this->execute($query, ['id' => $id]);
    }

    public function edit_course($id, $course) {
        $query = "UPDATE courses SET title = :title, faculty = :faculty, department = :department, professor = :professor, image = :image
                  WHERE id = :id";
        $this->execute($query, [
            'title' => $course['title'],
            'faculty' => $course['faculty'],
            'department' => $course['department'],
            'professor' => $course['professor'],
            'image' => $course['image'],
            'id' => $id
        ]);
    }
    
    public function get_all_courses() {
        $query = "SELECT * FROM courses";
        return  $this->query($query, []);
    }
}