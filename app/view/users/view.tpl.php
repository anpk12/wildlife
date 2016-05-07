<h1><?=$user->acronym?> (<?=$user->name?>)</h1>

<pre><?=var_dump($user->getProperties())?></pre>

<p><a href='<?=$this->url->create('')?>'>Home</a></p>

