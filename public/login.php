<?php
require_once __DIR__ . "/../bootstrap/bootstrap.php";

class UserNotFoundException extends Exception {}
class InvalidPasswordException extends Exception {}

class LoginPage extends BasePage
{
    protected ?string $login = null;
    protected ?string $pass = null;
    protected string $errorMessage = '';
    protected string $successMessage = '';

    public function __construct()
    {
        session_start(); // přidáno
        $this->login = filter_input(INPUT_POST,'login');
        $this->pass = filter_input(INPUT_POST,'password');

        if($this->login !== null && $this->pass !== null){
            $stmt = PDOProvider::get()->prepare("SELECT login, admin, employee_id, password AS pass FROM employee WHERE login = :userLogin");
            $stmt->execute(['userLogin' => $this->login]);
            $user = $stmt->fetch();

            try {
                if($user === false) {
                    throw new UserNotFoundException('User not found.');
                }
                if(!password_verify($this->pass, $user->pass)){
                    throw new InvalidPasswordException('Invalid password.');
                }
                $_SESSION['user'] = $user->login;
                $_SESSION['id'] = $user->employee_id;
                $_SESSION["loggedIn"] = true;
                $_SESSION["admin"] = $this->checkAdmin($user);
                $this->successMessage .= '<div class="alert alert-success" role="alert">Login successful.</div>';
                header("Location: index.php");
            } catch (UserNotFoundException $e) {
                $this->errorMessage .=  $e->getMessage();
            } catch (InvalidPasswordException $e) {
                $this->errorMessage .=  $e->getMessage();
            }
        }

        $this->title = "Přihlášení";
    }

    protected function pageBody() :string
    {
        return MustacheProvider::get()->render(
            'loginForm',
            [ 'login' => $this->login,
                'errorMessage' => $this->errorMessage,
                'successMessage' => $this->successMessage
            ]
        );
    }

    protected function pageHeader(): string
    {
        return '<a href="index.php">Zpět na hlavní stránku</a>';
    }

    public function checkAdmin($userName) : bool{
        $stmt = PDOProvider::get()->prepare("SELECT login,admin , password AS pass FROM employee WHERE login = :userLogin");
        $stmt->execute(['userLogin' => $this->login]);
        $row = $stmt->fetch();

        if($row->admin == 1){
            return true;
        }
        return false;
    }
}

$page = new LoginPage();
$page->render();
?>