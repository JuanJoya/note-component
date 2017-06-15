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
                <input type="text" id="search-input" class="form-control" placeholder="find" required>
            </div>
        </div>
        <!--<button type="submit" class="btn btn-info btn-block">search</button>-->
    </form>
    <div class="result" id="result">
    </div>
</div><!-- /.container -->