<?php
require_once __DIR__ . "/../bootstrap/bootstrap.php";

class EmployeesPage extends BasePage
{
    public function __construct()
    {
        $this->title = "Výpis zaměstnanců";
    }

    protected function pageBody()
    {
        //získat data
        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare("SELECT employee.surname, employee.name, employee.job, employee.room, employee.employee_id, room.room_id, room.phone, room.name as roomName FROM employee INNER JOIN room ON employee.room=room.room_id ");
        $stmt->execute();
        $employees = $stmt->fetchAll();

        //prezentovat data
        return MustacheProvider::get()->render('employeeList',['employees' => $employees]);
    }

}

$page = new EmployeesPage();
$page->render();

?>
