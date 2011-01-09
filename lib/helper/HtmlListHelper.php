<?php

class HtmlList
{
  private static $alternateRow = true;

  public static function Alternate($one, $two)
  {
    self::$alternateRow = !self::$alternateRow;
    return self::$alternateRow ? $one : $two;
  }
}
