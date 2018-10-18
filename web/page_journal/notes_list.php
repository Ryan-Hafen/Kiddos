<?php include '../view/header.php'; ?>
<main>
<!--    <aside>
        <?php include '../view/categories_nav.php'; ?>
    </aside>-->
    
    <section>
        <p><a href="?action=add_note_form">Add Note</a></p>     
        <table>
            <tr>
                <th>Volume</th>
                <th>Book</th>
                <th>Chapter</th>
                <th>Verse</th>
                <th>Email</th>
                <th>Note</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php foreach ($notes as $note) : ?>
            <tr>
                <td><?php echo $note['volumeName']; ?></td>
                <td><?php echo $note['bookName']; ?></td>
                <td><?php echo $note['Chapter']; ?></td>
                <td><?php echo $note['Verse']; ?></td>
                <td><?php echo $note['UserEmail']; ?></td>
                <td><?php echo $note['noteText']; ?></td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="edit_note_form">
                    <input type="hidden" name="note_id"
                           value="<?php echo $note['id']; ?>">
                    <input type="hidden" name="book_id"
                           value="<?php echo $note['BookID']; ?>">
                    <input type="hidden" name="volume_id"
                           value="<?php echo $note['VolumeID']; ?>">
                    <input type="hidden" name="chapter"
                           value="<?php echo $note['Chapter']; ?>">
                    <input type="hidden" name="verse"
                           value="<?php echo $note['Verse']; ?>">
                    <input type="submit" value="Edit">
                </form></td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="delete_note">
                    <input type="hidden" name="note_id"
                           value="<?php echo $note['id']; ?>">
                    <input type="submit" value="Delete">
                </form></td>
            </tr>
            <?php endforeach; ?>
        </table> 
    </section>
</main>
<?php include '../view/footer.php'; ?>