<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Note/edit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link href="<?= Helper::asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="glyphicon glyphicon-edit logo"></span>
            <a class="navbar-brand" href="/">Note Component</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">List</a></li>
                <li><a href="/create">Create</a></li>
                <li class="active"><a href="/find">Find / Edit / Delete</a>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="page-header">
        <h3>Author Notes</h3>
    </div>
    <div class="alert alert-warning" role="alert">
        <strong>Please</strong> select the note to edit.
    </div>
    <?php
    /**
     * @type \Illuminate\Support\Collection $notes
     */
    ?>
    <div class="form-group">
        <label>User</label>
        <input class="form-control"  type="text" value="<?= $notes->first()->getAuthorName() ?>" readonly>
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control"  type="text" value="<?= $notes->first()->getAuthor() ?>" readonly>
    </div>

    <div class="page-header">
        <h4>Notes</h4>
    </div>
    <?php foreach($notes as $note):?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= $note->getTitle()?>
                    <div class="btn-group btn-group-xs note-btn" role="group">
                        <a href="/update/<?= $note->getId()?>" type="button" class="btn btn-warning">Update</a>
                        <a href="/delete/<?= $note->getId()?>" type="button" class="btn btn-danger">Delete</a>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                <?= $note->getContent()?>
            </div>
        </div>
    <?php endforeach ?>

</div><!-- /.container -->

<footer class="footer">
    <div class="container">
        <p class="text-muted">&copy; 2016 Note Component</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous">
</script>

</body>
</html>