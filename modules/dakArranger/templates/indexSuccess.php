<?php use_helper('HtmlList') ?>
<?php include_partial('dakGlobal/assets') ?>

<?php slot('title', 'Arranger list') ?>
<h1><?php echo __('Arranger list') ?></h1>

<table>
  <thead>
    <tr>
      <th />
      <th><?php echo __('Name') ?></th>
      <th />
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $arranger): ?>
    <tr class="<?php echo HtmlList::Alternate('odd','even'); ?>">
      <td>
        <?php if($arranger['picture_id'] > 0)
          include_partial('dakGlobal/picture', array('picture' => $arranger['logo'], 'format' => 'list'));
        ?>
      </td>
      <td><?php echo link_to($arranger['name'], '@dak_arranger_show?id=' . $arranger['id']) ?></td>
      <td><?php echo $arranger['description'] ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_arranger_index', 'pager' => $pager)) ?>
<?php endif ?>
