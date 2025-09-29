# Verificar o Seguinte erro do PHP


>[25-Sep-2025 22:30:16 Europe/Berlin] PHP Fatal error:  Uncaught Pecee\SimpleRouter\Exceptions\NotFoundHttpException: Route "/thoughts/confirm/" or method "post" not allowed. in /opt/lampp/htdocs/thoughts/vendor/pecee/simple-router/src/Pecee/SimpleRouter/Router.php:452
>Stack trace:
>#0 /opt/lampp/htdocs/thoughts/vendor/pecee/simple-router/src/Pecee/SimpleRouter/Router.php(353): Pecee\SimpleRouter\Router->routeRequest()
>#1 /opt/lampp/htdocs/thoughts/vendor/pecee/simple-router/src/Pecee/SimpleRouter/SimpleRouter.php(69): Pecee\SimpleRouter\Router->start()
>#2 /opt/lampp/htdocs/thoughts/index.php(11): Pecee\SimpleRouter\SimpleRouter::start()
>#3 {main}
>  thrown in /opt/lampp/htdocs/thoughts/vendor/pecee/simple-router/src/Pecee/SimpleRouter/Router.php on line 452

[ X ] Problema resolvido 


----

[ x ] Verificar porque, após a confirmação do código, uma tela branca aparece e o usuário não é cadastrado. 
[ ] Verificar o debug com as variáveis nas sessions.