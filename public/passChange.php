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
                $this->errorMessage .= 'The current password is incorrect';
            } elseif ($newPassword != $confirmPassword) {
                $this->errorMessage .= 'The new password and confirm password do not match.';
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = PDOProvider::get()->prepare("UPDATE employee SET password = :newPass WHERE login = :userLogin");
                $stmt->execute(['newPass' => $hashedPassword, 'userLogin' => $_SESSION['user']]);
                $this->successMessage .= 'Password has been changed';
            }
        }

        $this->title = "Změna hesla";
    }

    protected function pageBody(): string
    {
        $error = '';
        if (!empty($this->errorMessage)) {
            $error =  $this->errorMessage;
        }

        $successMessage = '';
        if (!empty($this->successMessage)) {
            $successMessage =  $this->successMessage;
        }
        return MustacheProvider::get()->render(
            'passChange',
            ['error' => $error, 'successMessage' => $successMessage]
        );
    }

    protected function pageHeader(): string
    {
        return '<a href="index.php">Zpět na hlavní stránku</a>';
    }
}

$page = new PasswordChangePage();
$page->render();