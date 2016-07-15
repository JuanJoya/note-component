<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Note/find</title>
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
                <li><a href="/find">Find / Edit / Delete</a>
                <li class="active"><a href="/search">Search</a>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="page-header">
        <h3>Search Note</h3>
    </div>
    <div class="alert alert-info" role="alert">
        <strong>Please</strong> type any word of title or content of a note.
    </div>

    <form action="/search" method="post" id="search-form">
        <div class="form-group">
            <div class="input-group input-group-lg">
                <span class="input-group-addon" id="basic-addon1">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                </span>
                <input name="note-word" type="text" id="search-input" class="form-control" placeholder="find" required>
            </div>
        </div>
        <!--<button type="submit" class="btn btn-info btn-block">search</button>-->
    </form>
    <div class="result" id="result">
    </div>
</div><!-- /.container -->

<footer class="footer">
    <div class="container">
        <p class="text-muted">&copy; 2016 Note Component</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous">
</script>
<script src="<?= Helper::asset('js/search.js') ?>"></script>

</body>
</html>