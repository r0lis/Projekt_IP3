<?php

class Employee
{
    public const DB_TABLE = "employee";

    public ?int  $employee_id;
    public ?string $name;
    public ?string $surname;
    public ?int $wage;
    public ?string $job;
    public ?int $room;
    public ?string $login;
    public ?string $password;
    public ?bool $admin;

    public function __construct(?int $employee_id = null, ?string $name = null, ?string $surname = null, ?int $wage = null, ?string $job = null,?int $room = null, ?string $login = null, ?string $password = null, ?bool $admin = null)
    {
        $this->employee_id = $employee_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->wage = $wage;
        $this->room = $room;
        $this->job = $job;
        $this->login = $login;
        $this->password = $password;
        $this->admin = $admin;
    }

    public static function findByID(int $id) : ?self
    {
        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare("SELECT * FROM `".self::DB_TABLE."` WHERE `employee_id`= :employeeId");
        $stmt->execute(['employeeId' => $id]);

        if ($stmt->rowCount() < 1)
            return null;

        $employee = new self();
        $employee->hydrate($stmt->fetch());
        return $employee;
    }

    public static function getAll($sorting = []) : array
    {
        $sortSQL = "";
        if (count($sorting))
        {
            $SQLchunks = [];
            foreach ($sorting as $field => $direction)
                $SQLchunks[] = "`{$field}` {$direction}";

            $sortSQL = " ORDER BY " . implode(', ', $SQLchunks);
        }

        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare("SELECT * FROM `".self::DB_TABLE."`" . $sortSQL);
        $stmt->execute([]);

        $employees = [];
        while ($employeeData = $stmt->fetch())
        {
            $employee = new Employee();
            $employee->hydrate($employeeData);
            $employees[] = $employee;
        }

        return $employees;
    }

    private function hydrate(array|object $data)
    {
        $fields = ['employee_id', 'name', 'surname', 'job', 'wage', 'room', 'login', 'password', 'admin'];
        if (is_array($data))
        {
            foreach ($fields as $field)
            {
                if (array_key_exists($field, $data))
                    $this->{$field} = $data[$field];
            }
        }
        else
        {
            foreach ($fields as $field)
            {
                if (property_exists($data, $field))
                    $this->{$field} = $data->{$field};
            }
        }
    }
    public function insert() : bool
    {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . self::DB_TABLE . " (`name`, `surname`, `job`, `wage`, `room`, `login`, `password`, `admin`) VALUES (:name, :surname, :job, :wage, :room, :login, :password, :admin)";
        $stmt = PDOProvider::get()->prepare($query);
        if ($this->admin == 'on') {
            $admin = 1;
        } else {
            $admin = 0;
        }
        $result = $stmt->execute(['name'=>$this->name, 'surname'=>$this->surname, 'job'=>$this->job, 'wage'=>$this->wage, 'room'=>$this->room, 'login'=>$this->login,'password' => $hashedPassword,'admin'=>$admin  ]);
        if (!$result)
            return false;
        if (empty($this->password)) {
            throw new Exception("Password cannot be empty");
        }

        $this->employee_id = PDOProvider::get()->lastInsertId();
        return true;
    }


    public function update() : bool
    {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        if (!isset($this->employee_id) || !$this->employee_id)
            throw new Exception("Cannot update model without ID");

        $query = "UPDATE ".self::DB_TABLE." SET `name` = :name, `surname` = :surname, `job` = :job, `wage` = :wage, `room` = :room, `login` = :login, `password` = :password, `admin` = :admin WHERE `employee_id` = :employee_id";
        $stmt = PDOProvider::get()->prepare($query);

        if ($this->admin == 'on') {
            $admin = 1;
        } else {
            $admin = 0;
        }

        return $stmt->execute(['name' => $this->name,
            'surname' => $this->surname,
            'job' => $this->job,
            'wage' => $this->wage,
            'room' => $this->room,
            'login' => $this->login,
            'password' => $hashedPassword,
            'admin'=>$admin,
            'employee_id' => $this->employee_id,]);
    }

    public static function readPost() : self
    {
        $employee = new Employee();
        $employee->employee_id = filter_input(INPUT_POST, 'employee_id', FILTER_VALIDATE_INT);

        $employee->name = filter_input(INPUT_POST, 'name');
        if ($employee->name)
            $employee->name = trim($employee->name);

        $employee->surname = filter_input(INPUT_POST, 'surname');
        if ($employee->surname)
            $employee->surname = trim($employee->surname);

        $employee->job = filter_input(INPUT_POST, 'job');
        if ($employee->job)
            $employee->job = trim($employee->job);

        $employee->wage = filter_input(INPUT_POST, 'wage');
        if ($employee->wage)
            $employee->wage = trim($employee->wage);

        $employee->room = filter_input(INPUT_POST, 'room');
        if ($employee->room)
            $employee->room = trim($employee->room);

        $employee->login = filter_input(INPUT_POST, 'login');
        if ($employee->login)

            $employee->login = trim($employee->login);

        $employee->password = filter_input(INPUT_POST, 'password');
        if ($employee->password)
            $employee->password = trim($employee->password);
        $employee->admin = filter_input(INPUT_POST, 'admin');
        if ($employee->admin)
            $employee->admin = trim($employee->admin);



        return $employee;
    }

    public function validate(&$errors = []) : bool
    {
        if (!isset($this->name) || (!$this->name))
            $errors['name'] = 'Jméno nesmí být prázdné';

        if (!isset($this->surname) || (!$this->surname))
            $errors['surname'] = 'surname musí být vyplněno';

        return count($errors) === 0;
    }

    public function delete() : bool
    {
        return self::deleteByID($this->employee_id);
    }

    public static function deleteByID(int $employeeId) : bool
    {
        $stmt = PDOProvider::get()->prepare("SELECT `key_id` FROM `key` WHERE employee = :employeeId");
        $stmt->execute(['employeeId' => $employeeId]);
        while($key = $stmt->fetch()){
            Key::deleteByID($key->key_id);
        }
        $query = "DELETE FROM `".self::DB_TABLE."` WHERE `employee_id` = :employeeId";
        $stmt = PDOProvider::get()->prepare($query);
        return $stmt->execute(['employeeId'=>$employeeId]);
    }





}