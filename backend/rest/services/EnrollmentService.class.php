<?php 

require_once __DIR__ . '/../dao/EnrollmentDao.class.php';


class EnrollmentService {
    private $enrollment_dao;

    public function __construct() {
        $this->enrollment_dao = new EnrollmentDao();
    }

    public function enroll($entity) {
        return $this->enrollment_dao->enroll($entity);
    }
    
    public function unenroll($entity) {
        return $this->enrollment_dao->unenroll($entity);
    }

    public function check_enrollment($course_id, $student_id) {
        return $this->enrollment_dao->check_enrollment($course_id, $student_id);
    }

    public function get_students_by_course_id($id) {
        return $this->enrollment_dao->get_students_by_course_id($id);
    }
}