<?php

namespace App\Libraries;

class Diff{

  const UNMODIFIED = 0;
  const DELETED    = 1;
  const INSERTED   = 2;

  public static function compare(
      $string1, $string2){

    $start = 0;
    $sequence1 = preg_split('/\R/', $string1);
    $sequence2 = preg_split('/\R/', $string2);
    $end1 = count($sequence1) - 1;
    $end2 = count($sequence2) - 1;

    while ($start <= $end1 && $start <= $end2
        && $sequence1[$start] == $sequence2[$start]){
      $start ++;
    }

    while ($end1 >= $start && $end2 >= $start
        && $sequence1[$end1] == $sequence2[$end2]){
      $end1 --;
      $end2 --;
    }

    $table = self::computeTable($sequence1, $sequence2, $start, $end1, $end2);

    $partialDiff =
        self::generatePartialDiff($table, $sequence1, $sequence2, $start);

    // generate the full diff
    $diff = array();
    for ($index = 0; $index < $start; $index ++){
      $diff[] = array($sequence1[$index], self::UNMODIFIED);
    }
    while (count($partialDiff) > 0) $diff[] = array_pop($partialDiff);
    for ($index = $end1 + 1;
        $index < count($sequence1);
        $index ++){
      $diff[] = array($sequence1[$index], self::UNMODIFIED);
    }

    return $diff;

  }

  public static function compareFiles(
      $file1, $file2){

    $file1_contents = "";
    $file2_contents = "";
    if(file_exists($file1)){
      $file1_contents = file_get_contents($file1);
    }
    if(file_exists($file2)){
      $file2_contents = file_get_contents($file2);
    }


    return self::compare(
        $file1_contents,
        $file2_contents
      );

  }


  private static function computeTable(
      $sequence1, $sequence2, $start, $end1, $end2){

    $length1 = $end1 - $start + 1;
    $length2 = $end2 - $start + 1;

    $table = array(array_fill(0, $length2 + 1, 0));

    for ($index1 = 1; $index1 <= $length1; $index1 ++){

      $table[$index1] = array(0);

      for ($index2 = 1; $index2 <= $length2; $index2 ++){

        if ($sequence1[$index1 + $start - 1]
            == $sequence2[$index2 + $start - 1]){
          $table[$index1][$index2] = $table[$index1 - 1][$index2 - 1] + 1;
        }else{
          $table[$index1][$index2] =
              max($table[$index1 - 1][$index2], $table[$index1][$index2 - 1]);
        }

      }
    }

    return $table;

  }


  private static function generatePartialDiff(
      $table, $sequence1, $sequence2, $start){

    $diff = array();

    $index1 = count($table) - 1;
    $index2 = count($table[0]) - 1;

    while ($index1 > 0 || $index2 > 0){

      if ($index1 > 0 && $index2 > 0
          && $sequence1[$index1 + $start - 1]
              == $sequence2[$index2 + $start - 1]){

        $diff[] = array($sequence1[$index1 + $start - 1], self::UNMODIFIED);
        $index1 --;
        $index2 --;

      }elseif ($index2 > 0
          && $table[$index1][$index2] == $table[$index1][$index2 - 1]){

        $diff[] = array($sequence2[$index2 + $start - 1], self::INSERTED);
        $index2 --;

      }else{

        $diff[] = array($sequence1[$index1 + $start - 1], self::DELETED);
        $index1 --;

      }

    }

    return $diff;

  }

  



  public static function toTable($diff, $indentation = '', $separator = '<br>'){

    $html = $indentation . "<table class=\"diff\">\n";

    $index = 0;
    while ($index < count($diff)){

      switch ($diff[$index][1]){

        case self::UNMODIFIED:
          $leftCell =
              self::getCellContent(
                  $diff, $indentation, $separator, $index, self::UNMODIFIED);
          $rightCell = $leftCell;
          break;

        case self::DELETED:
          $leftCell =
              self::getCellContent(
                  $diff, $indentation, $separator, $index, self::DELETED);
          $rightCell =
              self::getCellContent(
                  $diff, $indentation, $separator, $index, self::INSERTED);
          break;

        case self::INSERTED:
          $leftCell = '';
          $rightCell =
              self::getCellContent(
                  $diff, $indentation, $separator, $index, self::INSERTED);
          break;

      }

      $html .=
          $indentation
          . "  <tr>\n"
          . $indentation
          . '    <td class="diff'
          . ($leftCell == $rightCell
              ? 'Unmodified'
              : ($leftCell == '' ? 'Blank' : 'Deleted'))
          . '">'
          . $leftCell
          . "</td>\n"
          . $indentation
          . '    <td class="diff'
          . ($leftCell == $rightCell
              ? 'Unmodified'
              : ($rightCell == '' ? 'Blank' : 'Inserted'))
          . '">'
          . $rightCell
          . "</td>\n"
          . $indentation
          . "  </tr>\n";

    }

    return $html . $indentation . "</table>\n";

  }

 
  private static function getCellContent(
      $diff, $indentation, $separator, &$index, $type){

    $html = '';

    // loop over the matching lines, adding them to the HTML
    while ($index < count($diff) && $diff[$index][1] == $type){
      $html .=
          '<span>'
          . htmlspecialchars($diff[$index][0])
          . '</span>'
          . $separator;
      $index ++;
    }

    return $html;

  }

}

?>
