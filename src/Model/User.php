<?php

/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 19:30
 */
namespace Model;

use App\App;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class User
{
    protected $table_name = 'users';
    /** @var  integer */
    protected $id;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $email;
    /** @var string */
    protected $password;
    /** @var string */
    protected $password_repeat;
    /** @var  string */
    protected $salt;
    /** @var  App */
    protected $app;

    function __construct(App $app, Request $request=null){
        $this->salt = md5(time());
        $this->app = $app;
        if($request){
            $this->username = $request->get('username');
            $this->password = $request->get('password');
            $this->password_repeat = $request->get('password_repeat');
            $this->email = $request->get('email');
        }
    }

    /**
     * проверка эквивалентности воода пароля и повторного ввода пароля
     * @return bool
     */
    public function isIsPasswordRepeat()
    {
        return ($this->password_repeat == $this->password);
    }
    /**
     * определение правил валидаторов класса
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Email());
        $metadata->addPropertyConstraint('username', new Assert\NotBlank());
        $metadata->addPropertyConstraint('username', new Assert\Length(['min' => 5, 'max' => 50]));
        $metadata->addPropertyConstraint('password', new Assert\NotBlank());
        $metadata->addPropertyConstraint('password', new Assert\Length(['min' => 5, 'max' => 50]));
        $metadata->addGetterConstraint('isPasswordRepeat', new Assert\IsTrue(array(
            'message' => 'Пароль повторный не совпадает с первым',
            'groups'  => array('Strict'),
        )));
        $metadata->setGroupSequence(array('User', 'Strict'));
    }
    /**
     * проверка наличия юзера в базе, возвращает юзера массив
     * @return bool|mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function isUser(){
        $connection = $this->app->getConnection();
        $sql = "SELECT * FROM {$this->table_name} u where u.username='".$this->username."' limit 1";
        $stmt = $connection->query($sql);
        $row = $stmt->fetch();
        if($row){
            return $row;
        }
        return false;
    }
    /**
     * авторизация пользователя
     * @return $this|bool
     */
    public function login(){
        $row = $this->isUser();
        if($row){
            $password = md5(md5($this->password) . $row['salt']);
            if($password == $row['password']){
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->app->AuthOn($this);
                return $this;
            }
        }
        return null;
    }

    /**
     * регистрация пользователя
     * @return $this|bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function register(){
        $row = $this->isUser();
        if(!$row){
            if($this->password == $this->password_repeat){
                $password = md5(md5($this->password) . $this->salt);
                $sql = "INSERT INTO {$this->table_name} (password, username, email, salt) VALUES ( :password, :username, :email, :salt)";
                $st = $this->app->getConnection()->prepare($sql);
                $st->bindValue(":password", $password);
                $st->bindValue(":username", $this->username);
                $st->bindValue(":email", $this->email);
                $st->bindValue(":salt", $this->salt);
                $st->execute();
                $id = $this->app->getConnection()->lastInsertId();
                $this->id = $id;
                $this->password = $password;
                $this->app->AuthOn($this);
                return $this;
            }
        }

        return null;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getPasswordRepeat()
    {
        return $this->password_repeat;
    }

    /**
     * @param string $password_repeat
     */
    public function setPasswordRepeat($password_repeat)
    {
        $this->password_repeat = $password_repeat;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }
}