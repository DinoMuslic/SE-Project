<?php
require_once __DIR__ . '/../services/EnrollmentService.class.php';

Flight::set('enrollment_service', new EnrollmentService());

Flight::group('/enrollments', function () {

    Flight::route('POST /enroll', function() {
        $payload = Flight::request()->data->getData();
    
        $enrollment = Flight::get('enrollment_service')->enroll($payload);
        
    
        Flight::json(['message' => "You have succesfully enrolled a student", 'data' => $enrollment]);
    });

    Flight::route('POST /unenroll', function() {
        $payload = Flight::request()->data->getData();
    
        $enrollment = Flight::get('enrollment_service')->unenroll($payload);
        
    
        Flight::json(['message' => "You have succesfully unenrolled a student", 'data' => $enrollment]);
    });

    Flight::route('GET /check', function() {
        $course_id = Flight::request()->query['course_id'];
        $student_id = Flight::request()->query['student_id'];
    
        $enrollment = Flight::get('enrollment_service')->check_enrollment($course_id, $student_id);
    
        Flight::json($enrollment, 200);
    });

    Flight::route('GET /@course_id', function($course_id) {
        $student = Flight::get('enrollment_service') -> get_students_by_course_id($course_id);
    
        Flight::json($student, 200);
    });
});

