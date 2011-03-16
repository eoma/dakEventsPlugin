<?php
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<eventdb xmlns="https://intern.kvarteret.no/events/api">
  <limit><?php echo $data['limit'] ?></limit>
  <offset><?php echo $data['offset'] ?></offset>
  <count><?php echo $data['count'] ?></count>
  <totalCount><?php echo $data['totalCount'] ?></totalCount>
  <data>
    <?php if ($subAction == 'get'): ?>
    <?php include_partial('festivalGet', array('festival' => $data['data'][0])) ?>
    <?php elseif ($subAction == 'list'): ?>
    <?php include_partial('festivalList', array('festivals' => $data['data'])) ?>
    <?php endif ?>
  </data>
</eventdb>
