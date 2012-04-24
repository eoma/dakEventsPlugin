<?php
// Demands the objects pager and route 

if (!isset($routeArgs)) {
  $routeArgs = array();
}

if ($routeArgs instanceof sfOutputEscaperArrayDecorator) {
  $routeArgs = $routeArgs->getRawValue();
}

$url = url_for($route, $routeArgs, false);

?>

  <div class="dak_pagination">
    <a class="first" href="<?php echo $url ?>?page=1">
      <img src="<?php echo public_path(sfConfig::get('dak_events_module_web_dir') . '/images/first.png') ?>" alt="First page" title="First page" />
    </a>
 
    <a class="previous" href="<?php echo $url ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <img src="<?php echo public_path(sfConfig::get('dak_events_module_web_dir') . '/images/previous.png') ?>" alt="Previous page" title="Previous page" />
    </a>

    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo $url ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a class="next" href="<?php echo $url ?>?page=<?php echo $pager->getNextPage() ?>">
      <img src="<?php echo public_path(sfConfig::get('dak_events_module_web_dir') . '/images/next.png') ?>" alt="Next page" title="Next page" />
    </a>
 
    <a class="last" href="<?php echo $url ?>?page=<?php echo $pager->getLastPage() ?>">
      <img src="<?php echo public_path(sfConfig::get('dak_events_module_web_dir') . '/images/last.png') ?>" alt="Last page" title="Last page" />
    </a>
  </div>
