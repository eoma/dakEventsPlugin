<?php
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<eventdb xmlns="https://intern.kvarteret.no/events/api">
  <limit><?php echo $data['limit'] ?></limit>
  <offset><?php echo $data['offset'] ?></offset>
  <count><?php echo $data['count'] ?></count>
  <totalCount><?php echo $data['totalCount'] ?></totalCount>
  <data>
    <historyList>
<?php foreach ($data['data'] as $h): ?>
      <elem>
        <yearmonth><?php echo $h['yearmonth'] ?></yearmonth>
        <num><?php echo $h['num'] ?></num>
      </elem>
<?php endforeach ?>
    </historyList>
  </data>
</eventdb>
