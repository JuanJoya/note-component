<div class="page-header">
    <h3>Result</h3>
</div>
<?php
/**
 * @type \Illuminate\Support\Collection $notes
 */
    if(empty($notes)):
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