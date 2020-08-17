<?php foreach ($users as $user) : ?>
    <?=esc($user['first_name']) ?> <?=esc($user['last_name'])?> <br />
<?php endforeach ?>