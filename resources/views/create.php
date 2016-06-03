<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Note/create</title>
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
                <li class="active"><a href="/create">Create</a></li>
                <li><a href="#">Edit</a>
                <li><a href="#">Delete</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="page-header">
        <h3>Create Note</h3>
    </div>
    <div class="alert alert-success" role="alert">
        <strong>Please</strong> complete the form below.
    </div>

    <form action="/create" method="post">
        <div class="form-group">
            <label>Note Title</label>
            <input type="text" name="note-title" class="form-control" placeholder="Title" required>
        </div>
        <div class="form-group">
            <label>Note Content</label>
            <textarea class="form-control" name="note-content" maxlength="100" placeholder="content" required></textarea>
        </div>
        <div class="form-group">
            <label>User</label>
            <input class="form-control"  type="text" value="<?= $user->getFullName()?>" readonly>
            <input hidden type="text" name="note-user-id" value="<?= $user->getId()?>">
        </div>
        <div class="form-group">
            <label>Select Author</label>
            <select name="note-author-id" multiple class="form-control" required>
                <?php foreach($authors as $author):?>
                    <option value="<?= $author->getAuthorId() ?>"><?= $author->getUsername() ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success btn-block">Create</button>
    </form>

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