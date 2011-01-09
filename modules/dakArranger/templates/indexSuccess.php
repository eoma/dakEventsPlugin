<?php use_helper('HtmlList') ?>

<?php slot('title', 'Arranger list') ?>
<h1><?php echo __('Arranger list') ?></h1>

<table>
  <thead>
    <tr>
      <th><?php echo __('Name') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $arranger): ?>
    <tr class="<?php echo HtmlList::Alternate('odd','even'); ?>">
      <td><?php echo link_to($arranger['name'], '@dak_arranger_show?id=' . $arranger['id']) ?></td>
      <td><?php echo $arranger['description'] ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_arranger_index', 'pager' => $pager)) ?>
<?php endif ?>
