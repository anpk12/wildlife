<h1><?=$title?></h1>

<ul>
<li><a href='<?=$this->url->create('users')?>'>Available actions</a></li>
<li><a href='<?=$this->url->create('users/setup')?>'>Setup</a></li>
<li><a href='<?=$this->url->create('users/list')?>'>List all users</a></li>
<li><a href='<?=$this->url->create('users/active')?>'>List all active users</a></li>
<li><a href='<?=$this->url->create('users/inactive')?>'>List all inactive users</a></li>
<li><a href='<?=$this->url->create('users/deleted')?>'>List all soft-deleted users</a></li>
<li><a href='<?=$this->url->create('users/add')?>'>Add a new user</a></li>

<?php foreach ($users as $user) : ?>
<li>
    <a href='<?=$this->url->create('users/id/' . $user->id)?>'>
       View details on user <?=$user->id?>
    </a>
</li>
<?php endforeach; ?>
<?php foreach ($users as $user) : ?>
<li>
    <a href='<?=$this->url->create('users/delete/' . $user->id)?>'>
        Delete user <?=$user->id?>
    </a>
</li>
<?php endforeach; ?>
<?php foreach ($users as $user) : if ( $user->deleted == null) { ?>
<li>
    <a href='<?=$this->url->create('users/soft-delete/' . $user->id)?>'>
        Soft delete user <?=$user->id?>
    </a>
</li>
<?php } endforeach; ?>
<?php foreach ($users as $user) : if ( $user->deleted != null ) { ?>
<li>
    <a href='<?=$this->url->create('users/undelete/' . $user->id)?>'>
        Undo soft-delete user <?=$user->id?>
    </a>
</li>
<?php } endforeach; ?>
<?php foreach ($users as $user) : ?>
<li>
    <a href='<?=$this->url->create('users/update/' . $user->id)?>'>
        Update user <?=$user->id?>
    </a>
</li>
<?php endforeach; ?>
<?php foreach ($users as $user) : if ( $user->active == null ) { ?>
<li>
    <a href='<?=$this->url->create('users/activate/' . $user->id)?>'>
        Activate user <?=$user->id?>
    </a>
</li>
<?php } endforeach; ?>
<?php foreach ($users as $user) : if ( $user->active != null ) { ?>
<li>
    <a href='<?=$this->url->create('users/deactivate/' . $user->id)?>'>
        Deactivate user <?=$user->id?>
    </a>
</li>
<?php } endforeach; ?>
</ul>

