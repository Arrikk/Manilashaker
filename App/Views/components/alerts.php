<?php
function __alerts()
{
    $message = \App\Flash::getMessage();
    ?>  
    <?php  if($message): ?>
        <?php foreach($message as $mssg): ?>
            <div class="alert border-0 border-<?= $mssg['type'] ?> border-start border-4 bg-light-<?= $mssg['type'] ?> alert-dismissible fade show">
                <div class="text-<?= $mssg['type'] ?>"><?= $mssg['message'] ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php
}