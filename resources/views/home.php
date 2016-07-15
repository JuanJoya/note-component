<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Note App</title>
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
                <li class="active"><a href="/">List</a></li>
                <li><a href="/create">Create</a></li>
                <li><a href="/find">Find / Edit / Delete </a>
                <li><a href="/search">Search</a>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="page-header">
        <h1>Note Component App</h1>
    </div>
    <div class="well">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur.</p>
    </div>
    <p><a class="btn btn-lg btn-success" href="/create" role="button">Create a note</a></p>
    <div class="page-header">
        <h3>List Notes</h3>
    </div>
    <?php /**
     * @type \Illuminate\Support\Collection $notes
     */
        if(empty($notes->all())):
    ?>
            <div class="alert alert-danger" role="alert">
                <strong>Oops</strong> notes not found.
            </div>
    <?php
        else:
        foreach($notes as $note):
    ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= $note->getTitle()?>
                    <span class="label label-success author">
                        by <?=$note->getAuthor()?>
                    </span>
                    <span class="label label-info author">
                        <?=$note->getAuthorName()?>
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                <?= $note->getContent()?>
            </div>
        </div>
    <?php
        endforeach;
        endif;
    ?>

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