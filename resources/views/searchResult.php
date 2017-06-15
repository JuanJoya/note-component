<div class="page-header">
    <h3>Result</h3>
</div>
<?php
/**
 * @type \Illuminate\Support\Collection $notes
 * @type string $query
 */
    if(empty($notes) || $notes->isEmpty()):
?>
        <div class="alert alert-danger" role="alert">
            <strong>Oops</strong> hasn't been found any note.
        </div>
<?php
    else:
        foreach($notes as $note):
?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?= Helper::strong($query, $note->getTitle()) ?>
                        <span class="label label-success author">
                    by <?= $note->getAuthor()->getUsername() ?>
                </span>
                <span class="label label-info author">
                    <?= $note->getAuthor()->getFullName() ?>
                </span>
                    </h3>
                </div>
                <div class="panel-body">
                    <?= Helper::strong($query, $note->getContent()) ?>
                </div>
            </div>
<?php
        endforeach;
    endif;
?>