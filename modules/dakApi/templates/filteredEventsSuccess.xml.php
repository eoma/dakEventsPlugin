<?php
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<eventdb xmlns="https://intern.kvarteret.no/events/api">
  <limit><?php echo $data['limit'] ?></limit>
  <offset><?php echo $data['offset'] ?></offset>
  <count><?php echo $data['count'] ?></count>
  <totalCount><?php echo $data['totalCount'] ?></totalCount>
  <data>
    <?php include_partial('eventList', array('events' => $data['data'])) ?>
  </data>
</eventdb>
