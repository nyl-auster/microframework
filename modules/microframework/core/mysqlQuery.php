<?php
namespace microframework\core;

/**
 * @file na_query.
 *
 * na_query class allow to write "prepared queries" with placeholders instead
 * of using php variables directly in a query. Using this class, you dont have to
 * care about casting and escaping variables.
 *
 * Example of a na_query :
 *
 * @code
 * $query = new mysqlQuery();
 * $sql = 'SELECT * FROM user ORDER BY id DESC LIMIT @start:int, @limit:int';
 * $result = $query->execute($sql, array('start' => $start, 'limit' => $limit));
 * @endcode
 *
 * @start will be replaced by the value of $start variable; and variable will be cast
 * as an int.
 *
 * @dependencie : none
 */

/**
 * Display na query if config asked for it.
 function na_shutdown_query_debug($prepared_query, $parsed_query) {
   print '<div class="na-logs">';
   print "<b>prepared query</b> : $prepared_query <br/>";
   print "<b> parsed query</b> : $parsed_query <br />";
   print '</div>';
}
 */

class mysqlQuery {

  // token to replace with variables will begin with this sign
  const tokenMarker = '@';
  // type of variable will be separated of token by this sign
  const tokenTypeSeparator = ':';

  // values they are supposed to receive.
  public function execute($prepared_query, $values = array()) {
    $tokens = $this->matchTokens($prepared_query);
    $parsed_query = $this->replaceTokens($prepared_query, $values, $tokens);
    $result = mysql_query($parsed_query);
    return $result ? $result : die(mysql_error());
  }

  /**
   * Retrieve tokens inside a sql query. e.g
   * in the query "SELECT * FROM article WHERE id=@id:int AND teaser > @teaser:string",
   * token @id:int and @teaser:string will be identified.
   *
   * @return an associative array of tokens identified with following keys :
   * - pattern : the full token (@id:string)
   * - variable : e.g : id
   * - type : php type of variable, in order to cast it later. This is string by default, so "string"
   * type is optionnal when settings tokens for a query.
   */
  function matchTokens($query) {
    $tokenMarker = self::tokenMarker;
    $separator = self::tokenTypeSeparator;
    preg_match_all("#$tokenMarker\w+$separator%?\w+#", $query, $matches);
    $tokens = array();
    foreach ($matches[0] as $token) {
      $datas = explode(':', substr($token, 1));
      $tokens[] = array(
        'pattern' => $token,
        'variable' => $datas[0],
        'type' => isset($datas[1]) ? $datas[1] : 'string',
      );
    }
    return $tokens;
  }

  /**
   * replace tokens by identified in "matchTokens" by
   * values. Values are sanitized by casting, adding quotes and using mysql_real_escape_string.
   * function.
   *
   * @param $query : a prepared query, with its tokens
   * @param $values
   * An associative array of values; key being the variable name.
   * Variable name MUST match the token name to being replaced.
   * @param $tokens
   * tokens as returned by matchTokens
   */
  function replaceTokens($query, $values, $tokens) {
    $replacements = array();
    $values = array_map('mysql_real_escape_string', $values);
    foreach ($tokens as $name => $token) {
      // if no value is provided for a token, mark its value as "UNDEFINED
      // This is also a way to make sure that strtr function works as expected,
      // as missing tokens cool lead to unexpected replacements in some situations.
      if (!isset($values[$token['variable']])) {
        $replacements[$token['pattern']] = "' MISSING VALUE '";
      }
      else {
        $variable = $values[$token['variable']];
        $variable = sprintf($token['type'], $variable);
        $variable = $token['type'] == '%s' ? "'$variable'" : $variable;
        $replacements[$token['pattern']] = $variable;
      }
    }
    // let's effectively replace our tokens by our variables.
    $query = strtr($query, $replacements);
    return $query;
  }


  /**
   * Put result of a mysql ressource into a php array
   */
  public function result($result) {
    $rows = array();
    while ($row = mysql_fetch_assoc($result, MYSQL_ASSOC)) {
      $rows[] = $row;
    }
    return $rows;
  }

}

