<?php
/**
 * PHP Compatibility Layer (5.6 to 8.3)
 * Provides shims for removed functions in newer PHP versions.
 */

// MySQL to MySQLi Shim
if (!function_exists('mysql_connect')) {

    if (!defined('MYSQL_ASSOC')) define('MYSQL_ASSOC', MYSQLI_ASSOC);
    if (!defined('MYSQL_NUM')) define('MYSQL_NUM', MYSQLI_NUM);
    if (!defined('MYSQL_BOTH')) define('MYSQL_BOTH', MYSQLI_BOTH);

    $GLOBALS['GLOBAL_MYSQL_CONN'] = null;

    function mysql_connect($host, $user, $password, $new_link = false, $client_flags = 0) {
        $GLOBALS['GLOBAL_MYSQL_CONN'] = mysqli_connect($host, $user, $password);
        return $GLOBALS['GLOBAL_MYSQL_CONN'];
    }

    function mysql_pconnect($host, $user, $password, $client_flags = 0) {
        return mysql_connect('p:' . $host, $user, $password);
    }

    function mysql_select_db($database_name, $link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        return mysqli_select_db($conn, $database_name);
    }

    function mysql_query($query, $link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        return mysqli_query($conn, $query);
    }

    function mysql_db_query($database, $query, $link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        mysqli_select_db($conn, $database);
        return mysqli_query($conn, $query);
    }

    function mysql_fetch_assoc($result) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_assoc($result);
    }

    function mysql_fetch_array($result, $result_type = MYSQL_BOTH) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_array($result, $result_type);
    }

    function mysql_fetch_row($result) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_row($result);
    }

    function mysql_num_rows($result) {
        if (!$result || !($result instanceof mysqli_result)) return 0;
        return mysqli_num_rows($result);
    }

    function mysql_num_fields($result) {
        if (!$result || !($result instanceof mysqli_result)) return 0;
        return mysqli_num_fields($result);
    }

    function mysql_affected_rows($link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        return mysqli_affected_rows($conn);
    }

    function mysql_error($link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        if (!$conn) return mysqli_connect_error();
        return mysqli_error($conn);
    }

    function mysql_errno($link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        if (!$conn) return mysqli_connect_errno();
        return mysqli_errno($conn);
    }

    function mysql_real_escape_string($unescaped_string, $link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        if (!$conn) {
             return addslashes($unescaped_string);
        }
        return mysqli_real_escape_string($conn, $unescaped_string);
    }
    
    function mysql_escape_string($unescaped_string) {
        return addslashes($unescaped_string);
    }

    function mysql_insert_id($link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        if (!$conn) return 0;
        return mysqli_insert_id($conn);
    }
    
    function mysql_close($link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        if (!$conn) return true;
        return mysqli_close($conn);
    }
    
    function mysql_data_seek($result, $row_number) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_data_seek($result, $row_number);
    }
    
    function mysql_fetch_object($result, $class_name = "stdClass", $params = array()) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        if (empty($params)) {
            return mysqli_fetch_object($result, $class_name);
        }
        return mysqli_fetch_object($result, $class_name, $params);
    }
    
    function mysql_result($result, $row, $field = 0) {
        if (!$result || !($result instanceof mysqli_result) || mysqli_num_rows($result) <= $row) return false;
        mysqli_data_seek($result, $row);
        $data = mysqli_fetch_array($result, MYSQLI_BOTH);
        return $data[$field];
    }
    
    function mysql_free_result($result) {
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
        }
    }

    function mysql_field_name($result, $field_offset) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        $properties = mysqli_fetch_field_direct($result, $field_offset);
        return is_object($properties) ? $properties->name : false;
    }

    function mysql_field_type($result, $field_offset) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        $properties = mysqli_fetch_field_direct($result, $field_offset);
        return is_object($properties) ? $properties->type : false;
    }
    
    function mysql_client_encoding($link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        if (!$conn) return 'utf8';
        return mysqli_character_set_name($conn);
    }
    
    function mysql_get_server_info($link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        if (!$conn) return '';
        return mysqli_get_server_info($conn);
    }

    function mysql_list_tables($database, $link_identifier = null) {
        $conn = $link_identifier ?: $GLOBALS['GLOBAL_MYSQL_CONN'];
        return mysqli_query($conn, "SHOW TABLES FROM $database");
    }
}

// each() was removed in PHP 8.0
if (!function_exists('each')) {
    function each(&$array) {
        $key = key($array);
        if ($key === null) {
            return false;
        }
        $value = current($array);
        next($array);
        return [
            1 => $value,
            'value' => $value,
            0 => $key,
            'key' => $key,
        ];
    }
}

// POSIX Regex shims (removed in PHP 7.0)
if (!function_exists('ereg')) {
    function ereg($pattern, $string, &$regs = null) {
        return preg_match('/' . str_replace('/', '\/', $pattern) . '/', $string, $regs);
    }
}

if (!function_exists('eregi')) {
    function eregi($pattern, $string, &$regs = null) {
        return preg_match('/' . str_replace('/', '\/', $pattern) . '/i', $string, $regs);
    }
}

if (!function_exists('ereg_replace')) {
    function ereg_replace($pattern, $replacement, $string) {
        return preg_replace('/' . str_replace('/', '\/', $pattern) . '/', $replacement, $string);
    }
}

if (!function_exists('eregi_replace')) {
    function eregi_replace($pattern, $replacement, $string) {
        return preg_replace('/' . str_replace('/', '\/', $pattern) . '/i', $replacement, $string);
    }
}

if (!function_exists('split')) {
    function split($pattern, $string, $limit = -1) {
        return preg_split('/' . str_replace('/', '\/', $pattern) . '/', $string, $limit);
    }
}

// Support for deprecated magic_quotes_gpc in PHP 7+
if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc() {
        return false;
    }
}

if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime() {
        return false;
    }
}

if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting) {
        return false;
    }
}

/**
 * Handle $HTTP_RAW_POST_DATA removal in PHP 7+
 */
if (!isset($HTTP_RAW_POST_DATA) && PHP_VERSION_ID >= 70000) {
    if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') === false) {
        $HTTP_RAW_POST_DATA = file_get_contents('php://input');
        $GLOBALS['HTTP_RAW_POST_DATA'] = $HTTP_RAW_POST_DATA;
    }
}

/**
 * Safe count function for PHP 8+
 */
if (PHP_VERSION_ID >= 80000) {
    function safe_count($var) {
        if ($var === null) return 0;
        if (is_array($var) || $var instanceof Countable) return count($var);
        return 1;
    }
} else {
    function safe_count($var) {
        return count($var);
    }
}

/**
 * PHP 8.1+ Null to non-nullable internal functions safety
 */
if (PHP_VERSION_ID >= 80100) {
    // Shimming common functions to be null-safe
    function safe_trim($str) { return trim($str ?? ''); }
    function safe_strlen($str) { return strlen($str ?? ''); }
    function safe_explode($sep, $str, $limit = PHP_INT_MAX) { return explode($sep, $str ?? '', $limit); }
    function safe_substr($str, $start, $length = null) { return substr($str ?? '', $start, $length); }
} else {
    function safe_trim($str) { return trim($str); }
    function safe_strlen($str) { return strlen($str); }
    function safe_explode($sep, $str, $limit = PHP_INT_MAX) { return explode($sep, $str, $limit); }
    function safe_substr($str, $start, $length = null) { return substr($str, $start, $length); }
}

/**
 * Polyfill for PHP 8.2+ dynamic properties deprecation
 * Note: # is a comment in PHP 5, so this is safe for 5.6
 */
// #[AllowDynamicProperties] 

