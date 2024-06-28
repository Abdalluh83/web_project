<?php

abstract class User{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $image;
    protected $password;
    public $created_at;
    public $updated_at;

    function __construct($id , $name ,$email, $password,$phone,$image,$created_at,$updated_at){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->image = $image;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }













    public static function login($email,$password){
        $qry ="SELECT * FROM USERS WHERE email = '$email'AND password = '$password'";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        if($arr = mysqli_fetch_assoc($rslt)){
            switch($arr["role"]){
                case 'subscriber':
                    $user = new Subscriber($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["iamge"],$arr["created_at"],$arr["updated_at"]);

                    break;
                case 'admin':
                    $user = new Admin($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["iamge"],$arr["created_at"],$arr["updated_at"]);

                    break;
            }
        }
        mysqli_close($cn);
        return $user;
    }


}


class Subscriber extends User{

    public $role = "subscriber";
    public static function register($name,$email,$password,$phone){
        $qry = "INSERT INTO TABLE USER(name,email,password,phone) VALUES('$name','$email','$password','$phone')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);

        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;

    }


    public function store_post($title , $content , $imageName , $user_id){
        $qry = "INSERT INTO post(title , content , imageName ,user_id )VALUES('$title' , '$content ','$imageName' , '$user_id')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function store_comment($comment,$post_id,  $user_id){
        $qry = "INSERT INTO comment(comment , post_id,user_id ) VALUES('$comment','$post_id',  '$user_id')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function my_posts($user_id){
        $qry = "SELECT * FROM post WHERE user_id = $user_id ORDER BY created_at DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);

        return $data;
    }

    public function update_profile_pic($imagePath , $user_id){
        $qry = "UPDATE users SET image = '$imagePath' WHERE id = $user_id";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function get_post_comment($post_id){
        $qry = "SELECT * FROM COMMENTS WHERE POST_ID = $post_id ORDER BY CREATED_AT DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);

        return $data;

    }





}

class Admin extends User{

    public $role = "admin";

}



?>