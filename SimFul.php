<?php

class SimFul {

    private $_initial = array();
    private $_endpoints = array( 'GET' => array(), 'POST' => array(), 'PUT' => array(), 'PATCH' => array(), 'DELETE' => array() );

    private $_request = array();
    private $_response = array();

    public function run() {
        header('Content-Type: application/json');

        parse_str($_SERVER['QUERY_STRING'], $query);
        parse_str(file_get_contents("php://input"), $body);

        $this->_request = array(
            'method' => $_SERVER['REQUEST_METHOD'],
            'url' => trim($_SERVER['PATH_INFO'],'/'),
            'body' => $body
        );

        array_map(function($v) {

            $this->_response['header'] = headers_list();

            $v($this->_request, $this->_response);

        }, $this->_initial);

        array_map(function($v) {

            $matches = $this->_match($v['url'], $this->_request['url']);

            if ($matches) {

                $this->_request['params'] = $matches;

                $v['callback']($this->_request, $this->_response);
            }

        }, $this->_endpoints[ $this->_request['method'] ]);

        return;
    }

    private function _match($pattern, $uri) {

        preg_match($this->_regex(trim($pattern,'/')), $uri, $matches);

        return $matches;
    }

    private function _regex($pattern) {

        if (preg_match('/[^-:\/_{}()a-zA-Z\d]/', $pattern)) return false;

        $pattern = preg_replace('#\(/\)#', '/?', $pattern);

        $chars = '[a-zA-Z0-9\_\-]+';

        $pattern = preg_replace('/:(' . $chars . ')/', '(?<$1>' . $chars . ')', $pattern);

        return '@^' . $pattern . '$@D';
    }

    private function _push($method, $url, $callback) {

        array_push($this->_endpoints[$method], array('url' => $url, 'callback' => $callback));  

        return;
    }

    public function init($callback) {

        array_push($this->_initial, $callback);

        return;
    }

    public function get($url, $callback) {

        $this->_push('GET', $url, $callback);

        return;
    }

    public function post($url, $callback) {

        $this->_push('POST', $url, $callback);

        return;
    }

    public function put($url, $callback) {

        $this->_push('PUT', $url, $callback);

        return;
    }

    public function patch($url, $callback) {

        $this->_push('PATCH', $url, $callback);

        return;
    }

    public function delete($url, $callback) {

        $this->_push('DELETE', $url, $callback);

        return;
    }

    public function header($key, $value) {

        header($key . ': ' . $value);

        return;
    }

    public function cookie($key, $value) {

        setcookie($key, $value);

        return;
    }

}

?>