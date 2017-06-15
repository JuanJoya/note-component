<div class="container">
    <div class="page-header">
        <h3>Update a Note</h3>
    </div>
    <?php /**@type Note\Domain\Note $note**/
        if(empty($note)):
    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Oops</strong> hasn't been found any note with this ID.
    </div>
    <?php
        else:
    ?>
    <div class="alert alert-warning" role="alert">
        <strong>Please</strong> update the form below.
    </div>

    <form action="/update" method="post">
        <div class="form-group">
            <label>Note Title</label>
            <input type="text" name="title" class="form-control" value="<?= $note->getTitle() ?>" placeholder="Title" required>
        </div>
        <div class="form-group">
            <label>Note Content</label>
            <textarea class="form-control" name="content" maxlength="100"  placeholder="content" required><?= $note->getContent() ?></textarea>
        </div>
        <div class="form-group">
            <label>User</label>
            <input class="form-control"  type="text" value="<?= $note->getAuthor()->getFullName() ?>" readonly>
            <input hidden type="text" name="id" value="<?= $note->getId() ?>">
        </div>
        <div class="form-group">
            <label>Author</label>
            <input class="form-control"  type="text" value="<?= $note->getAuthor()->getUsername() ?>" readonly>
        </div>
        <button type="submit" class="btn btn-danger btn-block">Save</button>
    </form>
    <?php
        endif;
    ?>
</div><!-- /.container -->