  <festival>
    <id><?php echo $festival['id'] ?></id>
    <title><?php echo $festival['title'] ?></title>
    <url><?php echo $festival['url'] ?></url>
    <ical><?php echo $festival['ical'] ?></ical>
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
    <?php if (strlen($festival['covercharge']) > 0): ?>
    <covercharge><?php echo $festival['covercharge'] ?></covercharge>
    <?php endif ?>
  </festival>
