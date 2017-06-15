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
     * @type \Note\Domain\Note $note
     */
        if($notes->isEmpty()):
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
                    <?= $note->getTitle() ?>
                    <span class="label label-success author">
                        by <?= $note->getAuthor()->getUsername() ?>
                    </span>
                    <!-- <span class="label label-info author">
                    </span> -->
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