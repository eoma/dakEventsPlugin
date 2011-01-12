<?php
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<eventdb xmlns="https://intern.kvarteret.no/events/api">
  <festival>
    <id><?php echo $festival['id'] ?></id>
    <title><?php echo $festival['id'] ?></title>
    <leadParagraph><?php echo $festival['leadParagraph'] ?></leadParagraph>
    <description><?php echo $festival['description'] ?></description>
    <startDate><?php echo $festival['startDate'] ?></startDate>
    <startTime><?php echo $festival['startTime'] ?></startTime>
    <endDate><?php echo $festival['endDate'] ?></endDate>
    <endTime><?php echo $festival['endTime'] ?></endTime>
    <createdAt><?php echo $festival['created_at'] ?></createdAt>
    <updatedAt><?php echo $festival['updated_at'] ?></updatedAt>
    <arrangers>
      <?php foreach ($festival['arrangers'] as $a): ?>
      <arranger>
        <id><?php echo $a['id'] ?></id>
	<name><?php echo $a['name'] ?></name>
      </arranger>
      <?php endforeach ?>
    </arrangers>
  </festival>
</eventdb>
