<?php
require_once __DIR__ . "/../bootstrap/bootstrap.php";

class IndexPage extends BasePage
{
    public function __construct()
    {
        session_start(); // přidáno
        $this->title = "Prohlížeč databáze firmy";
    }

    protected function pageHeader(): string{
        $logged = false;
        if (isset($_SESSION['user'])) {
            $logged = true;
        }
        $navigation = '';
        if ($logged) {
            $navigation = MustacheProvider::get()->render(
                'header',
                ['logged' => true]
            );
        }

        return MustacheProvider::get()->render(
            'header',
            ['logged' => $logged, 'navigation' => $navigation,]
        );
    }

    protected function pageBody()
    {
        if(isset($_SESSION['user'])) {
            echo 'Uživatel ' . $_SESSION['user'] . ' je přihlášen.';
            if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                echo ' Je admin.';
            }

        } else {
            echo 'Uživatel není přihlášen, pro přístup do databáze se přihlašte.';
        }



    }
}

$page = new IndexPage();
$page->render();
?>