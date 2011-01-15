<?php use_helper('HtmlList') ?>
<?php include_partial('dakGlobal/assets') ?>

<?php echo slot('title', __('Location list')) ?>
<h1><?php echo __('Location list') ?></h1>

<table>
  <thead>
    <tr>
      <th><?php echo __('Name') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $location): ?>
    <tr class="<?php echo HtmlList::Alternate('odd','even'); ?>">
      <td>
        <?php echo link_to($location['name'], '@dak_location_show?id=' . $location['id']) ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_location_index', 'pager' => $pager)) ?>
<?php endif ?>
