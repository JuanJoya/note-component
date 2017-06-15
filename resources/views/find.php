<div class="container">
    <div class="page-header">
        <h3>Find Note</h3>
    </div>
    <?php /**
     * @type \Illuminate\Support\Collection $authors
     * @type \Note\Domain\Author $author
     */
        if($authors->isEmpty()):
    ?>
        <div class="alert alert-danger" role="alert">
            <strong>Oops</strong> This user does not have any author.
        </div>
    <?php
        else:
    ?>
    <div class="alert alert-info" role="alert">
        <strong>Please</strong> select the author to find his notes.
    </div>
    <form action="/find" method="post">
        <div class="form-group">
            <label>User</label>
            <input class="form-control"  type="text" value="<?= $user->getFullName() ?>" readonly>
            <input hidden type="text" name="user_id" value="<?= $user->getId() ?>">
        </div>
        <div class="form-group">
            <label>Select Author</label>
            <select name="author_id" multiple class="form-control" required>
            <?php /**
             * @type \Illuminate\Support\Collection $authors
             * @type Note\Domain\Author $author
             */
                foreach($authors as $author):
            ?>
                    <option value="<?= $author->getAuthorId() ?>"><?= $author->getUsername() ?></option>
            <?php
                endforeach;
            ?>
            </select>
        </div>
        <button type="submit" class="btn btn-info btn-block">Find Notes</button>
    </form>
    <?php
        endif;
    ?>
</div><!-- /.container -->