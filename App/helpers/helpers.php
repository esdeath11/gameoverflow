<?php

use App\Core\View;

function __e($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function service($className = null) {
    if (empty($className)) {
        return \App\Core\ServiceContainer::i();
    } else {
        return \App\Core\ServiceContainer::i()->findClass($className);
    }
}

/**
 * @return \App\Core\Request|mixed|null
 */
function request() {
    return service(\App\Core\Request::class);
}

/**
 * @return \App\Core\Session|mixed|null
 */
function session() {
    return service(\App\Core\Session::class);
}

function ev($obj = [], ...$args) {
    var_dump($obj, ...$args);
    exit();
}

function now($format = 'Y-m-d H:i:s') {
    return (new DateTime('now'))->format($format);
}

function dt($dateString, $format = 'Y-m-d H:i:s', $outputFormat = 'j F Y') {
    return (DateTime::createFromFormat($format, $dateString))->format($outputFormat);
}

function view($path, $data = []) {
    return View::make($path, $data);
}

/**
 * set output to json.
 * @param $data
 * @param int $statusCode
 * @return false|string
 */
function json($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    print(json_encode($data, JSON_PRETTY_PRINT));
}

/**
 * @param $haystack
 * @param $needle
 * @param bool $caseSensitive
 * @return bool
 * @see https://stackoverflow.com/questions/4366730/how-do-i-check-if-a-string-contains-a-specific-word
 */
function contains($haystack, $needle, $caseSensitive = false) {
    return $caseSensitive ?
        (strpos($haystack, $needle) === FALSE ? FALSE : TRUE):
        (stripos($haystack, $needle) === FALSE ? FALSE : TRUE);
}

/**
 * @param $string
 * @param $startString
 * @return bool
 * @see https://css-tricks.com/snippets/php/test-if-string-starts-with-certain-characters-in-php/
 */
function startsWith($string, $startString) {
    return strpos($string, $startString) === 0;
}

/**
 * Get base url
 * @return string
 */
function base_url() {
    return \App\Core\Url::base();
}

function route($to = '', $param = null, $withCurrentQuery = false) {
    return \App\Core\Url::route($to, $param, $withCurrentQuery);
}

/**
 * Get current url
 * @return string
 */
function current_url() {
    return \App\Core\Url::current();
}

/**
 * Get asset path
 * @param string $path
 * @param string $rootDir
 * @return string
 */
function asset($path = '', $rootDir = 'assets/') {
    return \App\Core\Url::asset($path, $rootDir);
}

function importView($fileName, $data = []) {
    extract(View::getSharedAttributes(), EXTR_SKIP);
    extract($data, EXTR_SKIP);
    include_once VIEW_PATH . DS . str_replace('.', DS, str_replace('.php', '', $fileName)) . '.php';
}

/**
 * Convert String Seperti ini menjadi string-seperti-ini
 * @param $text
 * @return false|string|string[]|null
 * @see https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
 */
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * @return \App\Models\User|null
 */
function auth() {
    return session()->get('__auth', null);
}

function old($key, $default = null) {
    return request()->getOldRequest($key, $default);
}

function generateInvoiceNo($prefix = 'GO') {
    return $prefix . '-' . strtoupper(substr(uniqid(time()), 0, 9));
}