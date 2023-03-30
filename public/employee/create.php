<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class EmployeeCreatePage extends CRUDPage
{
    private ?Employee $employee;
    private ?array $errors = [];
    private int $state;

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


            return MustacheProvider::get()->render(
                'employeeForm',
                [
                    'employee' => $this->employee,
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