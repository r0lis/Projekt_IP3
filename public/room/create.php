<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class RoomCreatePage extends CRUDPage
{
    private ?Room $room;
    private ?array $errors = [];
    private int $state;

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            die("You are not authorized to access this page.");
        }
    }

    protected function prepare(): void
    {
        parent::prepare();
        $this->findState();
        $this->title = "Založit novou místnost";


        if ($this->state === self::STATE_FORM_REQUESTED)
        {

            $this->room = new Room();
        }

        elseif($this->state === self::STATE_DATA_SENT) {

            $this->room = Room::readPost();

            $this->errors = [];
            $isOk = $this->room->validate($this->errors);
            if (!$isOk)
            {
                $this->state = self::STATE_FORM_REQUESTED;
            }
            else
            {
               $success = $this->room->insert();

               $this->redirect(self::ACTION_INSERT, $success);
            }
        }
    }

    protected function pageHeader(): string
    {
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
            ['logged' => $logged, 'navigation' => $navigation]
        );
    }

    protected function pageBody()
    {
        return MustacheProvider::get()->render(
            'roomForm',
            [
                'room' => $this->room,
                'errors' => $this->errors
            ]
        );
    }

    private function findState() : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->state = self::STATE_DATA_SENT;
        else
            $this->state = self::STATE_FORM_REQUESTED;
    }
}

$page = new RoomCreatePage();
$page->render();

?>
