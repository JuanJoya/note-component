<div class="container">
    <div class="page-header">
        <h3>Create Note</h3>
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
    <div class="alert alert-success" role="alert">
        <strong>Please</strong> complete the form below.
    </div>
    <form action="/create" method="post">
        <div class="form-group">
            <label>Note Title</label>
            <input type="text" name="title" class="form-control" placeholder="Title" required>
        </div>
        <div class="form-group">
            <label>Note Content</label>
            <textarea class="form-control" name="content" maxlength="100" placeholder="content" required></textarea>
        </div>
        <div class="form-group">
            <label>User</label>
            <input class="form-control"  type="text" value="<?= $user->getFullName() ?>" readonly>
            <input hidden type="text" name="user_id" value="<?= $user->getId() ?>">
        </div>
        <div class="form-group">
            <label>Select Author</label>
            <select name="author_id" multiple class="form-control" required>
                <?php
                    foreach($authors as $author):
                ?>
                        <option value="<?= $author->getAuthorId() ?>"><?= $author->getUsername() ?></option>
                <?php
                    endforeach;
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success btn-block">Create</button>
    </form>
    <?php
        endif;
    ?>
</div><!-- /.container -->