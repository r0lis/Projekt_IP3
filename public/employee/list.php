<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class EmployeesPage extends CRUDPage
{
    private $alert = [];

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            die("You are not authorized to access this page.".$_SESSION['admin']);
        }
        $this->title = "Výpis zaměstnanců";
    }

    protected function prepare(): void
    {
        parent::prepare();
        //pokud přišel výsledek, zachytím ho
        $crudResult = filter_input(INPUT_GET, 'success', FILTER_VALIDATE_INT);
        $crudAction = filter_input(INPUT_GET, 'action');

        if (is_int($crudResult)) {
            $this->alert = [
                'alertClass' => $crudResult === 0 ? 'danger' : 'success'
            ];

            $message = '';
            if ($crudResult === 0)
            {
                $message = 'Operace nebyla úspěšná';
            }
            else if ($crudAction === self::ACTION_DELETE)
            {
                $message = 'Smazání proběhlo úspěšně';
            }
            else if ($crudAction === self::ACTION_INSERT)
            {
                $message = 'Zaměstnanec byl přidán úspěšně ';
            }
            else if ($crudAction === self::ACTION_UPDATE)
            {
                $message = 'Úprava zaměstnance byla úspěšná';
            }

            $this->alert['message'] = $message;
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
        $html = "";
        //zobrazit alert
        if ($this->alert) {
            $html .= MustacheProvider::get()->render('crudResult', $this->alert);
        }
        $stmt = PDOProvider::get()->prepare("
        SELECT 
            employee.surname, 
            employee.employee_id,
            employee.name, 
            employee.job,
            room.phone, 
            room.name AS roomName
        FROM employee
        INNER JOIN room ON employee.room = room.room_id
        ORDER BY employee.surname ASC
    ");

        //získat data
        $stmt->execute([]);
        $employees = $stmt->fetchAll();

        $admin = false;
        if(isset($_SESSION['admin']) && $_SESSION['admin'] === true)  {
            $admin = true;
        }




        //prezentovat data
        $html .= MustacheProvider::get()->render('employeesList',['employees' => $employees,'admin' => $admin]);

        return $html;
    }

}

$page = new EmployeesPage();
$page->render();

?>
