<?php

use App\Core\Http\Url;

$this->layout('/layouts/index.view', ['title' => 'Homepage']);

?>

<!-- Import page styles -->
<?php $this->start('styles'); ?>
<link rel="stylesheet" href="<?= Url::getUrl('/static/styles/pages/homepage/homepage.view.css'); ?>">
<?php $this->end(); ?>

<h1>HOMEPAGE PLATES</h1>

<h2 id="css-warning">Red if CSS is active</h2>

<button id="click-me" class="btn btn-primary">Click on the Bootstrap button</button>

<h2 id="jquery-warning" style="display: none;">jQuery is active</h2>

<!-- Import page scripts -->
<?php $this->start('scripts'); ?>
<script src="<?= Url::getUrl('/static/js/pages/homepage/homepage.view.js'); ?>"></script>
<?php $this->end(); ?>
