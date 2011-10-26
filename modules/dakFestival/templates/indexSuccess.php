<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', __('Festival list')) ?>
<h1><?php echo __('Festival list') ?></h1>

<table id="eventList" class="dak_padded_table">
  <tbody>
    <?php foreach ($pager->getResults() as $festival): ?>
    <tr class="<?php echo HtmlList::Alternate('odd','even'); ?>">
      <td>
        <?php echo link_to($festival['title'], '@dak_festival_show?id=' . $festival['id']) ?><br />
        <span><?php if (strlen($festival['leadParagraph']) > 100) { echo substr($festival['leadParagraph'], 0, 97) . '...'; } else { echo $festival['leadParagraph']; } ?></span><br />
        <?php echo __('Main location') ?>:
        <?php 
        if ( ! $festival['location_id'] ) {
          echo $festival['customLocation'];
        } else {
          echo link_to($festival['commonLocation']['name'], '@dak_location_show?id=' . $festival['location_id']);
        }
        ?><br />
        <?php echo __('When?') ?>: <?php include_partial('dakEvent/startEndDateTime', array('event' => $festival)) ?><br />
       <?php if (strlen($festival['covercharge']) > 0): ?>
         <b><?php echo __('Covercharge') ?></b>: <?php echo $festival['covercharge'] ?><br />
       <?php endif ?>

        <?php echo __('Arrangers') ?>: <?php foreach ($festival['arrangers'] as $a) { echo link_to($a['name'], '@dak_arranger_show?id=' . $a['id']) . ' '; } ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_festival_index', 'pager' => $pager)) ?>
<?php endif; ?>
