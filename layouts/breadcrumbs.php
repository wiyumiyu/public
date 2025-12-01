<?php if (!empty($breadcrumbs)): ?>
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <?php foreach ($breadcrumbs as $crumb): ?>
      <li class="breadcrumb-item <?= $crumb['active'] ? 'active' : '' ?>">
        <?php if (!$crumb['active']): ?>
            <a href="<?= $crumb['url'] ?>"><?= $crumb['label'] ?></a>
        <?php else: ?>
            <?= $crumb['label'] ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
<?php endif; ?>
