<?php

class LoginAction extends Action {
	public function index() {
		
		// 配置页面显示内容
		$this->assign ( 'title', '后台管理系统' );
		$this->display ();
	}
	
	// 用户登录页面
	public function login() {
		header('Content-type: application/json');
		$obj = json_decode(file_get_contents('php://input'),true);
		
		$user_dao = M ( 'User' ); // 参数的User必须首字母大写，否则自动验证功能失效！	
		$email = $obj['email'];
		$password = $obj ['password'];
		
		// 查找输入的用户名是否存在
		$condition ['email'] = $email;
		$condition ['password'] = $password;
		
		$user = $user_dao->where ( $condition )->find ();
		
		if ($user) {
            $sid=session_id();
            if($sid=='') {
                session_start();
				$_SESSION ['user'] = $user;
            
				$msg="Succeeded!";
				$arr=array("msg"=>$msg,"uid"=>$uid);
				$send = json_encode($arr);
				echo $send;
            }
            else{
                $msg="This user has already loged in!";
                $arr=array("msg"=>$msg);
				$send=json_encode($arr);
				echo $send;
            }
		} else {
			$msg="Email or password is wrong!";
            $arr=array("msg"=>$msg);
			$send=json_encode($arr);
			echo $send;
		}
	}
	
	public function logout() {
		unset ( $_SESSION ['user'] );
		$msg="Loged out!";
		$arr=array("msg"=>$msg);
		$send = json_encode($arr);
		echo $send;
	}
}
?>
