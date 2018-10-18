<?php
require('../model/database.php');
require('../model/notes_db.php');
require('../model/scriptures_db.php');
require('../model/users_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_notes';
    }
}  

if ($action == 'list_notes') {
    $notes = get_notes();
    include('notes_list.php');
} else if ($action == 'edit_note_form') {
    $note_id = filter_input(INPUT_POST, 'note_id', FILTER_VALIDATE_INT);
    $book_id = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);
    $volume_id = filter_input(INPUT_POST, 'volume_id', FILTER_VALIDATE_INT);
    $chapter_id = filter_input(INPUT_POST, 'chapter', FILTER_VALIDATE_INT);
    $verse_id = filter_input(INPUT_POST, 'verse', FILTER_VALIDATE_INT);
    
    if ($note_id != false) {
        $note = get_note($note_id);
        $volumes = get_volume_list();
        $books = get_book_list();
        $chapters = get_chapter_list();
        $verses = get_verse_list();
        
        include('edit_note_form.php');
    }
} else if ($action == 'edit_note') {
    $note_id = filter_input(INPUT_POST, 'note_id', FILTER_VALIDATE_INT);
    $book_id = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);
    $volume_id = filter_input(INPUT_POST, 'volume_id', FILTER_VALIDATE_INT);
    $chapter_id = filter_input(INPUT_POST, 'chapter_id', FILTER_VALIDATE_INT);
    $verse_id = filter_input(INPUT_POST, 'verse_id', FILTER_VALIDATE_INT);
    $note_text = filter_input(INPUT_POST, 'note_text');
    
    if ($note_id == false || $book_id == false || $chapter_id == false || $verse_id == false || $note_text == "") {
        $error = 'All fields are required. note_id = ' .$note_id;
        include('../errors/error.php');
    } else {
        edit_note($note_id, $book_id, $chapter_id, $verse_id, $note_text);
        header("Location: .?note_id=$note_id");
        include('notes_list.php');
    }
} else if ($action == 'delete_note') {
    $note_id = filter_input(INPUT_POST, 'note_id', FILTER_VALIDATE_INT);
    if ($note_id == false) {
        $error = "Missing or incorrect product id or category id.";
        include('../errors/error.php');
    } else { 
        delete_note($note_id);
        header("Location: .?note_id=$note_id");
        include('notes_list.php');
    }
} else if ($action == 'add_note_form') {
    $volumes = get_volume_list();
    $books = get_book_list();
    $chapters = get_chapter_list();
    $verses = get_verse_list();
    include('add_note_form.php');
} else if ($action == 'add_note') {
    $note_text = filter_input(INPUT_POST, 'note_text');
    $book_id = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);
    $chapter_id = filter_input(INPUT_POST, 'chapter_id', FILTER_VALIDATE_INT);
    $verse_id = filter_input(INPUT_POST, 'verse_id', FILTER_VALIDATE_INT);
    if ($book_id == false) {
        $error = "Invalid product data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        add_note($note_text, $book_id, $chapter_id, $verse_id);
        header("Location: .?note_id=$note_id");
        include('notes_list.php');
    }
}
?>


