<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class EmployeeCreatePage extends CRUDPage
{
    private ?Employee $employee;
    private ?array $errors = [];
    private int $state;
    private $keys;

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            die("You are not authorized to access this page.".$_SESSION['admin']);
        }
    }



    protected function prepare(): void
    {

        parent::prepare();
        $this->findState();
        $this->title = "Zapsat nového zaměstnance";

        //když chce formulář
        if ($this->state === self::STATE_FORM_REQUESTED)
        {
            //jdi dál
            $this->employee = new Employee();

            $stmtRoom = PDOProvider::get()->prepare("SELECT room_id, no, name FROM room ORDER BY no ASC");
            $stmtRoom->execute([]);
            while ($room = $stmtRoom->fetch())
            {
                $this->rooms[] = [
                    'room_id' => $room->room_id,
                    'no' => $room->no,
                    'name' => $room->name,
                    'selected' => $room->room_id == $this->employee->room
                ];
            }
        }

        //když poslal data
        elseif($this->state === self::STATE_DATA_SENT) {
            //načti je
            $this->employee = Employee::readPost();

            //zkontroluj je, jinak formulářss
            $this->errors = [];
            $isOk = $this->employee->validate($this->errors);
            if (!$isOk)
            {
                $this->state = self::STATE_FORM_REQUESTED;
            }
            else
            {
                //ulož je
                $success = $this->employee->insert();

                if($this->keys !== null){
                    foreach ($this->keys AS $room_id){
                        $key = new Key($room_id, $this->employee->employee_id);
                        $key->insert();
                    }
                }

                //přesměruj
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


        $stmt = PDOProvider::get()->prepare("SELECT name, room_id FROM ". Room::DB_TABLE ." ORDER BY name;");
        $stmt->execute();
        $this->allRooms = $stmt->fetchAll();
        return MustacheProvider::get()->render(
            'employeeForm',
            [
                'formHeader' => 'Založit zaměstnance',
                'employee' => $this->employee,
                'rooms' => $this->allRooms,
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

$page = new EmployeeCreatePage();
$page->render();

?>