<?php 

require_once __DIR__ . "/BaseDao.class.php";

class EnrollmentDao extends BaseDao {
    public function __construct() {
        parent::__construct('enrollments');
    }

    public function enroll($enrollment) {
        return $this->insert('enrollments', $enrollment);
    }

    public function unenroll($enrollment) {
        return $this->query("DELETE FROM enrollments WHERE student_id = :student_id AND course_id = :course_id", $enrollment);
    }

    public function check_enrollment($course_id, $student_id) {
        return $this->query_unique("SELECT COUNT(*) as enrolled FROM enrollments WHERE course_id = :course_id AND student_id = :student_id", ['course_id' => $course_id, 'student_id' => $student_id]);
    }

    public function get_students_by_course_id($course_id) {
        return $this->query("SELECT students.* FROM enrollments JOIN students ON enrollments.student_id = students.id WHERE enrollments.course_id = :course_id", ['course_id' => $course_id]);
        
    }
}