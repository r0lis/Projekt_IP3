<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class EmployeeDeletePage extends CRUDPage
{
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

            $employeeId = filter_input(INPUT_POST, 'employeeId', FILTER_VALIDATE_INT);
            if (!$employeeId)
                throw new BadRequestException();

            //když poslal data
            $success = Employee::deleteByID($employeeId);

            //přesměruj
            $this->redirect(self::ACTION_DELETE, $success);


    }

    protected function pageBody()
    {
        return "";
    }

}

$page = new EmployeeDeletePage();
$page->render();

?>