<?php
require_once __DIR__ . "/../bootstrap/bootstrap.php";

class PasswordChangePage extends BasePage
{
    protected ?string $errorMessage = null;
    protected ?string $successMessage = null;

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
            header("Location: login.php");
            exit();
        }

        $this->errorMessage = '';
        $this->successMessage = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $currentPassword = filter_input(INPUT_POST, 'current_password');
            $newPassword = filter_input(INPUT_POST, 'new_password');
            $confirmPassword = filter_input(INPUT_POST, 'confirm_password');

            $stmt = PDOProvider::get()->prepare("SELECT password AS pass FROM employee WHERE login = :userLogin");
            $stmt->execute(['userLogin' => $_SESSION['user']]);
            $user = $stmt->fetch();

            if (!password_verify($currentPassword, $user->pass)) {
                $this->errorMessage .= '<div class="alert alert-danger" role="alert">The current password is incorrect.</div>';
            } elseif ($newPassword != $confirmPassword) {
                $this->errorMessage .= '<div class="alert alert-danger" role="alert">The new password and confirm password do not match.</div>';
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = PDOProvider::get()->prepare("UPDATE employee SET password = :newPass WHERE login = :userLogin");
                $stmt->execute(['newPass' => $hashedPassword, 'userLogin' => $_SESSION['user']]);
                $this->successMessage .= '<div class="alert alert-success" role="alert">Password has been changed.</div>';
            }
        }

        $this->title = "Změna hesla";
    }

    protected function pageBody(): string
    {
        return '
        <form method="post" class="my-form">
            <div class="mb-3">
                <label for="current_password" class="form-label">Aktuální heslo:</label>
                <input type="password" id="current_password" name="current_password" class="form-control" style="width: 300px;" required/>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Nové heslo:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" style="width: 300px;" required/>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Potvrďte nové heslo:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" style="width: 300px;" required/>
            </div>
            '.$this->errorMessage.'
            '.$this->successMessage.'
            <button type="submit" class="btn btn-primary">Změnit heslo</button>
        </form>
    ';
    }

    protected function pageHeader(): string
    {
        return '<a href="index.php">Zpět na hlavní stránku</a>';
    }
}

$page = new PasswordChangePage();
$page->render();