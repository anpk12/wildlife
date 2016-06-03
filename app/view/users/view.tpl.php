<h1><?=$user->acronym?> (<?=$user->name?>)</h1>


<img class="avatar" src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($user->email)))?>" />

