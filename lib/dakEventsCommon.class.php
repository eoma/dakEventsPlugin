<?php

class dakEventsCommon
{

  public static function CKEditorToolbarBasic ()
  {
    return array(array('Source', 'RemoveFormat', '-', 'Copy', 'Cut', 'PasteText'));
  }

  public static function CKEditorToolbarBlock ()
  {
    return array(array('Source', 'RemoveFormat', '-', 'Copy', 'Cut', 'PasteText', '-', 'Bold', 'Italic', '-', 'Link', 'Unlink'));
  }

  public static function CKEditorToolbarCommon ()
  {
    return array(array('Source', 'RemoveFormat', '-', 'Copy', 'Cut', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Bold', 'Italic', 'Underline', 'Strike', '-', 'NumberedList','BulletedList','-','Outdent','Indent','Blockquote', '-', 'Image', 'Link', 'Unlink'));
  }

}
