<?php

namespace Dagar\Crawler;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Crawler {

    public static function extractRequest(Request $request) {

        $request->requestId = self::MakeRequestId($request);

        $crawledRequest = [
            'path' => $request->path(),
            'fullUrl' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'ip' => $request->ips(),
            'userAgent' => $request->userAgent(),
            'isSecure' => $request->secure(),
            'requestId' => $request->requestId,
            'payload' => $request->all(),
        ];

        try {

            if($request->getSession()) {
                $crawledRequest['session'] = $request->getSession()->all();
            }

        } catch (\Exception $e) {
            $crawledRequest['session'] = [];
        }


        return $crawledRequest;

    }

    public static function extractResponse(Response $response) {

        $crawledRequest = [
            'response' => $response->content(),
            'headers' => $response->headers->all(),
            'status' => $response->status(),
            'exception' => $response->exception,
        ];

        return $crawledRequest;

    }

    public static function MakeJson($object){
        return json_encode($object);
    }

    public static function MakeRequestId($request){
        return sha1(implode('|', array_merge(

            [time(), $request->userAgent()],

            [$request->header('referer'), $request->url(), $request->ip()]

        )));
    }

    public static function dDUMP(...$object){
        ECHO '<pre style="border: 2px black; padding: 10px;">';
        var_dump($object);
        ECHO '</pre> ';

        echo '<script>
        (function(d) {

            stylizePreElements = function() {
              var preElements = document.getElementsByTagName("pre");
              for (i = 0; i < preElements.length; ++i) {
                var preElement = preElements[i];
                preElement.className += "prettyprint";
              }
            };

            injectPrettifyScript = function() {
              var scriptElement = document.createElement("script");
              scriptElement.setAttribute("src", "https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js");
              document.head.appendChild(scriptElement);
            };

            stylizePreElements();
            injectPrettifyScript();

          })(document)
        </script>';
        return $object;
    }

}
