<?php 

require_once __DIR__ . '/../dao/ProfessorDao.class.php';


class ProfessorService {
    private $professor_dao;

    public function __construct() {
        $this->professor_dao = new ProfessorDao();
    }

    public function add_professor($professor) {
        $professor['password'] = password_hash($professor['password'], PASSWORD_BCRYPT);
        return $this->professor_dao->add_professor($professor);
    }

    public function get_professors_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $count = $this->professor_dao->count_professors_paginated($search)['count'];

        $rows =  $this->professor_dao->get_professors_paginated($offset, $limit, $search, $order_column, $order_direction);

        return [
            'count' => $count,
            'data' => $rows
        ];
    }

    public function delete_professor_by_id($id) {
        return $this->professor_dao->delete_professor_by_id($id);
    }

    public function get_professor_by_id($id) {
        return $this->professor_dao->get_professor_by_id($id);
    }

    public function edit_professor($professor) {
        $id = $professor['id'];
        unset($professor['id']);
        
        $this->professor_dao->edit_professor($id, $professor);
    }

    public function get_all_professors() {
        return $this->professor_dao->get_all_professors();
    }

    public function get_limited_professors($limit) {
        return $this->professor_dao->get_professors_paginated(0, $limit, '', 'id', 'ASC')['data'];
    }

    public function get_contact_info($first_name) {
        return $this->professor_dao->get_contact_info($first_name);
    }
}