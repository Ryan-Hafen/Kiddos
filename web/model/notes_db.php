<?php
function get_notes() {
    global $db;
    $query = 'SELECT n.id, n.Note AS noteText, n.ScripturesID, s.Chapter, s.Verse
                   , s.BookID, b.Name AS bookName, b.VolumeID, b.Name AS volumeName
                   , u.UserEmail
                FROM notes as n 
                JOIN users as u on n.UsersId = u.id 
                JOIN scriptures as s on n.ScripturesID = s.id 
                JOIN books as b on s.BookID = b.id 
                JOIN volumes as v on b.VolumeID = v.id';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement;    
}

function get_note($note_id) {
    global $db;
    $query = 'SELECT n.id, ltrim(rtrim(n.Note)) AS noteText, n.ScripturesID, s.Chapter, s.Verse
                   , s.BookID, b.Name AS bookName, b.VolumeID, b.Name AS volumeName
                FROM notes as n 
                JOIN users as u on n.UsersId = u.id 
                JOIN scriptures as s on n.ScripturesID = s.id 
                JOIN books as b on s.BookID = b.id 
                JOIN volumes as v on b.VolumeID = v.id
               WHERE n.id = :note_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":note_id", $note_id);
    $statement->execute();
    $note = $statement->fetch();
    $statement->closeCursor();
    return $note;
}

function get_volume_list() {
    global $db;
    $query = 'SELECT id as volumeID, Name AS volumeName
                FROM volumes';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement;    
}

function get_book_list() {
    global $db;
    $query = 'SELECT ID AS bookID, Name AS bookName
                FROM books';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement; 
}

//function get_book_list($volume_id) {
//    global $db;
//    $query = 'SELECT b.ID AS bookID, b.Name AS bookName
//                FROM books as b
//                JOIN volumes as v on b.volumeID = v.id
//               WHERE v.id = :volume_id';
//    $statement = $db->prepare($query);
//    $statement->bindValue(":volume_id", $volume_id);
//    $statement->execute();
//    $books = $statement->fetchAll();
//    $statement->closeCursor();
//    return $books; 
//}

function get_chapter_list() {
    global $db;
    $query = 'SELECT distinct chapter
                FROM scriptures';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement; 
}

//function get_chapter_list($book_id) {
//    global $db;
//    $query = 'SELECT distinct s.chapter
//                FROM scriptures as s
//                JOIN books as b on s.bookID = b.id
//               WHERE b.id = :book_id';
//    $statement = $db->prepare($query);
//    $statement->bindValue(":book_id", $book_id);
//    $statement->execute();
//    $chapter = $statement->fetchAll();
//    $statement->closeCursor();
//    return $chapter; 
//}

function get_verse_list() {
    global $db;
    $query = 'SELECT Distinct verse
                FROM scriptures';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement; 
}

//function get_verse_list($book_id, $chapter_id) {
//    global $db;
//    $query = 'SELECT s.verse
//                FROM scriptures as s
//                JOIN books as b on s.bookID = b.id
//               WHERE b.id = :book_id
//                 AND s.chapter = :chapter';
//    $statement = $db->prepare($query);
//    $statement->bindValue(":book_id", $book_id);
//    $statement->bindValue(":chapter", $chapter_id);
//    $statement->execute();
//    $verse = $statement->fetchAll();
//    $statement->closeCursor();
//    return $verse; 
//}

function get_scripture_id($book_id, $chapter_id, $verse_id) {
    global $db;
    $query = 'SELECT s.id as scriptureID
                FROM scriptures as s
               WHERE s.bookID = :book_id
                 AND s.chapter = :chapter_id
                 AND s.verse = :verse_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":book_id", $book_id);
    $statement->bindValue(":chapter_id", $chapter_id);
    $statement->bindValue(":verse_id", $verse_id);
    $statement->execute();
    $scripture = $statement->fetch();
    $statement->closeCursor();
    $scripture_id = $scripture['scriptureID'];
    return $scripture_id; 
}


function delete_note($note_id) {
    global $db;
    $query = 'DELETE FROM notes
                WHERE ID = :note_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':note_id',$note_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_note($note_text, $book_id, $chapter_id, $verse_id) {
    global $db;
    $query = 'INSERT INTO notes(Note, ScripturesID, UsersID)
              VALUES(:note_text, (SELECT id 
                                    FROM scriptures 
                                   WHERE BookID = :book_id 
                                     AND chapter = :chapter_id 
                                     AND verse = :verse_id)
                    , 1)';
    $statement = $db->prepare($query);
    $statement->bindValue(':note_text', $note_text);
    $statement->bindValue(':book_id', $book_id);
    $statement->bindValue(':chapter_id', $chapter_id);
    $statement->bindValue(':verse_id', $verse_id);
    $statement->execute();
    $statement->closeCursor();
}

function edit_note($note_id, $book_id, $chapter_id, $verse_id, $note_text) {
    global $db;
    $query = 'Update notes as n
                 Set n.note = :note_text
                   , n.scripturesID = (SELECT id 
                                         FROM scriptures 
                                        WHERE BookID = :book_id
                                          AND Chapter = :chapter_id
                                          AND Verse = :verse_id)
               WHERE n.ID = :note_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':note_id', $note_id);
    $statement->bindValue(':book_id', $book_id);
    $statement->bindValue(':chapter_id', $chapter_id);
    $statement->bindValue(':verse_id', $verse_id);
    $statement->bindValue(':note_text', $note_text);
    $statement->execute();
    $statement->closeCursor();
}
?>