<?php
require_once('../src/vendor/autoload.php');

// imports
use GBV\Kernel;
use GBV\Pica\Field;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

try {
    // global
    $kernel = new Kernel();
    $request = Request::createFromGlobals();
    $response = new JsonResponse();

    // Check http method.
    $method = $request->getMethod();
    if ($method != 'GET') {
        throw new \Exception('', 405);
    }

    // Check path info if empty load full list, else small block
    $field = new Field($request->getPathInfo(), $kernel->getDB());
    if ($field->isPica3()) {
        $url = rtrim($request->getBaseUrl(), '/').'/' . $field->getName();
        $response = new RedirectResponse($url);
    } else {
        $response->setData($field->getData());
    }
} catch (\Exception $e) {
    $code = $e->getCode();
    if (isset(JsonResponse::$statusTexts[$code])) {
        $message = JsonResponse::$statusTexts[$code];
    } else {
        $code = 503;
        $message = JsonResponse::$statusTexts[$code];
    }

    $response->setStatusCode($code);
    $response->setData(['error' => ['code' => $code, 'message' => $message]]);
}

// send response
$response->headers->set('Access-Control-Allow-Origin', '*');
$response->prepare($request);
$response->send();
