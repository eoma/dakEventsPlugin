<festivals>
  <?php foreach ($festivals as $f): ?>
  <festival>
    <id><?php echo $f['id'] ?></id>
    <title><?php echo $f['title'] ?></title>
    <url><?php echo $f['url'] ?></url>
    <ical><?php echo $f['ical'] ?></ical>
    <leadParagraph><?php echo $f['leadParagraph'] ?></leadParagraph>
    <description><?php echo $f['description'] ?></description>
    <startDate><?php echo $f['startDate'] ?></startDate>
    <startTime><?php echo $f['startTime'] ?></startTime>
    <endDate><?php echo $f['endDate'] ?></endDate>
    <endTime><?php echo $f['endTime'] ?></endTime>
    <createdAt><?php echo $f['created_at'] ?></createdAt>
    <updatedAt><?php echo $f['updated_at'] ?></updatedAt>
    <arrangers>
      <?php foreach ($f['arrangers'] as $a): ?>
      <arranger>
        <id><?php echo $a['id'] ?></id>
        <name><?php echo $a['name'] ?></name>
      </arranger>
      <?php endforeach ?>
    </arrangers>
  </festival>
  <?php endforeach ?>
</festivals>
