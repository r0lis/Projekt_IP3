<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class EmployeeDetailPage extends BasePage
{
    private $room;
    private $employees;

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            die("You are not authorized to access this page.".$_SESSION['admin']);
        }

    }




    protected function prepare(): void
    {
        parent::prepare();
        //získat data z GET
        $employeeId = filter_input(INPUT_GET, 'employeeId', FILTER_VALIDATE_INT);
        if (!$employeeId)
            throw new BadRequestException();

        //najít místnost v databázi
        $this->employee = Employee::findByID($employeeId);
        if (!$this->employee)
            throw new NotFoundException();


        $stmt = PDOProvider::get()->prepare("SELECT employee.surname, employee.name, employee.job, employee.room,employee.wage, employee.employee_id, room.room_id, room.phone, room.name as roomName  From employee  INNER JOIN room ON employee.room=room.room_id WHERE employee_id=:employee_id");
        $stmt->execute(['employee_id' => $employeeId]);
        $this->employees = $stmt->fetchAll();

        $stmtKlic = PDOProvider::get()->prepare("SELECT room.name, room.room_id FROM `key` klic JOIN room ON klic.room = room.room_id WHERE klic.employee =:employeeId ORDER BY room.name");
        $stmtKlic->execute(['employeeId' => $employeeId]);
        $this->keys = $stmtKlic->fetchAll();

        $this->title = "Karta osoby: {$this->employee->name}";

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
        //prezentovat data
        return MustacheProvider::get()->render(
            'employeeDetail',
            ['employees' => $this->employees, 'keys'=> $this->keys]
        );
    }

}

$page = new EmployeeDetailPage();
$page->render();

?>
