<arrangers>
  <?php foreach ($arrangers as $a): ?>
  <arranger>
    <id><?php echo $a['id'] ?></id>
    <name><?php echo $a['name'] ?></name>
    <description><?php echo $a['name'] ?></description>
  </arranger>
  <?php endforeach ?>
</arrangers>
