<div class="container">
    <div class="page-header">
        <h3>Author Notes</h3>
    </div>
    <?php /**
     * @type \Illuminate\Support\Collection $notes
     * @type \Note\Domain\Note $note
     */
        if($notes->isEmpty()):
    ?>
        <div class="alert alert-danger" role="alert">
            <strong>Oops</strong> This user does not have any note.
        </div>
    <?php
        else:
    ?>
    <div class="alert alert-warning" role="alert">
        <strong>Please</strong> select the note to edit.
    </div>

    <div class="form-group">
        <label>User</label>
        <input class="form-control"  type="text" value="<?= $notes->first()->getAuthor()->getUsername() ?>" readonly>
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control"  type="text" value="<?= $notes->first()->getAuthor()->getFullName() ?>" readonly>
    </div>

    <div class="page-header">
        <h4>Notes</h4>
    </div>
    <?php foreach($notes as $note):?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= $note->getTitle() ?>
                    <div class="btn-group btn-group-xs note-btn" role="group">
                        <a href="/update/<?= $note->getId() ?>" type="button" class="btn btn-warning">Update</a>
                        <a href="/delete/<?= $note->getId() ?>" type="button" class="btn btn-danger">Delete</a>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                <?= $note->getContent() ?>
            </div>
        </div>
    <?php
        endforeach;
        endif;
    ?>
</div><!-- /.container -->