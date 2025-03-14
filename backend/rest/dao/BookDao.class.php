<?php 

require_once __DIR__ . "/BaseDao.class.php";

class BookDao extends BaseDao {
    public function __construct() {
        parent::__construct('books');
    }

    public function add_book($book) {
        return $this->insert('books', $book);
    }

    public function count_books_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM books
                  WHERE LOWER(title) LIKE CONCAT('%', :search, '%') OR
                        LOWER(genre) LIKE CONCAT('%', :search, '%') OR
                        LOWER(publication_year) LIKE CONCAT('%', :search, '%') OR
                        LOWER(content) LIKE CONCAT('%', :search, '%') OR
                        LOWER(author) LIKE CONCAT('%', :search, '%');";
        
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_books_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT * 
                  FROM books
                  WHERE LOWER(title) LIKE CONCAT('%', :search, '%') OR
                        LOWER(genre) LIKE CONCAT('%', :search, '%') OR
                        LOWER(publication_year) LIKE CONCAT('%', :search, '%') OR
                        LOWER(content) LIKE CONCAT('%', :search, '%') OR
                        LOWER(author) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function get_book_by_id($id) {
        return $this->query_unique("SELECT * FROM books WHERE id = :id", ['id' => $id]);
    }

    public function delete_book_by_id($id) {
        $query = "DELETE FROM books WHERE id = :id";
        $this->execute($query, ['id' => $id]);
    }

    public function edit_book($id, $book) {
        $query = "UPDATE books SET title = :title, genre = :genre, publication_year = :publication_year, content = :content, author = :author
                  WHERE id = :id";
        $this->execute($query, [
            'title' => $book['title'],
            'genre' => $book['genre'],
            'publication_year' => $book['publication_year'],
            'content' => $book['content'],
            'author' => $book['author'],
            'id' => $id
        ]);
    }

    public function get_all_books() {
        $query = "SELECT * FROM books";
        return  $this->query($query, []);
    }
    
}