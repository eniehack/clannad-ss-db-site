<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . "/../vendor/autoload.php";

$container = new Container();
AppFactory::setContainer($container);
$container->set("view", function() {
    return Twig::create(__DIR__ . "/../tpl", ["cache" => __DIR__ . "/../tpl/.cache"]);
});

$app = AppFactory::create();
$app->add(TwigMiddleware::createFromContainer($app));
$app->addErrorMiddleware(true, true, true);

$app->get("/", function (Request $req, Response $resp) {
    return $this->get("view")->render($resp, "index.html", []);
});

$app->run();