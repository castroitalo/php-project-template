<?php $this->layout(CONF_VIEW_TEMPLATE, ["title" => $page_data["title"]]); ?>

<?php $this->start("styles"); ?>
<link rel="stylesheet" href="<?= get_url("/static/styles/pages/homepage.view.css"); ?>">
<?php $this->end(); ?>

<div class="homepage-container">
    <h1>Homepage App</h1>
</div>

<?php $this->start("scripts"); ?>
<script src="<?= get_url("/static/javascript/pages/homepage.view.js") ?>"></script>
<?php $this->end(); ?>
