<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class EmployeeUpdatePage extends CRUDPage
{
    private ?Employee $employee;
    private ?array $errors = [];
    private int $state;
    private array $allRooms = [];
    private array $mustacheArray = [];

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
        $this->title = "Upravit zaměstnance";

        //když chce formulář
        if ($this->state === self::STATE_FORM_REQUESTED)
        {
            $employeeId = filter_input(INPUT_GET, 'employeeId', FILTER_VALIDATE_INT);
            if (!$employeeId )
                throw new BadRequestException();

            //jdi dál
            $this->employee = Employee::findByID($employeeId );
            if (!$this->employee)
                throw new NotFoundException();

        }

        //když poslal data
        elseif($this->state === self::STATE_DATA_SENT) {
            //načti je
            $this->employee = Employee::readPost();

            //zkontroluj je, jinak formulář
            $this->errors = [];
            $isOk = $this->employee->validate($this->errors);
            if (!$isOk)
            {
                $this->state = self::STATE_FORM_REQUESTED;
            }
            else
            {
                //ulož je
                $success = $this->employee->update();

                //přesměruj
                $this->redirect(self::ACTION_UPDATE, $success);
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
        $this->room = Room::findByID($this->employee->room);
        $stmt = PDOProvider::get()->prepare("SELECT name, room_id FROM room ORDER BY name;");
        $stmt->execute();
        $this->allRooms = $stmt->fetchAll();

        for ($i = 0; $i < count($this->allRooms);$i++){
                array_push($this->mustacheArray, $this->allRooms[$i]);

        }
        $admin = "";
        if($this->employee->admin == 1){
            $admin = "checked";
        }
        return MustacheProvider::get()->render(
            'employeeForm',
            [
                'formHeader' => 'Upravit zaměstnance',
                'homeRoom' => $this->room,
                'employee' => $this->employee,
                'errors' => $this->errors,
                'rooms' => $this->mustacheArray,
                'admin'=> $admin
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

$page = new EmployeeUpdatePage();
$page->render();

?>
