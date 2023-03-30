<?php
require_once __DIR__ . "/../bootstrap/bootstrap.php";

class RoomsPage extends BasePage
{
    public function __construct()
    {
        $this->title = "Výpis místností";
    }

    protected function pageBody()
    {
        //získat data
        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare("SELECT * FROM `room`");
        $stmt->execute();
        $rooms = $stmt->fetchAll();

        //prezentovat data
        return MustacheProvider::get()->render('roomList',['rooms' => $rooms]);
    }

}

$page = new RoomsPage();
$page->render();

?>