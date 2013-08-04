<?php
class RegisterAction extends Action{
  public function index(){
		
		//配置页面显示内容
		$this->assign('title','后台管理系统');
		$this->display();
	}
	public function register() {	
		header('Content-type: application/json');
		$obj = json_decode(file_get_contents('php://input'),true);
        
      	if($obj==null){
			$msg="There is nothing in your form!";
			$arr=array("msg"=>$msg);
			$send = json_encode($arr);
			echo $send;
			return;
		}
		
		$user_dao = M ( "User" );
		$email = $obj ['email'];
		$password = $obj ['password'];
		
		$condition ['email'] = $email;
		if ($user_dao->where ( $condition )->select ()) {
			$msg="This email has been registered!";
			$arr=array("msg"=>$msg);
			$send = json_encode($arr);
			echo $send;
			return;
		}
		
		$user['email'] = $email;
		$user['password'] = $password;
		
		$id = $user_dao->add($user);
		if($id){
			$user['id'] = $id;
		
			$_SESSION ['user'] = $user;
            $uid=$_SESSION['user']['id'];
		
			$msg="Registered successfully!";
			$arr=array("msg"=>$msg,"uid"=>$uid);
			$send = json_encode($arr);
			echo $send;
		}
		else{
			$msg="Register failed!";
			$arr=array("msg"=>$msg);
			$send = json_encode($arr);
			echo $send;
		}
	}
}
?>
