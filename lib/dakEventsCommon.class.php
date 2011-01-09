<?php

class dakEventsCommon
{

  public static function CKEditorToolbarBasic ()
  {
    return array(array('Source', 'RemoveFormat', '-', 'Copy', 'Cut', 'Paste', 'PasteText', 'PasteFromWord'));
  }

  public static function CKEditorToolbarCommon ()
  {
    return array(array('Source', 'RemoveFormat', '-', 'Copy', 'Cut', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Bold', 'Italic', 'Underline', 'Strike', '-', 'NumberedList','BulletedList','-','Outdent','Indent','Blockquote', '-', 'Image', 'Link', 'Unlink'));
  }

}