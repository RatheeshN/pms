<?php
class ErrorController {
    public function notFound() {
        http_response_code(404);
        echo '404 - Page not found';
    }
}
?>